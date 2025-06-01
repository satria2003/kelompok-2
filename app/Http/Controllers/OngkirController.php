<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AlamatAdmin;

class OngkirController extends Controller
{
    public function cekOngkir(Request $request)
    {
        $destinationProvId = $request->query('destination');

        if (!$destinationProvId) {
            return response()->json(['message' => 'destination wajib diisi'], 400);
        }

        $alamatAdmin = AlamatAdmin::first();

        if (!$alamatAdmin) {
            return response()->json(['message' => 'Alamat admin belum tersedia'], 500);
        }

        // Hitung jarak antar provinsi (dummy, bisa kamu ganti ke hitung real nanti)
        $jarakKm = $this->hitungJarakAntarProvinsi($alamatAdmin->provinsi_id, $destinationProvId);

        // Ambil tarif per 5 km dari DB
        $tarifPer5Km = $alamatAdmin->ongkir ?? 50000;

        // Hitung total ongkir
        $totalOngkir = ceil($jarakKm / 5) * $tarifPer5Km;

        return response()->json([
            'distance_km' => $jarakKm,
            'ongkir' => $totalOngkir,
        ]);
    }

    private function hitungJarakAntarProvinsi($originId, $destinationId)
    {
        // Dummy data jarak antar provinsi
        $dummyJarak = [
            '32-31' => 10, // Jabar ke DKI
            '32-33' => 20, // Jabar ke Jateng
            '32-34' => 40, // Jabar ke Jatim
        ];

        $key = "$originId-$destinationId";
        return $dummyJarak[$key] ?? 5; // default minimal 5km
    }
}
