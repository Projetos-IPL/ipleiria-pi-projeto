<?php

namespace App\Http\Controllers;

use App\Models\Filme;
use App\Models\Sessao;
use App\Models\Bilhete;
use Illuminate\Http\JsonResponse;

class ApiController extends Controller
{
    public function getMoviePoster(int $id): JsonResponse
    {
        $cartazPath = Filme::findOrFail($id)->getCartazPath();

        return response()->json([
            'cartaz_url' => url('/') . $cartazPath,
        ]);
    }

    public function getSessaoData(int $id): JsonResponse
    {
        $sessao = Sessao::findOrFail($id);

        return response()->json([
            'total_bilhetes' => $sessao->bilhetes->count(),
            'total_confirmados' => $sessao->bilhetes->where('estado', 'usado')->count(),
            'total_por_confirmar' => $sessao->bilhetes->where('estado', 'não usado')->count(),
        ]);
    }

    public function getSessaoBilheteData(int $sessao_id, int $bilhete_id)
    {
        $sessao = Sessao::findOrFail($sessao_id);
        $bilhete = Bilhete::findOrFail($bilhete_id);

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
    }
}
