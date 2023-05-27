<?php

namespace App\Http\Controllers;

use App\Helpers\AppHelper;
use App\Models\User;
use App\Models\Filme;
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
        $totalUsers = User::count();
        $totalAdminUsers = User::where('tipo', 'A')->count();
        $totalCustomerUsers = User::where('tipo', 'C')->count();
        $totalFuncionarioUsers = User::where('tipo', 'F')->count();

        $totalFilmes = Filme::count();

        // get the most popular genero in the filmes table
        $mostPopularGenero = Filme::select('genero_code')
            ->selectRaw('COUNT(*) AS total')
            ->groupBy('genero_code')
            ->orderByDesc('total')
            ->first();

        // get the least popular genero in the filmes table
        $leastPopularGenero = Filme::select('genero_code')
            ->selectRaw('COUNT(*) AS total')
            ->groupBy('genero_code')
            ->orderBy('total')
            ->first();

        $mostPopularGeneroName = \App\Helpers\AppHelper::instance()->getGeneroPrettyName($mostPopularGenero->genero_code);
        $leastPopularGeneroName = \App\Helpers\AppHelper::instance()->getGeneroPrettyName($leastPopularGenero->genero_code);

        // get total revenue since the beginning
        $totalRevenueValueBeginning = AppHelper::instance()->formatCurrencyValue(
            $totalRevenue = DB::table('recibos')->sum('preco_total_com_iva')
        );

        // get the revenue from the last 5 days
        $totalRevenueValueFiveDays = AppHelper::instance()->formatCurrencyValue(
            DB::table('recibos')
                ->where('created_at', '>=', now()->subDays(5))
                ->sum('preco_total_com_iva')
        );

        return view(
            'admin::home',
            compact('totalUsers', 'totalAdminUsers', 'totalCustomerUsers', 'totalFuncionarioUsers', 'totalFilmes', 'mostPopularGeneroName', 'leastPopularGeneroName', 'totalRevenue', 'totalRevenueValueBeginning', 'totalRevenueValueFiveDays')
        );
    }
}
