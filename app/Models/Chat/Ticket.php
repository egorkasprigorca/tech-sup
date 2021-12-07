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

    protected $dates = [
        'created_at'
    ];

    /**
     * Get messages for ticket.
     */
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function isInactive(): bool
    {
        return $this->getAttribute('ticket_status') === 'inactive';
    }

    public function isWatched(): bool
    {
        return $this->getAttribute('ticket_watch_status') === 'watched';
    }

    public function isPassedDay($ticketForCheck): bool
    {
        $currentTime = Carbon::now()->toDateString();

        $ticketTime = Carbon::parse($ticketForCheck->created_at);
        $diff = $ticketTime->diffInHours($currentTime);
        return $diff >= 24;
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
        $ticketForCheck = Ticket::where('author_id', $user->id)
            ->where('ticket_status', '!=', 'closed')
            ->latest()->first();

        if ($ticketForCheck === null) {
            $ticket = Ticket::makeTicket($fields);
            return $ticket;
        } else if ($ticketForCheck->created_at === null) {
            $ticket = Ticket::makeTicket($fields);
            return $ticket;
        } else if ($ticketForCheck->isPassedDay($ticketForCheck)) {
            $ticket = Ticket::makeTicket($fields);
            return $ticket;
        } else {
            throw new IsNotPassedDayException('Вы можете отправить заявку через '.
                24 - $ticketForCheck->created_at->diffInHours(Carbon::now()->toDateTimeString()) . ' часов');
        }
    }

    public static function changeWatchedTicketStatus(Ticket $ticket)
    {
        if ($ticket->ticket_watched_status === 'watched') {
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
