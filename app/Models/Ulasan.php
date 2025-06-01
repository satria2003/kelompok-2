<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ulasan extends Model
{
    use HasFactory;

    protected $table = 'ulasan';
    protected $primaryKey = 'id_ulasan';
    public $timestamps = false;

    protected $fillable = [
        'id_pengguna', 
        'id_produk', 
        'rating', 
        'komentar', 
        'tanggal_dibuat', 
        'foto_ulasan'
    ];

    // Relasi ke Pengguna
    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna', 'id_pengguna');
    }

    // Relasi ke Produk
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk');
    }

    // ✅ Accessor URL lengkap foto ulasan
    public function getFotoUlasanUrlAttribute()
{
    return $this->foto_ulasan ? asset($this->foto_ulasan) : null;
}

}
