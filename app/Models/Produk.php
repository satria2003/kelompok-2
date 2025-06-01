<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produk';
    protected $primaryKey = 'id_produk';
    public $timestamps = false;

    const CREATED_AT = 'tanggal_dibuat';

    protected $fillable = [
        'nama_produk',
        'deskripsi',
        'harga',
        'stok',
        'berat',
        'id_kategori',
        'foto_produk',
        'diskon',
        'tanggal_dibuat',
    ];

    /**
     * Relasi ke tabel kategori
     */
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }

    /**
     * Relasi ke detail pesanan
     */
    public function detailPesanan()
    {
        return $this->hasMany(DetailPesanan::class, 'id_produk');
    }

    /**
     * Relasi ke ulasan
     */
    public function ulasan()
    {
        return $this->hasMany(Ulasan::class, 'id_produk');
    }

    /**
     * Accessor untuk format harga dalam Rupiah
     */
    public function getFormattedHargaAttribute()
    {
        return 'Rp ' . number_format($this->harga, 0, ',', '.');
    }

    /**
     * Scope untuk produk yang stoknya tersedia
     */
    public function scopeTersedia($query)
    {
        return $query->where('stok', '>', 0);
    }
}
