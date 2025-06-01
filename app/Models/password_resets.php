<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    use HasFactory;
    
    protected $table = 'password_resets';
    protected $primaryKey = 'id_reset_password';
    public $timestamps = false;

    const CREATED_AT = 'created_at';

    protected $fillable = [
        'email', 
        'token', 
        'expires_at', 
        'created_at'
    ];
}
