<?php

namespace App\Http\Controllers;

use App\Models\PartRequest;
use App\Models\PartRequestDetail;
use App\Models\SparePart;
use App\Models\Vehicle;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class RequestPartController extends Controller
{
    public function index(Request $request): View
    {
        $title = "Request Spare Part";

        $requestList = PartRequest::get();
        $partList = SparePart::get();
        $vehicleList = Vehicle::get();
        $requestListDetail = PartRequestDetail::with(['parts', 'request'])->get();
        $MasterTransaction = PartRequest::with(['detailRequest'])  // Tambahkan with() di sini
            ->orderBy('id', 'desc')
            ->first();

        $lastCode = $MasterTransaction ? intval(substr($MasterTransaction->kode_transaksi, 3)) : 0;
        $newCode = 'SPR' . str_pad($lastCode + 1, 3, '0', STR_PAD_LEFT);

        return view('sparepartReq', [
            'user' => $request->user(),
            'title' => $title,
            'requestListDetail' => $requestListDetail,
            'requestList' => $requestList,
            'newCode' => $newCode,
            'partList' => $partList,
            'vehicleList' => $vehicleList,
            'MasterTransaction' => $MasterTransaction,
        ]);
    }

    public function store(Request $request)
    {
        // First create the main request record
        $partRequest = PartRequest::create([
            'kode_transaksi' => $request->kode_transaksi,
            'vehicle_id' => $request->vehicle_id,
            'tanggal' => $request->tanggal,
        ]);

        // Simpan detail transaksi dan kurangi stok produk
        foreach ($request->produk as $index => $id_parts) {
            $product = SparePart::find($id_parts);

            if (!$product) {
                return redirect()->back()->with('error', 'Produk dengan ID ' . $id_parts . ' tidak ditemukan!');
            }

            if ($product->stock_quantity < $request->quantity[$index]) {
                return redirect()->back()->with('error', 'Stok tidak mencukupi untuk produk ' . $product->name);
            }

            // Buat detail transaksi
            PartRequestDetail::create([
                'id_request' => $partRequest->id,
                'id_parts' => $id_parts,
                'quantity' => $request->quantity[$index],
            ]);

            // Kurangi stok di tabel SparePart
            $product->decrement('stock_quantity', $request->quantity[$index]);
        }

        return redirect()->back()->with('success', 'Transaksi berhasil ditambahkan!');
    }
}
