<?php

namespace App\Http\Controllers;

use App\Models\User;
use ArielMejiaDev\LarapexCharts\Facades\LarapexChart;
use Illuminate\Http\Request;

class ChartController extends Controller
{
    public function bilhetesSoldChart()
    {
        $allUsers = User::all();



        return $chart;
    }
}
