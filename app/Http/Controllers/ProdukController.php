<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Ulasan;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index()
    {
        $produk = Produk::withAvg('ulasan', 'rating')->get()->map(function ($item) {
            return [
                'id_produk' => $item->id_produk,
                'nama_produk' => $item->nama_produk,
                'deskripsi' => $item->deskripsi,
                'harga' => $item->harga,
                'stok' => $item->stok,
                'id_kategori' => $item->id_kategori,
                'foto_produk' => $item->foto_produk,
                'tanggal_dibuat' => $item->tanggal_dibuat,
                'diskon' => $item->diskon,
                'harga_format' => 'Rp ' . number_format($item->harga, 0, ',', '.'),
                'label' => null,
                'berat' => $item->berat,
                'rata_rata_rating' => round($item->ulasan_avg_rating ?? 0, 1),
            ];
        });

        return response()->json($produk);
    }

    public function show($id)
    {
        $produk = Produk::withAvg('ulasan', 'rating')->find($id);

        if (!$produk) {
            return response()->json(['message' => 'Produk tidak ditemukan'], 404);
        }

        return response()->json([
            'id_produk' => $produk->id_produk,
            'nama_produk' => $produk->nama_produk,
            'deskripsi' => $produk->deskripsi,
            'harga' => $produk->harga,
            'diskon' => $produk->diskon,
            'stok' => $produk->stok,
            'berat' => $produk->berat,
            'foto_produk' => $produk->foto_produk,
            'tanggal_dibuat' => $produk->tanggal_dibuat,
            'id_kategori' => $produk->id_kategori,
            'harga_format' => 'Rp ' . number_format($produk->harga, 0, ',', '.'),
            'label' => null,
            'rata_rata_rating' => round($produk->ulasan_avg_rating ?? 0, 1),
        ]);
    }
}
