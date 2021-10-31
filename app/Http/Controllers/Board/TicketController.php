<?php

namespace App\Http\Controllers\Board;

use App\Exceptions\IsNotPassedDayException;
use App\Exceptions\TicketHaveManagerException;
use App\Http\Controllers\Controller;
use App\Jobs\ProcessCloseTicketNotification;
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

        try {
            $ticket = Ticket::createTicket($fields, Auth::user());

            if ($ticket !== null) {
                ProcessDispatchTicketNotification::dispatch($ticket);
            }
        } catch (IsNotPassedDayException $exception) {
            return redirect('board')->withError($exception->getMessage())->withInput();
        }

        return redirect('/board');
    }

    public function closeTicket(int $id)
    {
        $ticket = Ticket::find($id);
        if ($ticket->manager_id !== null) {
            ProcessCloseTicketNotification::dispatch($ticket);
        }

        $ticket->closeTicket();

        return redirect('/board');
    }

    public function takeTicket(int $id)
    {
        try {
            $ticket = Ticket::changeWatchedTicketStatus(Ticket::find($id));
        } catch (TicketHaveManagerException $exception) {
            return redirect('board')->withError($exception->getMessage())->withInput();
        }
        return redirect('/board');
    }
}
