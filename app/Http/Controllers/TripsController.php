<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Driver;
use App\Models\Trip;
use App\Models\Vehicle;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;

class TripsController extends Controller
{
    private function convertToRoman($number)
    {
        $map = [
            1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V', 6 => 'VI',
            7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII'
        ];
        return $map[$number] ?? '';
    }

    private function generateCompanyCode($companyName)
    {
        // Ambil setiap kata, lalu ambil huruf besar pertamanya
        $words = explode(' ', strtoupper($companyName));
        $code = '';
        foreach ($words as $word) {
            $code .= $word[0];
        }
        return $code;
    }


    public function index(Request $request): View
    {
        $title = "Trips";

        $companyList = Company::get();
        $tripsList = Trip::get();

        return view('trips', [
            'user' => $request->user(),
            'title' => $title,
            'companyList' => $companyList,
            'tripsList' => $tripsList,
        ]);
    }

    public function formAdd(Request $request): View
    {
        $tripsList = Trip::get();
        $driverList = Driver::get();
        $vehicleList = Vehicle::with('gps')->get();
        $companyList = Company::get();

        $title = "Trips";

        // Ambil IP user yang sedang online
        $ip_user = $request->ip(); // atau bisa juga pakai request()->ip()

        // Ambil lokasi user dari Cache
        $location = Cache::get("user_location_{$ip_user}"); // Default Jakarta

        return view('formTrips.addForm-Trips', [
            'user' => $request->user(),
            'title' => $title,
            'tripsList' => $tripsList,
            'vehicleList' => $vehicleList,
            'driverList' => $driverList,
            'companyList' => $companyList,
            'latitude' => $location['lat'] ?? -6.2114,
            'longitude' => $location['lon'] ?? 106.8446,
        ]);
    }

    public function store(Request $request)
    {
        // Ambil bulan dalam format Romawi
        $bulanRomawi = $this->convertToRoman(date('n')); 
        // Ambil kode dari start_location (misalnya "PT Test Company" -> "PTTC")
        $startCode = $this->generateCompanyCode($request->start_location);
        // Ambil kode dari end_location (misalnya "PT Test Company Kedua" -> "PTCK")
        $endCode = $this->generateCompanyCode($request->end_location);
        // Ambil tahun sekarang
        $tahun = date('Y');
        // Ambil nomor terakhir dari database, jika belum ada maka mulai dari 1
        $lastTrip = Trip::orderBy('id', 'desc')->first();
        $nextNumber = $lastTrip ? sprintf("%05d", $lastTrip->id + 1) : "00001";
        // Buat nomor SPPD dengan format yang diinginkan
        $no_sppd = "{$bulanRomawi}/{$startCode}/{$endCode}/{$nextNumber}/{$tahun}";

        // Simpan ke database
        $trips = new Trip();
        $trips->vehicle_id = $request->vehicle_id;
        $trips->driver_id = $request->driver_id;
        $trips->no_sppd = $no_sppd;
        $trips->start_location = $request->start_location;
        $trips->end_location = $request->end_location;
        $trips->start_time = $request->start_time;
        $trips->end_time = $request->end_time;
        $trips->distance = $request->distance;

        $trips->save();

        return redirect()->route('trips')->with('success', 'Trips berhasil ditambahkan!');
    }

    public function formEdit(Request $request, $id): View
    {
        $title = "Trips";

        $tripsList = Trip::findOrFail($id);
        $driverList = Driver::get();
        $vehicleList = Vehicle::with('gps')->get();
        $companyList = Company::get();

        // Ambil IP user yang sedang online
        $ip_user = $request->ip(); // atau bisa juga pakai request()->ip()

        // Ambil lokasi user dari Cache
        $location = Cache::get("user_location_{$ip_user}"); // Default Jakarta

        return view('formTrips.detailForm-Trips', [
            'user' => $request->user(),
            'title' => $title,
            'tripsList' => $tripsList,
            'vehicleList' => $vehicleList,
            'driverList' => $driverList,
            'companyList' => $companyList,
            'latitude' => $location['lat'] ?? -6.2114,
            'longitude' => $location['lon'] ?? 106.8446,
        ]);
    }

    public function update(Request $request, $id)
    {
        $company = Company::findOrFail($id);

        $company->name = $request->name;
        $company->type = $request->type;
        $company->alamat = $request->alamat;
        $company->latitude = $request->latitude;
        $company->longitude = $request->longitude;

        $company->save();

        return redirect()->route('trips')->with('success', 'Trips berhasil diperbarui!');
    }

    public function delete($id)
    {
        // Cek apakah transaksi ada
        $company = Company::findOrFail($id);
        if (!$company) {
            return redirect()->route('trips')->with('error', 'Trips tidak ditemukan.');
        }

        // Hapus produk dari company
        $company->delete();

        return redirect()->route('trips')->with('success', 'Trips berhasil di hapus.');
    }
}
