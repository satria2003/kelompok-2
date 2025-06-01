<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class BinderbyteService
{
    protected string $apiKey;
    protected string $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('binderserver.api_key');
        $this->baseUrl = config('binderserver.base_url', 'https://api.binderbyte.com');
    }

    public function getProvinces()
    {
        $response = Http::get("{$this->baseUrl}/wilayah/provinsi", [
            'api_key' => $this->apiKey
        ]);

        return $response->json();
    }

    public function getCities(string $provinceId)
    {
        $response = Http::get("{$this->baseUrl}/wilayah/kabupaten", [
            'id_provinsi' => $provinceId,
            'api_key' => $this->apiKey
        ]);

        return $response->json();
    }

    public function checkOngkir(string $origin, string $destination, int $weight, string $courier)
    {
        if ($courier === 'internal') {
            // Studi kasus: pakai tarif tetap kurir PT sendiri
            $tarifPerKg = 5000; // Rp 5000 per kg
            $biaya = ceil($weight / 1000) * $tarifPerKg;

            return [
                'status' => 200,
                'message' => 'Success (Internal Courier)',
                'data' => [
                    'courier' => 'internal',
                    'origin' => $origin,
                    'destination' => $destination,
                    'weight' => $weight,
                    'value' => $biaya,
                    'service' => 'PT Delivery',
                    'etd' => '2-3 hari',
                ]
            ];
        }

        // Default ke Binderbyte API
        $response = Http::get("{$this->baseUrl}/v1/ongkir", [
            'asal' => $origin,
            'tujuan' => $destination,
            'berat' => $weight,
            'kurir' => $courier,
            'api_key' => $this->apiKey
        ]);

        return $response->json();
    }
}
