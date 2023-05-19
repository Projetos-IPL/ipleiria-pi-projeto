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

Auth::routes();
