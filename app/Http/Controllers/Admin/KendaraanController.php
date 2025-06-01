<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kendaraan;
use App\Models\Kurir;
use Illuminate\Http\Request;

class KendaraanController extends Controller
{
    public function index()
    {
        $kendaraans = Kendaraan::with('kurir')->get();
        return view('admin.kurir.kendaraan', compact('kendaraans'));
    }

    public function create()
    {
        $kurirs = Kurir::all();
        return view('admin.kurir.kendaraan-create', compact('kurirs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'plat_nomor' => 'required|string|max:255',
            'jenis' => 'required|string|max:255',
            'merk' => 'required|string|max:255',
            'kurir_id' => 'nullable|exists:kurirs,id',
        ]);

        Kendaraan::create($request->all());

        return redirect()->route('admin.kendaraan.index')->with('success', 'Kendaraan berhasil ditambahkan.');
    }

    public function edit(Kendaraan $kendaraan)
    {
        $kurirs = Kurir::all();
        return view('admin.kurir.kendaraan-edit', compact('kendaraan', 'kurirs'));
    }

    public function update(Request $request, Kendaraan $kendaraan)
    {
        $request->validate([
            'plat_nomor' => 'required|string|max:255',
            'jenis' => 'required|string|max:255',
            'merk' => 'required|string|max:255',
            'kurir_id' => 'nullable|exists:kurirs,id',
        ]);

        $kendaraan->update($request->all());

        return redirect()->route('admin.kendaraan.index')->with('success', 'Kendaraan berhasil diperbarui.');
    }

    public function destroy(Kendaraan $kendaraan)
    {
        $kendaraan->delete();
        return redirect()->route('admin.kendaraan.index')->with('success', 'Kendaraan berhasil dihapus.');
    }
}
