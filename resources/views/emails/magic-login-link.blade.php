@component('mail::message')
    Появилась новая заявка
    @component('mail::button', ['url' => $url])
        Нажмите, чтобы перейти к ней
    @endcomponent
@endcomponent
