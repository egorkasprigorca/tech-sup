<?php

namespace App\Models\Chat;

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

    public static function createTicket(array $fields)
    {
        Ticket::create([
            'ticket_subject' => $fields['ticket_subject'],
            'ticket_text' => $fields['ticket_text'],
            'author_id' => Auth::id(),
        ]);
    }
}
