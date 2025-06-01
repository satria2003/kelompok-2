<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Pengguna extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'pengguna';
    protected $primaryKey = 'id_pengguna';
    public $timestamps = false; // ✅ aktifkan timestamps jika pakai created_at & updated_at

    protected $fillable = [
        'username',
        'email',
        'password',
        'no_telepon',
        'foto_profil',
        'peran',
        'verifikasi_token',
        'verifikasi_email',
    ];
    

    protected $hidden = [
        'password',
        'verifikasi_token',
    ];

    protected $casts = [
        'verifikasi_email' => 'boolean',
    ];

    public function messages()
{
    return $this->hasMany(Message::class, 'id_pengguna');
}

// Accessor untuk mendapatkan URL lengkap foto profil
public function getFotoProfilUrlAttribute()
{
    return $this->foto_profil
        ? asset($this->foto_profil) // tanpa "storage/"
        : null;
}


// Accessor agar Flutter bisa pakai pengguna.noTelepon
public function getNoTeleponAttribute()
{
    return $this->attributes['no_telepon'] ?? '';
}


}
