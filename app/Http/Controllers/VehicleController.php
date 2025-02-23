<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VehicleController extends Controller
{
    public function index(Request $request): View
    {
        $title = "Vehicle";

        $vehicleList = Vehicle::get();

        return view('vehicle', [
            'title' => $title,
            'user' => $request->user(),
            'vehicleList' => $vehicleList,
        ]);
    }

    public function store(Request $request)
    {
        $vehicle = new Vehicle();
        $vehicle->license_plate = $request->license_plate;
        $vehicle->type = $request->type;
        $vehicle->status = $request->status;
        $vehicle->fuel_capacity = $request->fuel_capacity;
        $vehicle->last_service_date = $request->last_service_date;
        $vehicle->mileage = $request->mileage;
        $vehicle->gps_enabled = $request->gps_enabled === 'on' ? true : false;
        // dd($vehicle);

        $vehicle->save();

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $vehicle = Vehicle::findOrFail($id);

        $vehicle->license_plate = $request->license_plate;
        $vehicle->type = $request->type;
        $vehicle->status = $request->status;
        $vehicle->fuel_capacity = $request->fuel_capacity;
        $vehicle->last_service_date = $request->last_service_date;
        $vehicle->mileage = $request->mileage;
        $vehicle->gps_enabled = $request->gps_enabled === 'on' ? true : false;

        $vehicle->save();

        return redirect()->back()->with('success', 'Kendaraan berhasil diperbarui!');
    }

    public function delete($id)
    {
        // Cek apakah transaksi ada
        $vehicle = Vehicle::findOrFail($id);
        if (!$vehicle) {
            return redirect()->route('vehicle')->with('error', 'vehicle tidak ditemukan.');
        }

        // Hapus produk dari vehicle
        $vehicle->delete();

        return redirect()->route('vehicle')->with('success', 'Product berhasil di hapus.');
    }
}
