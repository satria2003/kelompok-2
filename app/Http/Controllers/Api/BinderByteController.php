<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\BinderbyteService;

class BinderbyteController extends Controller
{
    protected BinderbyteService $binderbyte;

    public function __construct(BinderbyteService $binderbyte)
    {
        $this->binderbyte = $binderbyte;
    }

    public function getProvinces()
    {
        $response = $this->binderbyte->getProvinces();
        return response()->json($response, $response['status'] ?? 200);
    }

    public function getCities(Request $request)
    {
        $request->validate([
            'province_id' => 'required|string',
        ]);

        $response = $this->binderbyte->getCities($request->province_id);
        return response()->json($response, $response['status'] ?? 200);
    }

    public function checkOngkir(Request $request)
{
    $request->validate([
        'origin' => 'required|string',
        'destination' => 'required|string',
        'weight' => 'required|numeric|min:1',
        'courier' => 'required|string',
    ]);

    $response = $this->binderbyte->checkOngkir(
        $request->origin,
        $request->destination,
        $request->weight,
        $request->courier
    );

    return response()->json($response, $response['status'] ?? 200);
}
}