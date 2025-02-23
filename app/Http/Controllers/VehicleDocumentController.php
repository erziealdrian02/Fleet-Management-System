<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\Vehicle;
use App\Models\VehicleDocument;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VehicleDocumentController extends Controller
{
    public function index(Request $request): View
    {
        $title = "Vehicle Document";

        $documentList = VehicleDocument::get();
        $vehiclesList = Vehicle::all();

        return view('vehicleDocument', [
            'user' => $request->user(),
            'title' => $title,
            'documentList' => $documentList,
            'vehiclesList' => $vehiclesList,
        ]);
    }

    public function store(Request $request)
    {
        // Validasi Input
        $request->validate([
            'document_file'  => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048', // Maks 2MB
        ]);

        // Simpan Dokumen
        $document = new VehicleDocument();
        $document->vehicle_id = $request->vehicle_id;
        $document->document_type = $request->document_type;
        $document->issue_date = $request->issue_date;
        $document->expiry_date = $request->expiry_date;

        // Upload File
        if ($request->hasFile('document_file')) {
            $file = $request->file('document_file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('documents', $fileName, 'public'); // Simpan di storage/public/documents

            $document->document_file = 'storage/' . $filePath;
        }

        $document->save();

        return redirect()->back()->with('success', 'Dokumen kendaraan berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $document = VehicleDocument::findOrFail($id);

        $document->vehicle_id = $request->vehicle_id;
        $document->document_type = $request->document_type;
        $document->issue_date = $request->issue_date;
        $document->expiry_date = $request->expiry_date;

        // Upload File
        if ($request->hasFile('document_file')) {
            $file = $request->file('document_file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('documents', $fileName, 'public'); // Simpan di storage/public/documents

            $document->document_file = 'storage/' . $filePath;
        } else {

        }

        $document->save();

        return redirect()->back()->with('success', 'Kendaraan berhasil diperbarui!');
    }

    public function delete($id)
    {
        // Cek apakah transaksi ada
        $vehicle = VehicleDocument::findOrFail($id);
        if (!$vehicle) {
            return redirect()->route('document')->with('error', 'vehicle tidak ditemukan.');
        }

        // Hapus produk dari vehicle
        $vehicle->delete();

        return redirect()->route('document')->with('success', 'Product berhasil di hapus.');
    }
}
