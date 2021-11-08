<?php

namespace App\Http\Controllers\Board;

use App\Exceptions\IsNotPassedDayException;
use App\Exceptions\TicketHaveManagerException;
use App\Http\Controllers\Controller;
use App\Jobs\ProcessCloseTicketNotification;
use App\Jobs\ProcessDispatchTicketNotification;
use App\Mail\CloseTicketNotice;
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

            $managers = User::where('role', 'manager')->get();
            foreach ($managers as $manager) {
                $manager->sendLoginLink($ticket->id);
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
            $manager = User::where('id', $ticket->manager_id)->get();
            foreach ($manager as $manage) {
                Mail::to($manage->email)->queue(new CloseTicketNotice($ticket, Auth::user()));
            }
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
        return redirect('/board/' . $id . '/chat');
    }
}
