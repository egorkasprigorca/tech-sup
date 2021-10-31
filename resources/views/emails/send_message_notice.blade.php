<h2>Пользователь  {{ $user->name }} ответил на ваше сообщение</h2>
<h2>Тема письма {{ $ticket->ticket_subject }}</h2>
<a href="tech-sup.loc/board/<?= $ticket->id ?>/chat">Ссылка для перехода к сообщению </a>
