<?php

namespace App\Http\Controllers\Board;

use App\Http\Controllers\Controller;
use App\Libraries\Filters\TicketsFilter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class TicketsFilterController extends Controller
{
    public function viewed()
    {
        if (!Gate::allows('get-tickets')) {
            return ('403');
        }
        return view('board/board', [
            'tickets' => TicketsFilter::getWatchedTickets(),
            'user' => Auth::user(),
            'isManager' => true,
            'boardStatus' => 'noDefault',
            'boardName' => 'Просмотренные'
        ]);
    }

    public function unViewed()
    {
        if (!Gate::allows('get-tickets')) {
            return ('403');
        }
        return view('board/board',[
            'tickets' => TicketsFilter::getUnWatchedTickets(),
            'user' => Auth::user(),
            'isManager' => true,
            'boardStatus' => 'noDefault',
            'boardName' => 'Непросмотренные'
        ]);
    }

    public function closed()
    {
        if (!Gate::allows('get-tickets')) {
            return ('403');
        }
        return view('board/board', [
            'tickets' => TicketsFilter::getClosedTickets(),
            'user' => Auth::user(),
            'isManager' => true,
            'boardStatus' => 'noDefault',
            'boardName' => 'Закрытые'
        ]);
    }

    public function unClosed()
    {
        if (!Gate::allows('get-tickets')) {
            return ('403');
        }
        return view('board/board',[
            'tickets' => TicketsFilter::getUnClosedTickets(),
            'user' => Auth::user(),
            'isManager' => true,
            'boardStatus' => 'noDefault',
            'boardName' => 'Незакрытые'
        ]);
    }

    public function answered()
    {
        if (!Gate::allows('get-tickets')) {
            return ('403');
        }
        return view('board/board', [
            'tickets' => TicketsFilter::getAnsweredTickets(),
            'user' => Auth::user(),
            'isManager' => true,
            'boardStatus' => 'noDefault',
            'boardName' => 'Есть ответ'
        ]);
    }

    public function nonAnswered()
    {
        if (!Gate::allows('get-tickets')) {
            return ('403');
        }
        return view('board/board',[
            'tickets' => TicketsFilter::getNonAnsweredTickets(),
            'user' => Auth::user(),
            'isManager' => true,
            'boardStatus' => 'noDefault',
            'boardName' => 'Нет ответа'
        ]);
    }
}
