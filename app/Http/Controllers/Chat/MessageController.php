<?php

namespace App\Http\Controllers\Chat;

use App\Exceptions\OtherManagerTicketException;
use App\Exceptions\TicketAlreadyClosedException;
use App\Http\Controllers\Controller;
use App\Jobs\ProcessSendMessageNotice;
use App\Mail\SendMessageNotice;
use App\Models\Chat\Message;
use App\Models\Chat\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class MessageController extends Controller
{
    public function createMessage(Request $request, int $ticketId)
    {
        try {
            $fields = $request->validate([
                'message' => 'required'
            ]);

            $ticket = Ticket::find($ticketId);
            $manager = User::where('id', $ticket->manager_id)->get();

            Message::createMessage($fields, $ticketId);

            if (!Auth::user()->isManager()) {
                foreach ($manager as $manag) {
                    Mail::to($manag->email)->queue(new SendMessageNotice($ticket, Auth::user()));
                }
            } else {
                $user = $ticket->user;
                foreach ($manager as $manag) {
                    Mail::to($user->email)->queue(new SendMessageNotice($ticket, Auth::user()));
                }
            }

        } catch (TicketAlreadyClosedException $exception) {
            return redirect('board/' . $ticketId . '/chat')->withError($exception->getMessage())->withInput();
        }
        catch (OtherManagerTicketException $exception2) {
            return redirect('board/' . $ticketId . '/chat')->withError($exception2->getMessage())->withInput();
        }

        return redirect('board/' . $ticketId . '/chat');
    }
}
