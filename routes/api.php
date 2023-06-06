<?php

use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/filmes/{id}/cartaz', [ApiController::class, 'getMoviePoster'])->name('api.filmes.cartaz');
Route::get('/sessoes/{id}', [ApiController::class, 'getSessaoData'])->name('api.sessoes.data');
Route::get('/sessoes/{id}/bilhete/{bilhete_id}', [ApiController::class, 'ApiController@getSessaoBilheteData'])->name('api.sessoes.bilhete');
