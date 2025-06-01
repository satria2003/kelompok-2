<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\Kurir;

class KurirController extends Controller
{
    /**
     * 📋 Tampilkan daftar kurir
     */
    public function index()
    {
        $kurirs = Kurir::latest()->get();
        return view('admin.kurir.index', compact('kurirs'));
    }

    /**
     * ➕ Form tambah kurir (kalau pakai halaman terpisah)
     */
    public function create()
    {
        return view('admin.kurir.create');
    }

    /**
     * 💾 Simpan data kurir
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|email|unique:kurirs,email',
            'no_telepon' => 'nullable|string|max:20',
        ]);

        $token = mt_rand(100000, 999999);

        $kurir = Kurir::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'no_telepon' => $request->no_telepon,
            'email_verifikasi_token' => $token,
            'email_verified_at' => null,
        ]);

        Mail::raw("Kode verifikasi email kurir Anda adalah: {$token}", function ($message) use ($kurir) {
            $message->to($kurir->email)
                    ->subject('Verifikasi Email Kurir - HNFRTOOLS');
        });

        return redirect()->route('admin.kurir.index')
            ->with('success', 'Kurir berhasil ditambahkan. Token verifikasi telah dikirim ke email.');
    }

    /**
     * 📨 Form input token verifikasi (dari admin, bukan login kurir)
     */
    public function showPendaftaranForm()
    {
        return view('admin.kurir.verifikasi'); // letakkan blade-nya di resources/views/admin/kurir/verifikasi.blade.php
    }

    /**
     * ✅ Proses verifikasi token oleh admin
     */
    public function verifikasi(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'token' => 'required|numeric',
        ]);

        $kurir = Kurir::where('email', $request->email)
                      ->where('email_verifikasi_token', $request->token)
                      ->first();

        if (!$kurir) {
            return redirect()->route('admin.kurir.index')
                ->with('error', 'Token tidak valid atau email salah.');
        }

        $kurir->update([
            'email_verified_at' => now(),
            'email_verifikasi_token' => null,
        ]);

        return redirect()->route('admin.kurir.index')
            ->with('success', 'Email kurir berhasil diverifikasi.');
    }
}
