<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index(Request $request): View
    {
        $companyList = Company::get();

        return view('company', [
            'user' => $request->user(),
            'companyList' => $companyList,
        ]);
    }

    public function formAdd(Request $request): View
    {
        $gpsList = Company::get();

        // Ambil IP user yang sedang online
        $ip_user = $request->ip(); // atau bisa juga pakai request()->ip()

        // Ambil lokasi user dari Cache
        $location = Cache::get("user_location_{$ip_user}"); // Default Jakarta

        return view('formCompany.addForm-Company', [
            'user' => $request->user(),
            'gpsList' => $gpsList,
            'latitude' => $location['lat'],
            'longitude' => $location['lon'],
        ]);
    }

    public function store(Request $request)
    {
        $company = new Company();
        $company->name = $request->name;
        $company->type = $request->type;
        $company->alamat = $request->alamat;
        $company->latitude = $request->latitude;
        $company->longitude = $request->longitude;

        $company->save();

        return redirect()->route('company')->with('success', 'Company berhasil ditambahkan!');
    }

    public function formEdit(Request $request, $id): View
    {
        $idGPS = Company::findOrFail($id);
        $companyList = Company::where('id', $id)->first();

        // Ambil IP user yang sedang online
        $ip_user = $request->ip(); // atau bisa juga pakai request()->ip()

        // Ambil lokasi user dari Cache
        $location = Cache::get("user_location_{$ip_user}"); // Default Jakarta

        return view('formCompany.editForm-Company', [
            'user' => $request->user(),
            'companyList' => $companyList,
            'latitude' => $location['lat'],
            'longitude' => $location['lon'],
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

        return redirect()->route('company')->with('success', 'Company berhasil diperbarui!');
    }

    public function delete($id)
    {
        // Cek apakah transaksi ada
        $company = Company::findOrFail($id);
        if (!$company) {
            return redirect()->route('company')->with('error', 'Company tidak ditemukan.');
        }

        // Hapus produk dari company
        $company->delete();

        return redirect()->route('company')->with('success', 'Company berhasil di hapus.');
    }
}
