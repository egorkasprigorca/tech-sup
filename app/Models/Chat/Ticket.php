<?php

namespace App\Models\Chat;

use App\Models\User;
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
        'ticket_status' => 'inactive'
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

    public static function changeTicketStatus(User $user, int $ticketId)
    {
        $ticket = Ticket::find($ticketId);
        if ($ticket->isInactive() && $user->isManager()) {
            $ticket->ticket_status = 'active';
            $ticket->save();
        }
    }

    public static function createTicket(array $fields)
    {
        $ticket = Ticket::create([
            'ticket_subject' => $fields['ticket_subject'],
            'ticket_text' => $fields['ticket_text'],
            'author_id' => Auth::id(),
        ]);
        return $ticket;
    }
}
