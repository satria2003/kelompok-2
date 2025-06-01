<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\AlamatPengguna;
use App\Mail\StatusPesananChangedMail;
use Illuminate\Support\Facades\Mail;

class PesananController extends Controller
{
    /**
     * Tampilkan daftar semua pesanan (untuk admin).
     */
    public function index(Request $request)
    {
        $query = Pesanan::with(['pengguna', 'detail.produk'])
            ->orderBy('tanggal_dibuat', 'desc');

        // Filter berdasarkan status jika ada
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $pesanans = $query->get();

        return view('admin.pesanan.index', compact('pesanans'));
    }

    /**
     * Tampilkan detail satu pesanan (untuk admin).
     */
    public function show($id)
    {
        $pesanan = Pesanan::with([
            'pengguna',
            'detail.produk'
        ])->findOrFail($id);

        // Ambil alamat default pengguna dari tabel alamat_pengguna
        $alamat = AlamatPengguna::where('pengguna_id', $pesanan->id_pengguna)
            ->where('is_default', 1)
            ->first();

        return view('admin.pesanan.show', compact('pesanan', 'alamat'));
    }

    /**
     * Hapus pesanan dari database.
     */
    public function destroy($id)
    {
        $pesanan = Pesanan::findOrFail($id);
        $pesanan->delete();

        return redirect()->route('admin.pesanan.index')->with('success', 'Pesanan berhasil dihapus!');
    }

    /**
     * Update status pesanan dan kirim email ke pengguna.
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:menunggu,disiapkan,diantar,selesai,dibatalkan',
        ]);

        $pesanan = Pesanan::with('pengguna')->findOrFail($id);
        $pesanan->status = $request->status;
        $pesanan->save();

        // Kirim email notifikasi jika pengguna dan email tersedia
        if ($pesanan->pengguna && $pesanan->pengguna->email) {
            Mail::to($pesanan->pengguna->email)->send(new StatusPesananChangedMail(
                $pesanan->pengguna->username,
                $pesanan->status,
                $pesanan
            ));
        }

        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui dan notifikasi dikirim.');
    }
}
