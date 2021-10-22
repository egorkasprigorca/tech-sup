<h2>Вам отправлено новое письмо от {{ $user->name }}</h2>
<h2>Тема письма {{ $ticket->ticket_subject }}</h2>
<a href="tech-sup.loc/board/<?= $ticket->id ?>/chat">Ссылка для перехода к сообщению </a>
