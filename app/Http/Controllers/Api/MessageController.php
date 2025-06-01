<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    // Ambil semua pesan berdasarkan id pengguna
    public function getMessages($id_pengguna)
    {
        $messages = Message::where('id_pengguna', $id_pengguna)
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json($messages);
    }

    // Simpan pesan baru (chat)
    public function sendMessage(Request $request)
    {
        $request->validate([
            'id_pengguna'  => 'required|integer',
            'sender_type'  => 'required|in:admin,pengguna',
            'sender_name'  => 'nullable|string',
            'message'      => 'required|string',
        ]);

        $fixedAdminId = 4; // ID Admin tetap (tujuan semua pesan pengguna)

        // Atur incoming dan outgoing tergantung siapa pengirim
        if ($request->sender_type === 'admin') {
            $incoming = $request->id_pengguna;
            $outgoing = $fixedAdminId;
        } else {
            $incoming = $fixedAdminId;
            $outgoing = $request->id_pengguna;
        }

        $message = Message::create([
            'id_pengguna'      => $request->id_pengguna,
            'sender_type'      => $request->sender_type,
            'sender_name'      => $request->sender_name ?? '',
            'message'          => $request->message,
            'incoming_msg_id'  => $incoming,
            'outgoing_msg_id'  => $outgoing,
            'unread'           => 1,
            'status'           => 'unread',
            'created_at'       => now(),
        ]);

        return response()->json([
            'message' => 'Pesan berhasil dikirim',
            'data' => $message
        ]);
    }
}
