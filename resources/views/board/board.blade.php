@extends('board/template')

@section('main_content')
    <h2><a href="/board/create-ticket">Создать заявку</a></h2>
    @if(!empty($tickets))
        @foreach($tickets as $ticket)
            <div id="accordion">
                <div class="card">
                    <div class="card-header" id="headingOne">
                        <h5 class="mb-0">
                            <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                {{$ticket->ticket_subject}}
                            </button>
                            <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                <a href="/board/<?= $ticket->id ?>/close">Закрыть заявку</a>
                            </button>
                        </h5>
                    </div>

                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                        <div class="card-body">
                            {{$ticket->ticket_text}}
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
@endsection
