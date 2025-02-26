<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\SparePart;
use App\Models\Vehicle;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class SparePartController extends Controller
{
    public function index(Request $request): View
    {
        $title = "Spare Part";

        $spareList = SparePart::get();

        return view('sparepart', [
            'user' => $request->user(),
            'title' => $title,
            'spareList' => $spareList,
        ]);
    }

    public function store(Request $request)
    {
        $spare = new SparePart();
        $spare->name = $request->name;
        $spare->part_number = $request->part_number;
        $spare->stock_quantity = $request->stock_quantity;
        $spare->price = $request->price;

        $spare->save();

        return redirect()->back()->with('success', 'Spare Part berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $spare = SparePart::findOrFail($id);

        $spare->name = $request->name;
        $spare->part_number = $request->part_number;
        $spare->stock_quantity = $request->stock_quantity;
        $spare->price = $request->price;

        $spare->save();

        return redirect()->back()->with('success', 'Kendaraan berhasil diperbarui!');
    }

    public function delete($id)
    {
        // Cek apakah transaksi ada
        $spare = SparePart::findOrFail($id);
        if (!$spare) {
            return redirect()->route('spareparts')->with('error', 'Spare Parts tidak ditemukan.');
        }

        // Hapus produk dari spare
        $spare->delete();

        return redirect()->route('spareparts')->with('success', 'Spare Parts berhasil di hapus.');
    }
}
