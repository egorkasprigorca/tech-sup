<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use App\Models\Chat\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function createMessage(Request $request, int $ticketId)
    {
        $fields = $request->validate([
            'message' => 'required'
        ]);

        Message::createMessage($fields, $ticketId);

        return redirect('board/' . $ticketId . '/chat');
    }
}
