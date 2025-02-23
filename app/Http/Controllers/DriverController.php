<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DriverController extends Controller
{
    public function index(Request $request): View
    {
        $title = "Driver";

        $driverList = Driver::get();
        $vehicles = Vehicle::all();

        return view('driver', [
            'user' => $request->user(),
            'title' => $title,
            'driverList' => $driverList,
            'vehicles' => $vehicles,
        ]);
    }

    public function store(Request $request)
    {
        $driver = new Driver();
        $driver->name = $request->name;
        $driver->license_number = $request->license_number;
        $driver->phone_number = $request->phone_number;
        $driver->status = $request->status;
        $driver->assigned_vehicle_id = $request->assigned_vehicle_id;
        // dd($driver);

        $driver->save();

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $driver = Driver::findOrFail($id);

        $driver->name = $request->name;
        $driver->license_number = $request->license_number;
        $driver->phone_number = $request->phone_number;
        $driver->status = $request->status;
        $driver->assigned_vehicle_id = $request->assigned_vehicle_id;

        $driver->save();

        return redirect()->back()->with('success', 'Kendaraan berhasil diperbarui!');
    }

    public function delete($id)
    {
        // Cek apakah transaksi ada
        $vehicle = Driver::findOrFail($id);
        if (!$vehicle) {
            return redirect()->route('driver')->with('error', 'vehicle tidak ditemukan.');
        }

        // Hapus produk dari vehicle
        $vehicle->delete();

        return redirect()->route('driver')->with('success', 'Product berhasil di hapus.');
    }
}
