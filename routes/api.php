<?php

use App\Models\Filme;
use Illuminate\Http\Request;
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

Route::get('/filmes/{id}/cartaz', function (int $id) {
    $cartazPath = Filme::findOrFail($id)->getCartazPath();

    return response()->json([
        'cartaz_url' => url('/') . $cartazPath,
    ]);
})->name('api.filmes.cartaz');
