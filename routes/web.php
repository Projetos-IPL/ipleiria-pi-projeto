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
use App\Http\Controllers\CarrinhoController;
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
    Route::put('perfil/{id}', [UserController::class, 'updatePublicProfile'])->name('utilizadores.updatePublicProfile');

    Route::get('bilhete/{id}/pdf', [BilheteController::class, 'showPDF'])->name('bilhetes.showPDF');

    Route::get('filmes', [SessaoController::class, 'indexPublic'])->name('sessoes.indexPublic');
    Route::get('filme/{id}', [SessaoController::class, 'showPublic'])->name('sessoes.showPublic');
    Route::get('sessao/{id}/comprar', [SessaoController::class, 'buy'])->name('sessoes.buy');

    Route::get('carrinho', [CarrinhoController::class, 'showCart'])->name('carrinho.showCart');
    Route::post('carrinho', [CarrinhoController::class, 'addItem'])->name('carrinho.addItem');
    Route::delete('carrinho/{id}', [CarrinhoController::class, 'removeItem'])->name('carrinho.removeItem');

    Route::get('checkout', [CarrinhoController::class, 'showCheckout'])->name('carrinho.showCheckout');
    Route::post('checkout', [CarrinhoController::class, 'checkout'])->name('carrinho.checkout');

    Route::get('acesso', [SessaoController::class, 'accessControl'])->middleware('can:restrict-user-type-funcionario')->name('sessoes.accessControl');
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

// Laravel/packages routes
Auth::routes(['verify' => true]);

// route used for uptime detection mechanisms
Route::get('/status', function () {
    // get last git commit hash
    $lastCommit = exec('git log -1 --pretty=format:"%h"');

    return response()->json([
        'status' => 'OK',
        'time' => time(),
        'commit' => $lastCommit,
    ]);
})->name('status');
