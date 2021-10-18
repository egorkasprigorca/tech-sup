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

Route::get('/board', function (){
    return view('board/board', ['userName' => \Illuminate\Support\Facades\Auth::user()->name]);
})->middleware('auth');

Route::view('/signup', 'auth/signup');
Route::post('/signup', [SignUpController::class, 'registration']);

Route::view('/login', 'auth/login')->name('login');
Route::post('/login', [LoginController::class, 'auth']);

Route::get('/board/logout', [LogOutController::class, 'logout']);


