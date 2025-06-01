<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\Kurir;
use App\Models\Pesanan;

class KurirController extends Controller
{
    /**
     * 👤 Ambil profil kurir
     */
    public function profile(Request $request)
    {
        return response()->json($request->user());
    }

    /**
     * 📦 Daftar pesanan berdasarkan kurir yang login
     */
    public function daftarPesanan()
    {
        $kurir = Auth::user();

        $pesanan = Pesanan::where('id_kurir', $kurir->id)->get();

        return response()->json($pesanan);
    }

    /**
     * ⚒️ Update status pesanan oleh kurir
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string',
        ]);

        $pesanan = Pesanan::where('id', $id)
                          ->where('id_kurir', Auth::id())
                          ->first();

        if (!$pesanan) {
            return response()->json([
                'message' => 'Pesanan tidak ditemukan atau bukan milik Anda'
            ], 404);
        }

        $pesanan->status = $request->status;
        $pesanan->save();

        return response()->json([
            'message' => "Status pesanan berhasil diperbarui menjadi {$request->status}"
        ]);
    }

    /**
     * 🚪 Login kurir hanya dengan email → kirim token login
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $kurir = Kurir::where('email', $request->email)->first();

        if (!$kurir) {
            return response()->json([
                'message' => 'Email tidak terdaftar'
            ], 404);
        }

        if (!$kurir->email_verified_at) {
            return response()->json([
                'message' => 'Email belum diverifikasi oleh admin'
            ], 403);
        }

        $token = mt_rand(100000, 999999);
        $kurir->update(['token_login' => $token]);

        Mail::raw("Kode login Anda adalah: {$token}", function ($message) use ($kurir) {
            $message->to($kurir->email)
                    ->subject('Kode Login Kurir - HNFRTOOLS');
        });

        return response()->json([
            'message' => 'Token login telah dikirim ke email Anda'
        ]);
    }

    /**
     * ✅ Verifikasi token login kurir
     */
    public function verifikasiTokenLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'token' => 'required|numeric',
        ]);

        $kurir = Kurir::where('email', $request->email)
                      ->where('token_login', $request->token)
                      ->first();

        if (!$kurir) {
            return response()->json([
                'message' => 'Token salah atau tidak valid'
            ], 401);
        }

        // Kosongkan token login setelah sukses
        $kurir->update(['token_login' => null]);

        // Generate token Sanctum
        $token = $kurir->createToken('kurir-token')->plainTextToken;

        return response()->json([
            'message' => 'Login berhasil',
            'token' => $token,
            'kurir' => $kurir
        ]);
    }
}
