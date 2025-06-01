<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlamatPengguna extends Model
{
    use HasFactory;

    protected $table = 'alamat_pengguna';

    protected $fillable = [
        'pengguna_id',
        'nama_penerima',
        'no_telepon',
        'alamat_lengkap',
        'provinsi_id',
        'nama_provinsi', 
        'kodepos',
        'is_default',
        'latitude',      // ✅ tambahkan ini
        'longitude',     // ✅ tambahkan ini
    ];

    public function pengguna()
    {
        return $this->belongsTo(User::class, 'pengguna_id');
    }
}
