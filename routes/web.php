<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SalaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FilmeController;
use App\Http\Controllers\GeneroController;
use App\Http\Controllers\SessaoController;
use App\Http\Controllers\BilheteController;
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

Route::prefix('/')->group(function () {
    Route::get('/', function () {
        return view('public::index');
    })->name('index');

    Route::get('perfil', [UserController::class, 'showPublicProfile'])->name('utilizadores.publicProfile');

    Route::get('/bilhete/{id}/pdf', [BilheteController::class, 'showPDF'])->name('bilhetes.showPDF');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Base URL: /admin
|
*/

Route::prefix('admin')->middleware(['auth', 'verified', 'can:restrict-user-type-administrator'])->group(function () {
    Route::get('home', [HomeController::class, 'index'])->name('home');

    Route::resource('filmes', FilmeController::class);
    Route::resource('generos', GeneroController::class);
    Route::resource('utilizadores', UserController::class);
    Route::resource('salas', SalaController::class);
    Route::resource('sessoes', SessaoController::class);

    Route::get('perfil', [UserController::class, 'showAdminProfile'])->name('utilizadores.adminProfile');

    Route::get('configuracoes', [ConfiguracaoController::class, 'edit'])->name('configuracoes.edit');
    Route::put('configuracoes', [ConfiguracaoController::class, 'update'])->name('configuracoes.update');
});

// auth routes
Auth::routes(['verify' => true]);
