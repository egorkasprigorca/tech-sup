<?php

namespace App\Models\Chat;

use App\Exceptions\IsNotPassedDayException;
use App\Exceptions\TicketHaveManagerException;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_subject',
        'ticket_text',
        'author_id'
    ];

    protected $attributes = [
        'ticket_status' => 'inactive',
        'ticket_watched_status' => 'unwatched',
        'manager_id' => null
    ];

    /**
     * Get messages for ticket.
     */
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function isInactive(): bool
    {
        return $this->getAttribute('ticket_status') === 'inactive';
    }

    public function isWatched(): bool
    {
        return $this->getAttribute('ticket_watch_status') === 'watched';
    }

    public static function changeTicketStatus(User $user, int $ticketId)
    {
        $ticket = Ticket::find($ticketId);
        if ($ticket->isInactive() && $user->isManager()) {
            $ticket->ticket_status = 'active';
            $ticket->save();
        }
    }

    public static function makeTicket(array $fields)
    {
        $ticket = Ticket::create([
            'ticket_subject' => $fields['ticket_subject'],
            'ticket_text' => $fields['ticket_text'],
            'author_id' => Auth::id(),
        ]);

        return $ticket;
    }

    public static function createTicket(array $fields, User $user)
    {
        if ($user->ticket_time === null) {
            $ticket = Ticket::makeTicket($fields);
            $user->setTicketTime();
            return $ticket;
        } else if ($user->isPassedDay()) {
            $ticket = Ticket::makeTicket($fields);
            $user->setTicketTime();
            return $ticket;
        } else {
            throw new IsNotPassedDayException('Вы можете отправить заявку через '.
                24 - $user->ticket_time->diffInHours(Carbon::now()->toDateTimeString()) . ' часов');
        }
    }

    public static function changeWatchedTicketStatus(Ticket $ticket)
    {
        if ($ticket->manager_id !== null && $ticket->ticket_watched_status === 'watched') {
            throw new TicketHaveManagerException('Эта заявка уже имеет менеджера');
        } else {
            $ticket->manager_id = Auth::id();
            $ticket->ticket_watched_status = 'watched';
            $ticket->ticket_status = 'active';
            $ticket->save();
        }
    }

    public function closeTicket()
    {
        if ($this->ticket_status !== 'closed') {
            $this->ticket_status = 'closed';
            $this->save();
        }
    }
}
