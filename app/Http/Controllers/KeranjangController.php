<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use Illuminate\Http\Request;

class KeranjangController extends Controller
{
    // Ambil semua keranjang milik user yang login
    public function index(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Unauthenticated'], 401);
        }

        $keranjang = Keranjang::with('produk')
            ->where('id_pengguna', $user->id)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $keranjang
        ]);
    }

    // Tambah item ke keranjang (atau update jumlah jika sudah ada)
    public function store(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Unauthenticated'], 401);
        }

        $request->validate([
            'id_produk' => 'required|exists:produk,id_produk',
            'jumlah' => 'required|integer|min:1',
        ]);

        // Cek apakah produk sudah ada di keranjang user
        $existing = Keranjang::where('id_pengguna', $user->id)
            ->where('id_produk', $request->id_produk)
            ->first();

        if ($existing) {
            $existing->jumlah += $request->jumlah;
            $existing->save();

            return response()->json([
                'success' => true,
                'message' => 'Jumlah produk diperbarui',
                'data' => $existing
            ]);
        }

        // Tambah item baru ke keranjang
        $keranjang = Keranjang::create([
            'id_pengguna' => $user->id,
            'id_produk' => $request->id_produk,
            'jumlah' => $request->jumlah,
            'tanggal_dibuat' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil ditambahkan ke keranjang',
            'data' => $keranjang
        ], 201);
    }

    // Update jumlah item di keranjang
    public function update(Request $request, $id)
    {
        $request->validate([
            'jumlah' => 'required|integer|min:1',
        ]);

        $keranjang = Keranjang::where('id', $id)
            ->where('id_pengguna', $request->user()->id)
            ->firstOrFail();

        $keranjang->jumlah = $request->jumlah;
        $keranjang->save();

        return response()->json([
            'success' => true,
            'message' => 'Keranjang berhasil diperbarui',
            'data' => $keranjang
        ]);
    }

    // Hapus item dari keranjang
    public function destroy(Request $request, $id)
    {
        $keranjang = Keranjang::where('id', $id)
            ->where('id_pengguna', $request->user()->id)
            ->firstOrFail();

        $keranjang->delete();

        return response()->json([
            'success' => true,
            'message' => 'Item keranjang berhasil dihapus'
        ]);
    }
}
