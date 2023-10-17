<?php

namespace App\Http\Controllers;

use App\Charts\MonthlyUsersChart;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index(MonthlyUsersChart $chart)
    {
        // dd($chart->build());
        return Inertia::render('Backend/Dashboard', ['chart' => $chart->build()]);
    }
}
