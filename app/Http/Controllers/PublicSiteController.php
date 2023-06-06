<?php

namespace App\Http\Controllers;

use App\Models\Sessao;
use App\Models\Configuracao;
use Illuminate\Http\Request;

class PublicSiteController extends Controller
{
    public function index()
    {
        // get a random sessao from this week timespan
        $sessao = Sessao::whereBetween('data', [now()->startOfWeek(), now()->endOfWeek()])->inRandomOrder()->first();

        // get preco_bilhete_sem_iva plus iva from configuracao
        $preco_bilhete_sem_iva = Configuracao::get('preco_bilhete_sem_iva')->first()->preco_bilhete_sem_iva;
        $percentagem_iva = Configuracao::get('percentagem_iva')->first()->percentagem_iva;

        return view('public::index')
            ->with(['sessao' => $sessao, 'preco_bilhete_sem_iva' => $preco_bilhete_sem_iva, 'percentagem_iva' => $percentagem_iva]);
    }
}
