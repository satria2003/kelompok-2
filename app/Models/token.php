<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    use HasFactory;
    
    protected $table = 'token';
    protected $primaryKey = 'id_token';
    public $timestamps = false;

    protected $fillable = [
        'email', 
        'token', 
        'status', 
        'tanggal_kadaluarsa'
    ];
}
