<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AlamatAdmin;

class AlamatPengirimController extends Controller
{
    public function get()
    {
        $alamat = AlamatAdmin::first();
        if (!$alamat) {
            return response()->json(['message' => 'Alamat admin belum diatur'], 404);
        }
        return response()->json($alamat);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_pengirim' => 'required|string',
            'no_telepon' => 'required|string',
            'alamat_lengkap' => 'required|string',
            'provinsi_id' => 'required|integer',
            'ongkir' => 'required|integer',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $alamat = AlamatAdmin::findOrFail($id);
        $alamat->update($request->all());

        return response()->json([
            'message' => 'Alamat admin diperbarui',
            'data' => $alamat,
        ]);
    }
}
