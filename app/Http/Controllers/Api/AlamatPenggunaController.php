<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\AlamatPengguna;

class AlamatPenggunaController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $alamat = AlamatPengguna::where('pengguna_id', $userId)->get();
        return response()->json($alamat);
    }

    public function default()
    {
        $userId = Auth::id();
        $alamat = AlamatPengguna::where('pengguna_id', $userId)->where('is_default', true)->first();

        if (!$alamat) {
            return response()->json(['message' => 'Alamat default tidak ditemukan'], 404);
        }

        return response()->json($alamat);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_penerima' => 'required|string|max:100',
            'no_telepon' => 'required|string|max:20',
            'alamat_lengkap' => 'required|string',
            'provinsi_id' => 'required|numeric',
            'nama_provinsi' => 'required|string|max:100',
            'kodepos' => 'nullable|string|max:10',
            'is_default' => 'boolean',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $alamat = AlamatPengguna::create([
            'pengguna_id' => Auth::id(),
            'nama_penerima' => $request->nama_penerima,
            'no_telepon' => $request->no_telepon,
            'alamat_lengkap' => $request->alamat_lengkap,
            'provinsi_id' => $request->provinsi_id,
            'nama_provinsi' => $request->nama_provinsi,
            'kodepos' => $request->kodepos,
            'is_default' => $request->is_default ?? false,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        return response()->json($alamat, 201);
    }

    public function update(Request $request, $id)
    {
        $alamat = AlamatPengguna::where('pengguna_id', Auth::id())->where('id', $id)->firstOrFail();

        $validator = Validator::make($request->all(), [
            'nama_penerima' => 'required|string|max:100',
            'no_telepon' => 'required|string|max:20',
            'alamat_lengkap' => 'required|string',
            'provinsi_id' => 'required|numeric',
            'nama_provinsi' => 'required|string|max:100',
            'kodepos' => 'nullable|string|max:10',
            'is_default' => 'boolean',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $alamat->update($request->only([
            'nama_penerima',
            'no_telepon',
            'alamat_lengkap',
            'provinsi_id',
            'nama_provinsi',
            'kodepos',
            'is_default',
            'latitude',
            'longitude',
        ]));

        return response()->json($alamat);
    }

    public function destroy($id)
    {
        $alamat = AlamatPengguna::where('pengguna_id', Auth::id())->where('id', $id)->firstOrFail();
        $alamat->delete();
        return response()->json(['message' => 'Alamat berhasil dihapus']);
    }
}
