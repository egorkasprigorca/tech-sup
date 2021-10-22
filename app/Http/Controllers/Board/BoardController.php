<?php

namespace App\Http\Controllers\Board;

use App\Http\Controllers\Controller;
use App\Models\Chat\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BoardController extends Controller
{
    public function viewBoard()
    {
        return view('board/board', [
            'tickets' => Ticket::all()->where('author_id', Auth::id()),
            'user' => Auth::user()
        ]);
    }
}
