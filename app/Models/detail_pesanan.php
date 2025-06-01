<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class detail_Pesanan extends Model
{
    use HasFactory;
    
    protected $table = 'detail_pesanan';
    protected $primaryKey = 'id_detail_pesanan';
    public $timestamps = false;
    
    protected $fillable = [
        'id_pesanan', 
        'id_produk', 
        'jumlah', 
        'harga_satuan'
    ];

    // Relasi ke Pesanan
    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'id_pesanan');
    }

    // Relasi ke Produk
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk');
    }
}
