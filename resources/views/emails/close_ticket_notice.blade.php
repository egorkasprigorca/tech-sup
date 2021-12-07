@component('mail::message')
    @if($user->role === "manager")
        <h2>Заявка по теме: {{ $ticket->ticket_subject }} была закрыта Агентом техподдержки.</h2>
        @component('mail::button', ['url' => $url ])
            Нажмите, чтобы перейти к закрытой заявке
        @endcomponent
    @else
        <h2>Заявка по теме: {{ $ticket->ticket_subject }} была закрыта пользователем {{ $user->name }}</h2>
        @component('mail::button', ['url' => $url ])
            Нажмите, чтобы перейти к закрытой заявке
        @endcomponent
    @endif
@endcomponent

