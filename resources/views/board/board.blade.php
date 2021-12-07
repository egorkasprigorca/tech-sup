@extends('board/template')
@section('user_name')
    <h2>Привет {{ $user->name }}</h2>
@endsection
@section('main_content')
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if($boardStatus === 'noDefault')
        <div class="dropdown">
            <button onClick='location.href="{{ url('/') }}/board"' acclass="btn btn-secondary " type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Все письма
            </button>
        </div>
    @endif
    @if($isManager)
        <div class="dropdown">
            <button onClick='location.href="/board/viewed"' acclass="btn btn-secondary " type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Просмотренные
            </button>
            <button onClick='location.href="/board/un-viewed"' class="btn btn-secondary" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Непросмотренные
            </button>
            <button onClick='location.href="/board/unclosed"' acclass="btn btn-secondary " type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Незакрытые
            </button>
            <button onClick='location.href="/board/closed"' class="btn btn-secondary" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Закрытые
            </button>
            <button onClick='location.href="/board/answered"' acclass="btn btn-secondary " type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Есть ответ
            </button>
            <button onClick='location.href="/board/non-answered"' class="btn btn-secondary" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Нет ответа
            </button>
        </div>
    @endif
    @if($boardStatus === 'default')
        @if(!$isManager)
            <h2><a href="{{ url('/') }}/board/create-ticket">Создать заявку</a></h2>
        @endif
    @endif
    @if($boardStatus === 'default')
        <h2>{{ $boardName }}</h2>
        @if(!empty($tickets))
            @foreach($tickets as $ticket)
                <div id="accordion">
                    <div class="card">
                        @if($ticket->ticket_status === 'closed')
                            <div class="card-header alert alert-danger" id="headingOne">
                                <h5 class="mb-0">
                                    <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        <a href="{{ url('/') }}/board/<?= $ticket->id ?>/chat">
                                            {{$ticket->ticket_subject}}
                                        </a>
                                    </button>
                                    <button class="btn" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        от {{$ticket->user->name}}
                                    </button>
                                    @if($isManager)
                                        @if(($ticket->ticket_status !== 'closed') && ($ticket->ticket_watched_status !== 'unwatch'))
                                            <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                <a href="{{ url('/') }}/board/<?= $ticket->id ?>/take-ticket">Ответить на заявку</a>
                                            </button>
                                        @endif
                                    @endif
                                    @if(!$isManager)
                                        @if($ticket->ticket_status !== 'closed')
                                            <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                <a href="{{ url('/') }}/board/<?= $ticket->id ?>/close">Закрыть заявку</a>
                                            </button>
                                        @endif
                                    @endif

                                </h5>
                            </div>
                        @endif

                        @if($ticket->ticket_watched_status === 'watched' && $ticket->ticket_status !== 'closed')
                            <div class="card-header alert alert-success" id="headingOne">
                                <h5 class="mb-0">
                                    <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        <a href="{{ url('/') }}/board/<?= $ticket->id ?>/chat">
                                            {{$ticket->ticket_subject}}
                                        </a>
                                    </button>
                                    <button class="btn" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        от {{$ticket->user->name}}
                                    </button>
                                    @if($isManager)
                                        @if(($ticket->ticket_status !== 'closed') && ($ticket->ticket_watched_status !== 'unwatch'))
                                            <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                <a href="{{ url('/') }}/board/<?= $ticket->id ?>/take-ticket">Ответить на заявку</a>
                                            </button>
                                        @endif
                                            @if($ticket->ticket_status !== 'closed')
                                                <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                    <a href="{{ url('/') }}/board/<?= $ticket->id ?>/close">Закрыть заявку</a>
                                                </button>
                                            @endif
                                    @endif
                                    @if(!$isManager)
                                        @if($ticket->ticket_status !== 'closed')
                                            <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                <a href="{{ url('/') }}/board/<?= $ticket->id ?>/close">Закрыть заявку</a>
                                            </button>
                                        @endif
                                    @endif

                                </h5>
                            </div>
                        @endif

                        @if($ticket->ticket_watched_status === 'unwatched' && $ticket->ticket_status === 'inactive')
                            <div class="card-header" id="headingOne">
                                <h5 class="mb-0">
                                    <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        <a href="{{ url('/') }}/board/<?= $ticket->id ?>/chat">
                                            {{$ticket->ticket_subject}}
                                        </a>
                                    </button>
                                    <button class="btn" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        от {{$ticket->user->name}}
                                    </button>
                                    @if($isManager)
                                        @if($ticket->ticket_status !== 'closed')
                                            @if($ticket->ticket_watched_status === 'unwatched')
                                                <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                    <a href="{{ url('/') }}/board/<?= $ticket->id ?>/take-ticket">Ответить на заявку</a>
                                                </button>
                                            @endif
                                        @endif
                                    @endif
                                    @if(!$isManager)
                                        <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            <a href="{{ url('/') }}/board/<?= $ticket->id ?>/close">Закрыть заявку</a>
                                        </button>
                                    @endif
                                </h5>
                            </div>
                        @endif

                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                            <div class="card-body">
                                {{mb_strimwidth($ticket->ticket_text, 0, 100, "...")}}
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    @endif
    @if($boardStatus === 'noDefault')
        @if(!empty($tickets))
            <h2>{{ $boardName }}</h2>
            @foreach($tickets as $ticket)
                <div id="accordion">
                    <div class="card">
                        @if($ticket->ticket_status === 'closed')
                            <div class="card-header alert alert-danger" id="headingOne">
                                <h5 class="mb-0">
                                    <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        <a href="{{ url('/') }}/board/<?= $ticket->id ?>/chat">
                                            {{$ticket->ticket_subject}}
                                        </a>
                                    </button>
                                    <button class="btn" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        от {{$ticket->user->name}}
                                    </button>
                                    @if($isManager)
                                        @if(($ticket->ticket_status !== 'closed') && ($ticket->ticket_watched_status !== 'unwatch'))
                                            <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                <a href="{{ url('/') }}/board/<?= $ticket->id ?>/take-ticket">Ответить на заявку</a>
                                            </button>
                                        @endif
                                    @endif
                                    @if(!$isManager)
                                        @if($ticket->ticket_status !== 'closed')
                                            <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                <a href="{{ url('/') }}/board/<?= $ticket->id ?>/close">Закрыть заявку</a>
                                            </button>
                                        @endif
                                    @endif

                                </h5>
                            </div>
                        @endif

                        @if($ticket->ticket_watched_status === 'watched' && $ticket->ticket_status !== 'closed')
                            <div class="card-header alert alert-success" id="headingOne">
                                <h5 class="mb-0">
                                    <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        <a href="{{ url('/') }}/board/<?= $ticket->id ?>/chat">
                                            {{$ticket->ticket_subject}}
                                        </a>
                                    </button>
                                    <button class="btn" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        от {{$ticket->user->name}}
                                    </button>
                                    @if($isManager)
                                        @if(($ticket->ticket_status !== 'closed') && ($ticket->ticket_watched_status !== 'unwatch'))
                                            <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                <a href="{{ url('/') }}/board/<?= $ticket->id ?>/take-ticket">Ответить на заявку</a>
                                            </button>
                                        @endif
                                        @if($ticket->ticket_status !== 'closed')
                                            <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                <a href="{{ url('/') }}/board/<?= $ticket->id ?>/close">Закрыть заявку</a>
                                            </button>
                                        @endif
                                    @endif
                                    @if(!$isManager)
                                        @if($ticket->ticket_status !== 'closed')
                                            <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                <a href="{{ url('/') }}/board/<?= $ticket->id ?>/close">Закрыть заявку</a>
                                            </button>
                                        @endif
                                    @endif

                                </h5>
                            </div>
                        @endif

                        @if($ticket->ticket_watched_status === 'unwatched' && $ticket->ticket_status === 'inactive')
                            <div class="card-header" id="headingOne">
                                <h5 class="mb-0">
                                    <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        <a href="{{ url('/') }}/board/<?= $ticket->id ?>/chat">
                                            {{$ticket->ticket_subject}}
                                        </a>
                                    </button>
                                    <button class="btn" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        от {{$ticket->user->name}}
                                    </button>
                                    @if($isManager)
                                        @if($ticket->ticket_status !== 'closed')
                                            @if($ticket->ticket_watched_status === 'unwatched')
                                                <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                    <a href="{{ url('/') }}/board/<?= $ticket->id ?>/take-ticket">Ответить на заявку</a>
                                                </button>
                                            @endif
                                        @endif
                                    @endif
                                    @if(!$isManager)
                                        <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            <a href="{{ url('/') }}/board/<?= $ticket->id ?>/close">Закрыть заявку</a>
                                        </button>
                                    @endif
                                </h5>
                            </div>
                        @endif

                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                            <div class="card-body">
                                {{mb_strimwidth($ticket->ticket_text, 0, 100, "...")}}
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    @endif
@endsection
