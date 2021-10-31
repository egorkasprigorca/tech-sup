<?php

namespace App\Http\Controllers\Board;

use App\Http\Controllers\Controller;
use App\Models\Chat\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class BoardController extends Controller
{
    public function viewBoard()
    {
        if (Gate::allows('get-tickets')) {
            return view('board/board', [
                'tickets' => Ticket::all(),
                'user' => Auth::user(),
                'isManager' => true,
                'boardStatus' => 'default',
                'boardName' => 'Все заявки'
            ]);
        } else {
            return view('board/board', [
                'tickets' => Ticket::all()->where('author_id', Auth::id()),
                'user' => Auth::user(),
                'isManager' => false,
                'boardStatus' => 'default',
                'boardName' => 'Все заявки'
            ]);
        }
    }
}
