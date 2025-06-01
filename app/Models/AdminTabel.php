<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class AdminTabel extends Authenticatable
{
    use Notifiable;

    protected $table = 'admin_tabel';
    protected $primaryKey = 'id_admin';
    public $timestamps = false;

    protected $fillable = ['nama_admin', 'email', 'password'];
    protected $hidden = ['password', 'remember_token'];

    public function getAuthIdentifierName()
    {
        return 'email'; // pastikan cocok dengan kolom di tabel
    }
}
