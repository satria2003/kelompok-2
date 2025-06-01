<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class Kurir extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'nama',
        'email',
        'no_telepon',
        'foto_profil',
        'email_verified_at',
        'email_verifikasi_token',
        'token_login', // Token untuk login satu kali
    ];

    protected $hidden = [
        'remember_token',
        'email_verifikasi_token',
        'token_login',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
