<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kendaraan extends Model
{
    use HasFactory;

    protected $fillable = [
        'plat_nomor', 'jenis', 'merk', 'kurir_id',
    ];

    public function kurir()
    {
        return $this->belongsTo(Kurir::class);
    }
}
