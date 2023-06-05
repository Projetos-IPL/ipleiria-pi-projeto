<?php

use App\Models\Filme;
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

// a route that receives a sessao id and returns the data
Route::get('/sessoes/{id}', function (int $id) {
    $sessao = \App\Models\Sessao::findOrFail($id);

    return response()->json([
        'total_bilhetes' => $sessao->bilhetes->count(),
        'total_confirmados' => $sessao->bilhetes->where('estado', 'usado')->count(),
        'total_por_confirmar' => $sessao->bilhetes->where('estado', 'não usado')->count(),
    ]);
})->name('api.sessoes.estatistica');

Route::get('/sessoes/{id}/bilhete/{bilhete_id}', function (int $sessaoId, int $bilheteId) {
    $sessao = \App\Models\Sessao::findOrFail($sessaoId);
    $bilhete = \App\Models\Bilhete::findOrFail($bilheteId);

    // check if bilhete is allowed for this sessao
    if ($bilhete->sessao_id !== $sessao->id) {
        return response()->json([
            'permitido' => false,
            'dados' => [
                'nome' => $bilhete->cliente->user->name,
                'estado' => $bilhete->estado,
            ]
        ]);
    } else {
        if ($bilhete->estado === 'usado') {
            return response()->json([
                'permitido' => false,
                'dados' => [
                    'nome' => $bilhete->cliente->user->name,
                    'estado' => $bilhete->estado,
                ]
            ]);
        }

        $bilhete->estado = 'usado';
        $bilhete->save();

        return response()->json([
            'permitido' => true,
            'dados' => [
                'nome' => $bilhete->cliente->user->name,
                'estado' => $bilhete->estado,
            ]
        ]);
    }
})->name('api.sessoes.confirmar');
