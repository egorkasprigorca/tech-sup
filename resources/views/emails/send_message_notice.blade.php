@component('mail::message')
    @if($user->role === "manager")
        <h2>Агент техподдержки ответил на вашу заявку</h2>
        <h2>Тема письма {{ $ticket->ticket_subject }}</h2>
        @component('mail::button', ['url' => $url ])
            Нажмите, чтобы перейти к ответу
        @endcomponent
    @else
        <h2>Пользователь  {{ $user->name }} ответил на ваше сообщение</h2>
        <h2>Тема письма {{ $ticket->ticket_subject }}</h2>
        @component('mail::button', ['url' => $url ])
            Нажмите, чтобы перейти к ответу
        @endcomponent
    @endif
@endcomponent
