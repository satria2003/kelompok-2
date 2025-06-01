<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Models\User;

class AuthController extends Controller
{
    // ===============================
    // 📥 FORM LOGIN (WEB ADMIN / CS)
    // ===============================
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->peran === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($user->peran === 'customer_service') {
                return redirect()->route('cs.dashboard');
            } else {
                return redirect()->route('home');
            }
        }

        return back()->withErrors(['email' => 'Email atau password salah.']);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }

    // ===============================
    // 🔐 API LOGIN (FLUTTER)
    // ===============================
    public function apiLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if (!$user->email_verified_at) {
                return response()->json([
                    'message' => 'Akun belum diverifikasi.',
                ], 403);
            }

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
                'pengguna' => [
                    'id_pengguna' => $user->id_pengguna ?? $user->id,
                    'username' => $user->username,
                    'email' => $user->email,
                    'peran' => $user->peran,
                ],
            ], 200);
        }

        return response()->json([
            'message' => 'Email atau password salah.',
        ], 401);
    }

    // ===============================
    // 📝 REGISTRASI (USER / FLUTTER)
    // ===============================
    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:pengguna|max:50',
            'email' => 'required|email|unique:pengguna|max:100',
            'password' => 'required|min:6|confirmed',
            'no_telepon' => 'nullable|max:15',
            'alamat' => 'nullable',
            'foto_profil' => 'nullable|image|max:2048',
        ]);

        $token = Str::random(6);

        $user = new User();
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->no_telepon = $request->no_telepon;
        $user->alamat = $request->alamat;
        $user->peran = 'pelanggan';
        $user->token_verifikasi = $token;

        if ($request->hasFile('foto_profil')) {
            $file = $request->file('foto_profil');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/profil'), $filename);
            $user->foto_profil = 'uploads/profil/' . $filename;
        }

        $user->save();

        // ✅ Kirim token ke email
        Mail::send('emails.verifikasi_token', ['token' => $token, 'user' => $user], function ($message) use ($user) {
            $message->to($user->email)
                    ->subject('Token Verifikasi Akun');
        });

        return response()->json([
            'message' => 'Registrasi berhasil, token telah dikirim ke email.',
            'email' => $user->email,
        ], 200);
    }

    // ===============================
    // ✅ VERIFIKASI TOKEN
    // ===============================
    public function verifyToken(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'token' => 'required',
        ]);

        $user = User::where('email', $request->email)
                    ->where('token_verifikasi', $request->token)
                    ->first();

        if (!$user) {
            return response()->json(['message' => 'Token tidak valid.'], 400);
        }

        $user->email_verified_at = now();
        $user->token_verifikasi = null;
        $user->save();

        return response()->json(['message' => 'Verifikasi berhasil.'], 200);
    }

    // ===============================
    // 🔁 KIRIM ULANG TOKEN VERIFIKASI
    // ===============================
    public function resendToken(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'Email tidak ditemukan.'], 404);
        }

        if ($user->email_verified_at) {
            return response()->json(['message' => 'Email sudah diverifikasi.'], 400);
        }

        $token = Str::random(6);
        $user->token_verifikasi = $token;
        $user->save();

        // ✅ Kirim ulang token ke email
        Mail::send('emails.verifikasi_token', ['token' => $token, 'user' => $user], function ($message) use ($user) {
            $message->to($user->email)
                    ->subject('Token Verifikasi Akun');
        });

        return response()->json(['message' => 'Token verifikasi berhasil dikirim ulang.'], 200);
    }
}
