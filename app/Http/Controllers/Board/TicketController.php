<?php

namespace App\Http\Controllers\Board;

use App\Exceptions\IsNotPassedDayException;
use App\Exceptions\TicketHaveManagerException;
use App\Http\Controllers\Controller;
use App\Mail\CloseTicketNotice;
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
        $authUser = Auth::user();

        if ($authUser->role === 'user') {
            if ($ticket->manager_id !== null) {
                $managers = User::where('id', $ticket->manager_id)->get();
                foreach ($managers as $manager) {
                    Mail::to($manager->email)->queue(new CloseTicketNotice($ticket, $authUser));
                }
            }
        } else {
            if ($ticket->manager_id !== null) {
                $user = User::where('id', $ticket->author_id)->first();
                Mail::to($user->email)->queue(new CloseTicketNotice($ticket, $authUser));
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
