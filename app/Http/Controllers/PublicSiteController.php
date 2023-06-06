<?php

namespace App\Http\Controllers;

use App\Models\Sessao;
use App\Models\Configuracao;

class PublicSiteController extends Controller
{
    public function index()
    {
        $sessao = Sessao::whereBetween('data', [now()->startOfWeek(), now()->endOfWeek()])->inRandomOrder()->first();

        $preco_bilhete_sem_iva = Configuracao::get('preco_bilhete_sem_iva')->first()->preco_bilhete_sem_iva;
        $percentagem_iva = Configuracao::get('percentagem_iva')->first()->percentagem_iva;

        // get total of filmes in cartaz
        $totalFilmesCartaz = Sessao::whereBetween('data', [now()->startOfWeek(), now()->endOfWeek()])->get('filme_id')->count();

        return view('public::index')
            ->with(
                [
                    'sessao' => $sessao,
                    'preco_bilhete_sem_iva' => $preco_bilhete_sem_iva,
                    'percentagem_iva' => $percentagem_iva,
                    'totalFilmesCartaz' => $totalFilmesCartaz
                ]
            );
    }
}
