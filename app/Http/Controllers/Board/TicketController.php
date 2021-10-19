<?php

namespace App\Http\Controllers\Board;

use App\Http\Controllers\Controller;
use App\Models\Chat\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function createTicket(Request $request)
    {
        $fields = $request->validate([
            'ticket_subject' => 'required',
            'ticket_text' => 'required'
        ]);

        Ticket::createTicket($fields);

        return redirect('/board');
    }

    public function closeTicket(int $id)
    {
        Ticket::destroy($id);

        return redirect('/board');
    }
}
