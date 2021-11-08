<?php

namespace App\Models\Chat;

use App\Exceptions\OtherManagerTicketException;
use App\Exceptions\TicketAlreadyClosedException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'message_text',
        'ticket_id',
        'message_sender'
    ];

    public static function createMessage(array $fields, int $ticketId)
    {
        $ticket = Ticket::find($ticketId);
        $user = Auth::user();
        if ($ticket->ticket_status === 'closed')
        {
            throw new TicketAlreadyClosedException('Вы не можете ответить на закрытую заявку');
        }
        if ($ticket->ticket_watched_status === 'unwatched') {
            Ticket::changeWatchedTicketStatus($ticket);
        }
        if ($user->role === 'manager' and $ticket->manager_id !== $user->id) {
            throw new OtherManagerTicketException('Другой менеджер уже работает с данной заявкой');
        }


        Message::create([
            'message_text' => $fields['message'],
            'ticket_id' => $ticketId,
            'message_sender' => Auth::user()->name
        ]);

        Ticket::changeTicketStatus(Auth::user(), $ticketId);
    }
}
