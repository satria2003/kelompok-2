<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ulasan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class UlasanController extends Controller
{
    public function list($id)
    {
        $ulasan = Ulasan::with('pengguna')
            ->where('id_produk', $id)
            ->orderBy('tanggal_dibuat', 'desc')
            ->get()
            ->map(function ($item) {
                return [
                    'id_ulasan' => $item->id_ulasan,
                    'nama_pengguna' => $item->pengguna->nama_lengkap ?? 'Anonim',
                    'foto_pengguna' => $item->pengguna->foto_profil_url ?? null,
                    'komentar' => $item->komentar,
                    'rating' => $item->rating,
                    'foto_ulasan' => $item->foto_ulasan_url,
                    'tanggal_dibuat' => $item->tanggal_dibuat,
                ];
            });

        return response()->json($ulasan);
    }

    public function store(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized.'], 401);
        }

        $request->validate([
            'rating' => 'required|numeric|min:1|max:5',
            'komentar' => 'required|string',
            'foto_ulasan' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $filename = null;
        if ($request->hasFile('foto_ulasan')) {
            $foto = $request->file('foto_ulasan');
            $filename = 'ulasan/' . uniqid() . '.' . $foto->getClientOriginalExtension();
            $foto->move(public_path('ulasan'), basename($filename));
        }

        $ulasan = Ulasan::create([
            'id_pengguna' => $user->id_pengguna,
            'id_produk' => $id,
            'rating' => $request->rating,
            'komentar' => $request->komentar,
            'tanggal_dibuat' => now(),
            'foto_ulasan' => $filename,
        ]);

        return response()->json(['message' => 'Ulasan berhasil dikirim', 'data' => $ulasan], 201);
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $ulasan = Ulasan::where('id_ulasan', $id)->where('id_pengguna', $user->id_pengguna)->first();

        if (!$ulasan) {
            return response()->json(['message' => 'Ulasan tidak ditemukan atau tidak punya akses'], 404);
        }

        $request->validate([
            'rating' => 'required|numeric|min:1|max:5',
            'komentar' => 'required|string',
            'foto_ulasan' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Hapus foto lama jika ada foto baru
        if ($request->hasFile('foto_ulasan')) {
            if ($ulasan->foto_ulasan && File::exists(public_path($ulasan->foto_ulasan))) {
                File::delete(public_path($ulasan->foto_ulasan));
            }

            $foto = $request->file('foto_ulasan');
            $filename = 'ulasan/' . uniqid() . '.' . $foto->getClientOriginalExtension();
            $foto->move(public_path('ulasan'), basename($filename));
            $ulasan->foto_ulasan = $filename;
        }

        $ulasan->rating = $request->rating;
        $ulasan->komentar = $request->komentar;
        $ulasan->save();

        return response()->json(['message' => 'Ulasan berhasil diperbarui']);
    }

    public function destroy($id)
    {
        $user = Auth::user();
        $ulasan = Ulasan::where('id_ulasan', $id)->where('id_pengguna', $user->id_pengguna)->first();

        if (!$ulasan) {
            return response()->json(['message' => 'Ulasan tidak ditemukan atau tidak punya akses'], 404);
        }

        if ($ulasan->foto_ulasan && File::exists(public_path($ulasan->foto_ulasan))) {
            File::delete(public_path($ulasan->foto_ulasan));
        }

        $ulasan->delete();

        return response()->json(['message' => 'Ulasan berhasil dihapus']);
    }
}
