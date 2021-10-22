<?php

namespace App\Http\Controllers\Board;

use App\Http\Controllers\Controller;
use App\Jobs\ProcessDispatchTicketNotification;
use App\Mail\DispatchTicketNotice;
use App\Models\Chat\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class TicketController extends Controller
{
    public function createTicket(Request $request)
    {
        $fields = $request->validate([
            'ticket_subject' => 'required',
            'ticket_text' => 'required'
        ]);

        $ticket = Ticket::createTicket($fields);

        ProcessDispatchTicketNotification::dispatch($ticket);

        return redirect('/board');
    }

    public function closeTicket(int $id)
    {
        Ticket::destroy($id);

        return redirect('/board');
    }
}
