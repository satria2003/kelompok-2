<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlamatAdmin extends Model
{
    protected $fillable = [
        'nama_pengirim',
        'no_telepon',
        'alamat_lengkap',
        'provinsi_id',
        'kodepos',
        'ongkir',
        'latitude',
        'longitude',
    ];

    public $timestamps = false; 
}
