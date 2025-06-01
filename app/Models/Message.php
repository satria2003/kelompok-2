<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $table = 'messages';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'id_pengguna',
        'sender_type',
        'sender_name',
        'message',
        'created_at',
        'incoming_msg_id',
        'outgoing_msg_id',
        'unread',
        'status',
    ];

    protected $casts = [
        'unread' => 'boolean',
        'created_at' => 'datetime',
    ];

    // Relasi opsional ke model Pengguna jika kamu punya model pengguna
    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna');
    }
}
