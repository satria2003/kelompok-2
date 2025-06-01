<?php

namespace App\Services;

use Midtrans\Config;

class MidtransConfig
{
    public static function init()
    {
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = false; // Sandbox mode
        Config::$isSanitized = true;
        Config::$is3ds = true;

        // Hanya aktifkan ini di lokal
        Config::$curlOptions[CURLOPT_SSL_VERIFYPEER] = false;
    }
}