<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;
    
    protected $table = 'kategori';
    protected $primaryKey = 'id_kategori';
    public $timestamps = false;
    
    const CREATED_AT = 'tanggal_dibuat';
    
    protected $fillable = [
        'nama_kategori', 
        'deskripsi', 
        'tanggal_dibuat'
    ];

    // Relasi ke produk
    public function produk()
    {
        return $this->hasMany(Produk::class, 'id_kategori');
    }
}
