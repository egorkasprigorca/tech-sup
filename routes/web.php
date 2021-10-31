<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SignUpController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogOutController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::redirect('/', '/board');

Route::get('/board', [\App\Http\Controllers\Board\BoardController::class, 'viewBoard'])->middleware('auth')->
name("board");

Route::view('/board/create-ticket', 'board/create_ticket');
Route::post('/board/create-ticket', [\App\Http\Controllers\Board\TicketController::class, 'createTicket']);
Route::get('/board/{id}/close', [\App\Http\Controllers\Board\TicketController::class, 'closeTicket']);
Route::get('/board/{id}/take-ticket', [\App\Http\Controllers\Board\TicketController::class, 'takeTicket']);

Route::view('/signup', 'auth/signup');
Route::post('/signup', [SignUpController::class, 'registration']);

Route::view('/login', 'auth/login')->name('login');
Route::post('/login', [LoginController::class, 'auth']);

Route::get('/board/logout', [LogOutController::class, 'logout']);

Route::get('/board/{id}/chat', [\App\Http\Controllers\Chat\ChatController::class, 'viewChat'])->name('chat');
Route::post('/board/{id}/chat/create-message', [\App\Http\Controllers\Chat\MessageController::class, 'createMessage']);

Route::get('/board/viewed', [\App\Http\Controllers\Board\TicketsFilterController::class, 'viewed']);
Route::get('/board/un-viewed', [\App\Http\Controllers\Board\TicketsFilterController::class, 'unViewed']);
Route::get('/board/closed', [\App\Http\Controllers\Board\TicketsFilterController::class, 'closed']);
Route::get('/board/unclosed', [\App\Http\Controllers\Board\TicketsFilterController::class, 'unClosed']);
Route::get('/board/answered', [\App\Http\Controllers\Board\TicketsFilterController::class, 'answered']);
Route::get('/board/non-answered', [\App\Http\Controllers\Board\TicketsFilterController::class, 'nonAnswered']);


