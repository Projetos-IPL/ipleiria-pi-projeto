<?php

namespace App\Http\Controllers;

use App\Models\Sala;
use App\Models\User;
use App\Models\Filme;
use App\Models\Recibo;
use App\Models\Sessao;
use App\Models\Bilhete;
use App\Helpers\AppHelper;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $users = User::all();

        $totalUsers = $users->count();
        $totalAdminUsers = $users->where('tipo', 'A')->count();
        $totalCustomerUsers = $users->where('tipo', 'C')->count();
        $totalFuncionarioUsers = $users->where('tipo', 'F')->count();

        $totalFilmes = Filme::count();

        $mostPopularGenero = Filme::select('genero_code')
            ->selectRaw('COUNT(*) AS total')
            ->groupBy('genero_code')
            ->orderByDesc('total')
            ->first();

        $leastPopularGenero = Filme::select('genero_code')
            ->selectRaw('COUNT(*) AS total')
            ->groupBy('genero_code')
            ->orderBy('total')
            ->first();

        $mostPopularGeneroName = AppHelper::instance()->getGeneroPrettyName($mostPopularGenero->genero_code);
        $leastPopularGeneroName = AppHelper::instance()->getGeneroPrettyName($leastPopularGenero->genero_code);

        $totalRevenueValueFiveDays = Recibo::where('created_at', '>=', now()->subDays(5))
            ->sum('preco_total_com_iva');

        $totalRevenueValueThirtyDays = Recibo::where('created_at', '>=', now()->subDays(30))
            ->sum('preco_total_com_iva');

        $totalSessoesLast5Days = Sessao::where('created_at', '>=', now()->subDays(5))->count();
        $totalSessoesLast30Days = Sessao::where('created_at', '>=', now()->subDays(30))->count();
        $totalSessoesNext3Days = Sessao::where('created_at', '>=', now()->subDays(3))->count();

        $totalBilhetes = Bilhete::count();

        $mostFrequentSala = Sessao::select('sala_id')
            ->selectRaw('COUNT(*) AS total')
            ->groupBy('sala_id')
            ->orderByDesc('total')
            ->first();

        $mostFrequentSalaData = [
            "nome" => Sala::find($mostFrequentSala->sala_id)->nome
        ];

        $leastFrequentSala = Sessao::select('sala_id')
            ->selectRaw('COUNT(*) AS total')
            ->groupBy('sala_id')
            ->orderBy('total')
            ->first();

        $leastFrequentSalaData = [
            "nome" => Sala::find($leastFrequentSala->sala_id)->nome
        ];

        $totalSalas = Sala::count();

        $totalBilhetesCount = Bilhete::count();

        $bilhetesUsados = Bilhete::where('estado', 'usado')->count();
        $bilhetesNaoUsados = Bilhete::where('estado', 'não usado')->count();

        $percentagemUsados = ($bilhetesUsados * 100) / $totalBilhetesCount;
        $percentagemNaoUsados = ($bilhetesNaoUsados * 100) / $totalBilhetesCount;

        return view(
            'admin::home',
            compact(
                'totalUsers',
                'totalAdminUsers',
                'totalCustomerUsers',
                'totalFuncionarioUsers',
                'totalFilmes',
                'mostPopularGeneroName',
                'leastPopularGeneroName',
                'totalRevenueValueThirtyDays',
                'totalRevenueValueFiveDays',
                'totalSessoesLast5Days',
                'totalSessoesLast30Days',
                'totalSessoesNext3Days',
                'totalBilhetes',
                'mostFrequentSalaData',
                'leastFrequentSalaData',
                'totalSalas',
                'percentagemUsados',
                'percentagemNaoUsados'
            )
        );
    }
}
