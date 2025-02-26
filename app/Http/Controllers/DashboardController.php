<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\Trip;
use App\Models\Vehicle;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;
use Goutte\Client;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $title = "Dashboard";

        $getUser = User::count();
        $getVehicle = Vehicle::count();
        $getTrip = Trip::count();

        // Ambil rentang 30 hari terakhir
        $startDate = now()->subDays(30)->toDateString();
        $endDate = now()->toDateString();

        $trips = Trip::whereBetween('created_at', [$startDate, $endDate])
                    ->selectRaw('DATE(created_at) as date, SUM(distance) as total_distance')
                    ->groupBy('date')
                    ->orderBy('date', 'asc')
                    ->get();

        $labels = $trips->pluck('date'); // Label tanggal
        $distances = $trips->pluck('total_distance'); // Data jarak

        return view('dashboard', [
            'title' => $title,
            'user' => $request->user(),
            'getUser' => $getUser,
            'getVehicle' => $getVehicle,
            'getTrip' => $getTrip,
            'getMiles' => $trips->sum('total_distance'),
            'chartLabels' => $labels,
            'chartData' => $distances,
        ]);
    }
}
