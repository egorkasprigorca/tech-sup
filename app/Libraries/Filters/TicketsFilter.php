<?php

namespace App\Libraries\Filters;

use App\Models\Chat\Ticket;

class TicketsFilter
{
    public static function getWatchedTickets()
    {
        return Ticket::all()
            ->where('ticket_watched_status', '=', 'watched');
    }

    public static function getUnWatchedTickets()
    {
        return Ticket::all()
            ->where('ticket_watched_status', '=', 'unwatched');
    }

    public static function getClosedTickets()
    {
        return Ticket::all()
            ->where('ticket_status', '=', 'closed');
    }

    public static function getUnClosedTickets()
    {
        return Ticket::where('ticket_status', '=', 'active')
            ->orWhere('ticket_status','=','inactive')
            ->get();
    }

    public static function getAnsweredTickets()
    {
        return Ticket::has('messages')->get();
    }

    public static function getNonAnsweredTickets()
    {
        return Ticket::doesntHave('messages')->get();
    }
}
