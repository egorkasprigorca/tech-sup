<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use App\Jobs\ProcessSendMessageNotice;
use App\Models\Chat\Message;
use App\Models\Chat\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function createMessage(Request $request, int $ticketId)
    {
        $fields = $request->validate([
            'message' => 'required'
        ]);

        if (!Auth::user()->isManager()) {
            ProcessSendMessageNotice::dispatch(Ticket::find($ticketId));
        }

        Message::createMessage($fields, $ticketId);

        return redirect('board/' . $ticketId . '/chat');
    }
}
