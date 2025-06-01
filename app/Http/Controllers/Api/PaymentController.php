<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use App\Models\Produk;
use App\Models\AlamatPengguna;
use Midtrans\Snap;
use Midtrans\Config as MidtransConfig;

class PaymentController extends Controller
{
    public function checkout(Request $request)
    {
        MidtransConfig::$serverKey = config('midtrans.server_key');
        MidtransConfig::$isProduction = config('midtrans.is_production');
        MidtransConfig::$isSanitized = true;
        MidtransConfig::$is3ds = true;

        $request->validate([
            'produk' => 'required|array',
            'produk.*.id_produk' => 'required|exists:produk,id_produk',
            'produk.*.jumlah' => 'required|integer|min:1',
            'payment_method' => 'required|string',
            'total' => 'required|numeric|min:1000',
        ]);

        $user = $request->user();
        $alamat = AlamatPengguna::where('pengguna_id', $user->id_pengguna)->where('is_default', 1)->first();
        if (!$alamat) {
            return response()->json(['message' => 'Alamat default tidak ditemukan.'], 400);
        }

        $orderId = 'ORDER-' . strtoupper(Str::random(16));
        $totalHargaProduk = 0;
        $itemDetails = [];

        DB::beginTransaction();
        try {
            $pesanan = Pesanan::create([
                'id_pengguna' => $user->id_pengguna,
                'order_id' => $orderId,
                'status' => 'disiapkan',
                'total_harga' => $request->total,
                'metode_pembayaran' => $request->payment_method,
                'alamat_pengiriman' => $alamat->alamat_lengkap,
                'alamat_pengguna_id' => $alamat->id,
            ]);

            foreach ($request->produk as $item) {
                $produk = Produk::findOrFail($item['id_produk']);
                $hargaFinal = intval($produk->harga - ($produk->harga * $produk->diskon / 100));
                $subtotal = $hargaFinal * $item['jumlah'];
                $totalHargaProduk += $subtotal;

                if ($produk->stok < $item['jumlah']) {
                    throw new \Exception("Stok produk '{$produk->nama_produk}' tidak mencukupi.");
                }

                $produk->stok -= $item['jumlah'];
                $produk->save();

                DetailPesanan::create([
                    'id_pesanan' => $pesanan->id_pesanan,
                    'id_produk' => $produk->id_produk,
                    'jumlah' => $item['jumlah'],
                    'harga_satuan' => $hargaFinal,
                ]);

                $itemDetails[] = [
                    'id' => 'PROD-' . $produk->id_produk,
                    'price' => $hargaFinal,
                    'quantity' => $item['jumlah'],
                    'name' => substr(preg_replace('/[^A-Za-z0-9 ]/', '', $produk->nama_produk), 0, 50),
                ];
            }

            $ongkir = $request->total - $totalHargaProduk;
            $itemDetails[] = [
                'id' => 'ONGKIR',
                'price' => $ongkir,
                'quantity' => 1,
                'name' => 'Ongkos Kirim',
            ];

            $nama = explode(' ', $user->username);
            $params = [
                'enabled_payments' => [$request->payment_method],
                'transaction_details' => [
                    'order_id' => $orderId,
                    'gross_amount' => $request->total,
                ],
                'item_details' => $itemDetails,
                'customer_details' => [
                    'first_name' => $nama[0],
                    'last_name' => $nama[1] ?? '',
                    'email' => $user->email,
                    'phone' => $alamat->no_telepon,
                    'shipping_address' => [
                        'address' => $alamat->alamat_lengkap,
                        'city' => $alamat->nama_provinsi ?? '',
                        'postal_code' => $alamat->kodepos ?? '',
                        'country_code' => 'IDN',
                    ],
                ],
            ];

            Log::info('Midtrans Request Params', $params);

            $snap = Snap::createTransaction($params);
            Log::info('Midtrans Response', (array) $snap);

            DB::commit();

            return response()->json([
                'snap_token' => $snap->token,
                'redirect_url' => $snap->redirect_url,
                'order_id' => $orderId,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Checkout error: ' . $e->getMessage());
            return response()->json(['message' => 'Checkout gagal', 'error' => $e->getMessage()], 500);
        }
    }

    public function callback(Request $request)
    {
        \Log::info('📩 CALLBACK MASUK', ['payload' => $request->all()]);

        $transaction = $request->input('transaction_status');
        $orderId = $request->input('order_id');

        $pesanan = Pesanan::where('order_id', $orderId)->first();
        if (!$pesanan) {
            return response()->json(['message' => 'Pesanan tidak ditemukan'], 404);
        }

        if ($transaction === 'settlement') {
            $pesanan->status = 'disiapkan';
        } elseif (in_array($transaction, ['deny', 'expire', 'cancel'])) {
            $pesanan->status = 'dibatalkan';

            // ✅ Kembalikan stok produk
            foreach ($pesanan->detailPesanan as $detail) {
                $produk = Produk::find($detail->id_produk);
                if ($produk) {
                    $produk->stok += $detail->jumlah;
                    $produk->save();
                }
            }
        } elseif ($transaction === 'pending') {
            $pesanan->status = 'menunggu';
        }

        $pesanan->save();
        \Log::info("✅ Callback berhasil untuk $orderId, status: {$pesanan->status}");

        return response()->json(['message' => 'Notifikasi diproses']);
    }
}
