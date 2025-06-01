<?php
use Illuminate\Http\Request;
use App\Models\AlamatAdmin;

class AlamatPengirimController extends Controller
{
    // GET: Ambil alamat admin
    public function get()
    {
        $alamat = AlamatAdmin::first(); // Asumsinya hanya satu alamat admin
        if (!$alamat) {
            return response()->json(['message' => 'Alamat admin belum diatur'], 404);
        }

        return response()->json($alamat);
    }

    // PUT: Update alamat admin
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
            'message' => 'Alamat admin berhasil diperbarui',
            'data' => $alamat,
        ]);
    }
}
