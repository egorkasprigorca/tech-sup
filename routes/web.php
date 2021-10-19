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

Route::get('/board', [\App\Http\Controllers\Board\BoardController::class, 'viewBoard'])->middleware('auth');

Route::view('/board/create-ticket', 'board/create_ticket');
Route::post('/board/create-ticket', [\App\Http\Controllers\Board\TicketController::class, 'createTicket']);
Route::get('/board/{id}/close', [\App\Http\Controllers\Board\TicketController::class, 'closeTicket']);

Route::view('/signup', 'auth/signup');
Route::post('/signup', [SignUpController::class, 'registration']);

Route::view('/login', 'auth/login')->name('login');
Route::post('/login', [LoginController::class, 'auth']);

Route::get('/board/logout', [LogOutController::class, 'logout']);


