<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search'); // Ambil keyword pencarian

        $companyList = Company::when($search, function ($query) use ($search) {
            return $query->where('name', 'LIKE', "%{$search}%")
                        ->orWhere('alamat', 'LIKE', "%{$search}%")
                        ->orWhere('type', 'LIKE', "%{$search}%");
        })->paginate(10); // Tambahkan pagination

        return view('company', [
            'title' => 'Company List',
            'companyList' => $companyList,
            'search' => $search
        ]);
    }

    public function formAdd(Request $request): View
    {
        $gpsList = Company::get();
        $title = "Create Company";

        // Ambil IP user yang sedang online
        $ip_user = $request->ip(); // atau bisa juga pakai request()->ip()

        // Ambil lokasi user dari Cache
        $location = Cache::get("user_location_{$ip_user}"); // Default Jakarta

        return view('formCompany.addForm-Company', [
            'gpsList' => $title,
            'user' => $request->user(),
            'gpsList' => $gpsList,
            'latitude' => $location['lat'] ?? -6.2114,
            'longitude' => $location['lon'] ?? 106.8446,
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
        $title = "Edit Company";

        $idGPS = Company::findOrFail($id);
        $companyList = Company::where('id', $id)->first();

        // Ambil IP user yang sedang online
        $ip_user = $request->ip(); // atau bisa juga pakai request()->ip()

        // Ambil lokasi user dari Cache
        $location = Cache::get("user_location_{$ip_user}"); // Default Jakarta

        return view('formCompany.editForm-Company', [
            'user' => $request->user(),
            'title' => $title,
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
