<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\Pengguna;
use App\Models\Kurir;

class AuthController extends Controller
{
    /**
     * Login pengguna biasa
     */
    public function login(Request $request)
    {
        $pengguna = Pengguna::where('email', $request->email)->first();

        if (!$pengguna || !Hash::check($request->password, $pengguna->password)) {
            return response()->json(['message' => 'Email atau password salah'], 401);
        }

        $token = $pengguna->createToken('flutter-token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'pengguna' => $pengguna
        ]);
    }

    /**
     * Logout pengguna / kurir
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logout berhasil']);
    }

    /**
     * Ambil data pengguna saat ini
     */
    public function me(Request $request)
    {
        return response()->json($request->user());
    }

    /**
     * Login kurir dengan email → kirim token ke email jika verified
     */
    public function loginKurir(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $kurir = Kurir::where('email', $request->email)->first();

        if (!$kurir) {
            return response()->json(['message' => 'Email tidak ditemukan.'], 404);
        }

        if (!$kurir->email_verified_at) {
            return response()->json(['message' => 'Email belum diverifikasi.'], 403);
        }

        $token = mt_rand(100000, 999999);
        $kurir->update(['token_login' => $token]);

        Mail::raw("Kode login kurir Anda adalah: {$token}", function ($message) use ($kurir) {
            $message->to($kurir->email)->subject('Kode Login Kurir - HNFRTOOLS');
        });

        return response()->json(['message' => 'Token login dikirim ke email']);
    }

    /**
     * Verifikasi token login kurir
     */
    public function verifikasiTokenKurir(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'token' => 'required|numeric',
        ]);

        $kurir = Kurir::where('email', $request->email)
                      ->where('token_login', $request->token)
                      ->first();

        if (!$kurir) {
            return response()->json(['message' => 'Token salah atau tidak valid'], 401);
        }

        $kurir->update(['token_login' => null]);

        $token = $kurir->createToken('kurir-token')->plainTextToken;

        return response()->json([
            'message' => 'Login berhasil',
            'token' => $token,
            'kurir' => $kurir,
        ]);
    }
}
