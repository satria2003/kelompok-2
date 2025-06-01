<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    // ✅ Ambil data profil pengguna (GET /api/me)
    public function me(Request $request)
    {
        $user = $request->user() ?? Auth::user();

        if (! $user) {
            return response()->json([
                'message' => 'User tidak ditemukan.',
            ], 401);
        }

        return response()->json([
            'message' => 'Profil ditemukan',
            'data'    => $this->formatUserData($user),
        ]);
    }

    // ✅ Update profil pengguna (POST /api/profile/update)
    public function update(Request $request)
{
    try {
        $user = $request->user() ?? Auth::user();

        if (! $user) {
            return response()->json(['message' => 'User tidak ditemukan.'], 401);
        }

        // Validasi input
        $validated = $request->validate([
            'nama_lengkap' => 'nullable|string|max:255',
            'alamat'       => 'nullable|string|max:255',
            'no_telepon'   => 'nullable|string|max:20',
            'foto_profil'  => 'nullable|file|image|max:2048',
        ]);

        // Simpan foto baru jika ada
        if ($request->hasFile('foto_profil')) {
            // Hapus foto lama kalau ada
            if ($user->foto_profil && file_exists(public_path($user->foto_profil))) {
                unlink(public_path($user->foto_profil));
            }

            $file = $request->file('foto_profil');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('foto_profil'), $filename);

            $validated['foto_profil'] = 'foto_profil/' . $filename;
        }

        $user->update($validated);

        return response()->json([
            'message' => 'Profil berhasil diperbarui',
            'data'    => $this->formatUserData($user),
        ]);
    } catch (\Throwable $e) {
        return response()->json([
            'message' => 'Error: ' . $e->getMessage(),
            'line'    => $e->getLine(),
            'file'    => class_basename($e->getFile()),
        ], 500);
    }
}


    // ✅ Helper struktur data pengguna untuk response API
    protected function formatUserData($user)
    {
        return [
            'id'           => $user->id,
            'username'     => $user->username,
            'nama_lengkap' => $user->nama_lengkap,
            'email'        => $user->email,
            'alamat'       => $user->alamat,
            'no_telepon'   => $user->no_telepon,
            'foto_profil' => $user->foto_profil
    ? asset($user->foto_profil)
    : null,

            'peran'        => $user->peran ?? 'user', // default jika kosong
        ];
    }

    public function ubahPassword(Request $request)
{
    $user = $request->user() ?? Auth::user();

    if (!$user) {
        return response()->json(['message' => 'User tidak ditemukan.'], 401);
    }

    $request->validate([
        'password_lama' => 'required',
        'password_baru' => 'required|min:6|confirmed', // butuh 'password_baru_confirmation'
    ]);

    if (!Hash::check($request->password_lama, $user->password)) {
        return response()->json(['message' => 'Password lama tidak cocok.'], 400);
    }

    $user->password = Hash::make($request->password_baru);
    $user->save();

    return response()->json(['message' => 'Password berhasil diubah.']);
}

}
