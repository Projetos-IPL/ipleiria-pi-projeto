<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SalaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FilmeController;
use App\Http\Controllers\GeneroController;
use App\Http\Controllers\ConfiguracaoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
|
| Base URL: /
|
*/

Route::get('/', function () {
    return view('public::index');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Base URL: /admin
|
*/

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::resource('generos', GeneroController::class)->middleware('auth');
Route::resource('filmes', FilmeController::class)->middleware('auth');
Route::resource('utilizadores', UserController::class)->middleware('auth');
Route::resource('salas', SalaController::class)->middleware('auth');

Route::get('/configuracoes', [ConfiguracaoController::class, 'edit'])->name('configuracoes.edit')->middleware('auth');
Route::put('/configuracoes', [ConfiguracaoController::class, 'update'])->name('configuracoes.update')->middleware('auth');


// auth routes
Auth::routes();
