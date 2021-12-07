<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

class CloseTicketNotice extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $ticket;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($ticket, $user)
    {
        $this->ticket = $ticket;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject(
            config('app.name') . ' close ticket'
        )->markdown('emails/close_ticket_notice', [
            'url' => url('/') . '/board/' . $this->ticket->id . '/chat'
        ]);
    }
}
