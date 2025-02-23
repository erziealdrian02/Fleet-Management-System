<?php

namespace App\Http\Controllers;

use App\Models\GpsTracking;
use App\Models\Session;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Cache;

class GPSTrackerController extends Controller
{
    public function index(Request $request): View
    {
        $title = "GPS Tracking";

        $gpsList = GpsTracking::get();

        return view('gpsTracker', [
            'title' => $title,
            'user' => $request->user(),
            'gpsList' => $gpsList,
        ]);
    }

    public function formAdd(Request $request): View
    {
        $title = "Create GPS Tracking";

        $gpsList = GpsTracking::get();
        $vehicles = Vehicle::get();

        // Ambil IP user yang sedang online
        $ip_user = $request->ip(); // atau bisa juga pakai request()->ip()

        // Ambil lokasi user dari Cache
        $location = Cache::get("user_location_{$ip_user}"); // Default Jakarta

        return view('formGPSTracking.addForm-GPSTracker', [
            'user' => $request->user(),
            'title' => $title,
            'gpsList' => $gpsList,
            'vehicles' => $vehicles,
            'latitude' => $location['lat'],
            'longitude' => $location['lon'],
        ]);
    }

    public function store(Request $request)
    {
        $tracking = new GpsTracking();
        $tracking->vehicle_id = $request->vehicle_id;
        $tracking->latitude = $request->latitude;
        $tracking->longitude = $request->longitude;
        $tracking->speed = $request->speed;

        $tracking->save();

        return redirect()->route('tracking')->with('success', 'GPS Tracker berhasil ditambahkan!');
    }

    public function formEdit(Request $request, $id): View
    {
        $title = "Edit GPS Tracking";

        $idGPS = GpsTracking::findOrFail($id);
        $gpsList = GpsTracking::where('id', $id)->first();

        $vehicles = Vehicle::get();

        // Ambil IP user yang sedang online
        $ip_user = $request->ip(); // atau bisa juga pakai request()->ip()

        // Ambil lokasi user dari Cache
        $location = Cache::get("user_location_{$ip_user}"); // Default Jakarta

        return view('formGPSTracking.editForm-GPSTracker', [
            'user' => $request->user(),
            'title' => $title,
            'gpsList' => $gpsList,
            'vehicles' => $vehicles,
            'latitude' => $location['lat'],
            'longitude' => $location['lon'],
        ]);
    }

    public function update(Request $request, $id)
    {
        $tracking = GpsTracking::findOrFail($id);

        $tracking->vehicle_id = $request->vehicle_id;
        $tracking->latitude = $request->latitude;
        $tracking->longitude = $request->longitude;
        $tracking->speed = $request->speed;

        $tracking->save();

        return redirect()->route('tracking')->with('success', 'GPS Tracker berhasil diperbarui!');
    }

    public function delete($id)
    {
        // Cek apakah transaksi ada
        $tracking = GpsTracking::findOrFail($id);
        if (!$tracking) {
            return redirect()->route('tracking')->with('error', 'GPS Tracking tidak ditemukan.');
        }

        // Hapus produk dari tracking
        $tracking->delete();

        return redirect()->route('tracking')->with('success', 'GPS Tracking berhasil di hapus.');
    }
}
