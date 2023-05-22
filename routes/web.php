<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FilmeController;

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
    return view('public::welcome');
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

Route::get('/filmes', [FilmeController::class, 'index'])->name('admin.filmes.index')->middleware('auth');

Route::get('/filmes/criar', [FilmeController::class, 'create'])->name('admin.filmes.create')->middleware('auth');
Route::post('/filmes', [FilmeController::class, 'store'])->name('admin.filmes.store')->middleware('auth');

Route::get('/filmes/{filme}/alterar', [FilmeController::class, 'edit'])->name('admin.filmes.edit')->middleware('auth');
Route::put('/filmes/{filme}', [FilmeController::class, 'update'])->name('admin.filmes.update')->middleware('auth');

Route::get('/filmes/{filme}', [FilmeController::class, 'show'])->name('admin.filmes.show')->middleware('auth');

Route::delete('/filmes/{filme}', [FilmeController::class, 'destroy'])->name('admin.filmes.destroy')->middleware('auth');

// auth routes
Auth::routes();
