@extends('chat/template_chat', [
    'messages' => $messages,
    'ticket'  => $ticket,
    'user' => $user
])
