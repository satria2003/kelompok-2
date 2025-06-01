<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\Produk;
use App\Models\AlamatAdmin;

class PesananController extends Controller
{

    public function index(Request $request)
{
    $user = $request->user();

    // Ambil alamat admin tetap (misalnya dari admin id = 1)
    $alamatAdmin = AlamatAdmin::first(); // Bisa disesuaikan logika pengambilannya

    $pesanan = Pesanan::with('detail.produk', 'alamat')
        ->where('id_pengguna', $user->id_pengguna)
        ->orderByDesc('tanggal_dibuat')
        ->get();

    return response()->json([
        'message' => 'Data pesanan ditemukan.',
        'data' => $pesanan->map(function ($item) use ($alamatAdmin) {
            return [
                'id_pesanan' => $item->id_pesanan,
                'order_id' => $item->order_id,
                'total_harga' => $item->total_harga,
                'metode_pembayaran' => $item->metode_pembayaran,
                'status' => $item->status,
                'tanggal_dibuat' => $item->tanggal_dibuat,
                'alamat_pengiriman' => $item->alamat_pengiriman,
                'alamat' => $item->alamat ? [
                    'nama_penerima' => $item->alamat->nama_penerima,
                    'no_telepon' => $item->alamat->no_telepon,
                    'alamat_lengkap' => $item->alamat->alamat_lengkap,
                    'latitude' => $item->alamat->latitude,
                    'longitude' => $item->alamat->longitude,
                ] : null,
                'alamat_admin' => $alamatAdmin ? [
                    'nama_pengirim' => $alamatAdmin->nama_pengirim,
                    'no_telepon' => $alamatAdmin->no_telepon,
                    'alamat_lengkap' => $alamatAdmin->alamat_lengkap,
                    'latitude' => $alamatAdmin->latitude,
                    'longitude' => $alamatAdmin->longitude,
                ] : null,
                'detail' => $item->detail->map(function ($d) {
                    return [
                        'jumlah' => $d->jumlah,
                        'harga_satuan' => $d->harga_satuan,
                        'produk' => $d->produk ? [
                            'id_produk' => $d->produk->id_produk,
                            'nama_produk' => $d->produk->nama_produk,
                            'foto_produk' => $d->produk->foto_produk,
                        ] : null,
                    ];
                }),
            ];
        }),
    ]);
}

    public function showByOrderId(Request $request)
    {
        $request->validate([
            'order_id' => 'required|string',
        ]);

        $user = $request->user();

        $pesanan = Pesanan::where('order_id', $request->order_id)
            ->where('id_pengguna', $user->id_pengguna)
            ->first();

        if (!$pesanan) {
            return response()->json(['message' => 'Pesanan tidak ditemukan'], 404);
        }

        return response()->json([
            'order_id' => $pesanan->order_id,
            'status' => $pesanan->status,
            'total' => $pesanan->total_harga,
        ]);
    }

    public function batalkanJikaBelumBayar(Request $request)
    {
        $request->validate([
            'order_id' => 'required|string',
        ]);

        $user = $request->user();

        $pesanan = Pesanan::with('detail')->where('order_id', $request->order_id)
            ->where('id_pengguna', $user->id_pengguna)
            ->first();

        if (!$pesanan) {
            return response()->json(['message' => 'Pesanan tidak ditemukan'], 404);
        }

        if ($pesanan->status === 'menunggu') {
            // Kembalikan stok
            foreach ($pesanan->detail as $detail) {
                $produk = Produk::find($detail->id_produk);
                if ($produk) {
                    $produk->stok += $detail->jumlah;
                    $produk->save();
                }
            }

            $pesanan->update(['status' => 'dibatalkan']);
            return response()->json(['message' => 'Pesanan dibatalkan dan stok dikembalikan.']);
        }

        return response()->json(['message' => 'Status pesanan tidak dapat dibatalkan'], 400);
    }

    public function alamat()
{
    return $this->belongsTo(AlamatPengguna::class, 'alamat_pengiriman');
}

}
