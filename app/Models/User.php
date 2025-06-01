<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'pengguna';
    protected $primaryKey = 'id_pengguna';
    public $timestamps = true; // gunakan created_at & updated_at

    protected $fillable = [
        'username',
        'email',
        'password',
        'no_telepon',
        'foto_profil',
        'peran',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'verifikasi_email' => 'boolean',
        'password' => 'hashed',
    ];

    public function getAuthIdentifierName()
    {
        return $this->getKeyName(); // Tetap gunakan id_pengguna
    }
}
