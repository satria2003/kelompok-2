<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kendaraan;
use Illuminate\Http\Request;

class KendaraanController extends Controller
{
    public function index()
    {
        return response()->json(Kendaraan::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'plat_nomor' => 'required',
            'jenis' => 'required',
            'merk' => 'required',
            'status' => 'required',
        ]);

        $kendaraan = Kendaraan::create([
            'plat_nomor' => $request->plat_nomor,
            'jenis' => $request->jenis,
            'merk' => $request->merk,
            'status' => $request->status,
            'digunakan' => false,
        ]);

        return response()->json(['message' => 'Kendaraan ditambahkan', 'kendaraan' => $kendaraan]);
    }

    public function togglePenggunaan($id)
    {
        $kendaraan = Kendaraan::findOrFail($id);

        // reset semua kendaraan lain
        Kendaraan::where('id', '!=', $id)->update(['digunakan' => false]);

        // toggle kendaraan ini
        $kendaraan->digunakan = !$kendaraan->digunakan;
        $kendaraan->save();

        return response()->json([
            'message' => $kendaraan->digunakan ? 'Kendaraan digunakan' : 'Kendaraan tidak digunakan',
            'kendaraan' => $kendaraan
        ]);
    }
}
