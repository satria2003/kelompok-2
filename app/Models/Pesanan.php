<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    protected $table = 'pesanan';
    protected $primaryKey = 'id_pesanan';
    public $timestamps = false;

    // Ini penting agar Laravel tahu 'tanggal_dibuat' adalah created_at custom
    const CREATED_AT = 'tanggal_dibuat';

    protected $fillable = [
        'id_pengguna',
        'order_id',
        'total_harga',
        'metode_pembayaran',
        'status',
        'tanggal_dibuat',
        'alamat_pengiriman',
        'alamat_pengguna_id',
    ];

    public function detail()
    {
        return $this->hasMany(DetailPesanan::class, 'id_pesanan');
    }

    public function pengguna()
    {
        return $this->belongsTo(User::class, 'id_pengguna');
    }

    public function alamat()
    {
        return $this->belongsTo(\App\Models\AlamatPengguna::class, 'alamat_pengguna_id');
    }
}
