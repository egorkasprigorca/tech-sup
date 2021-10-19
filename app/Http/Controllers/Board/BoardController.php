<?php

namespace App\Http\Controllers\Board;

use App\Http\Controllers\Controller;
use App\Models\Chat\Ticket;
use Illuminate\Http\Request;

class BoardController extends Controller
{
    public function viewBoard()
    {
        return view('board/board', [
            'tickets' => Ticket::all()
        ]);
    }
}
