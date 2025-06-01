<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    use HasFactory;

    protected $table = 'keranjang';
    protected $primaryKey = 'id_keranjang';
    public $timestamps = false;

    protected $fillable = [
        'id_pengguna',
        'id_produk',
        'jumlah',
        'tanggal_dibuat',
    ];

    // Tambahkan casts untuk keamanan tipe data
    protected $casts = [
        'id_pengguna' => 'integer',
        'id_produk' => 'integer',
        'jumlah' => 'integer',
        'tanggal_dibuat' => 'datetime',
    ];

    // Relasi ke pengguna (jika pakai model User dari Laravel)
    public function pengguna()
    {
        return $this->belongsTo(User::class, 'id_pengguna');
    }

    // Relasi ke produk
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk');
    }
}
