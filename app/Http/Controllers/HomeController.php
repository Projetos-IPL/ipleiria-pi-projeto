<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Filme;
use App\Models\Recibo;
use App\Models\Sessao;
use App\Models\Bilhete;
use App\Helpers\AppHelper;
use Illuminate\Support\Facades\DB;

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

        $totalRevenueValueFiveDays = AppHelper::instance()->formatCurrencyValue(
            Recibo::where('created_at', '>=', now()->subDays(5))
                ->sum('preco_total_com_iva')
        );

        $totalRevenueValueThirtyDays = AppHelper::instance()->formatCurrencyValue(
            Recibo::where('created_at', '>=', now()->subDays(30))
                ->sum('preco_total_com_iva')
        );

        $totalSessoesLast5Days = Sessao::where('created_at', '>=', now()->subDays(5))->count();
        $totalSessoesLast30Days = Sessao::where('created_at', '>=', now()->subDays(30))->count();
        $totalSessoesNext3Days = Sessao::where('created_at', '>=', now()->subDays(3))->count();

        $totalBilhetes = Bilhete::count();

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
                'totalBilhetes'
            )
        );
    }
}
