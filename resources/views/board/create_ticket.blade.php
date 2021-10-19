@extends('board/template')

@section('main_content')
    <form method="post" action="/board/create-ticket">
        @csrf
        <input type="text" name="ticket_subject" id="ticket_subject" class="form-control" placeholder="Введите тему сообщения" required="" autofocus="">
        <input type="text" name="ticket_text" id="ticket_text" class="form-control" placeholder="Введите текст сообщения" required="">
        <button class="btn btn-lg btn-primary btn-block" type="submit">Отправить сообщение</button>
    </form>
@endsection
