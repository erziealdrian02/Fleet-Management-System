<?php

namespace App\Http\Controllers;

// use App\Models\MasterDetailTransaksi;
use App\Models\Driver;
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
        $getUser = User::get()->count();
        $getTransaksi = Vehicle::get()->count();
        $getProduct = Driver::get()->count();
        // $getRevenue = MasterDetailTransaksi::with('produk')->get()->sum(function ($detail) {
        //     return $detail->quantity * $detail->produk->harga;
        // });

        return view('dashboard', [
            'user' => $request->user(),
            'getUser' => $getUser,
            'getTransaksi' => $getTransaksi,
            'getProduct' => $getProduct,
            // 'getRevenue' => $getRevenue,
        ]);
    }
}
