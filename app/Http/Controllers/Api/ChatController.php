<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Message;
use App\Models\AdminTabel;

class ChatController extends Controller
{
    // Ambil semua pesan untuk pengguna (berdasarkan ID pengguna)
    public function index($id_pengguna)
    {
        $messages = Message::where('id_pengguna', $id_pengguna)
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json($messages);
    }

    // Kirim pesan teks dari pengguna ke admin (id tetap = 4)
    public function store(Request $request)
    {
        $request->validate([
            'id_pengguna' => 'required|integer',
            'message' => 'required|string',
        ]);

        $message = Message::create([
            'id_pengguna'      => $request->id_pengguna,
            'sender_type'      => 'pengguna',
            'sender_name'      => 'Pengguna',
            'message'          => $request->message,
            'incoming_msg_id'  => 4, // Admin ID tetap
            'outgoing_msg_id'  => $request->id_pengguna,
            'created_at'       => now(),
            'unread'           => true,
            'status'           => 'unread',
        ]);

        return response()->json($message, 201);
    }

    // Upload gambar dari pengguna ke admin
    public function uploadImage(Request $request)
{
    $request->validate([
        'id_pengguna' => 'required|integer',
        'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    $filename = time() . '_' . $request->file('image')->getClientOriginalName();
    $request->file('image')->move(public_path('chat_images'), $filename);

    $message = Message::create([
        'id_pengguna'      => $request->id_pengguna,
        'sender_type'      => 'pengguna',
        'sender_name'      => 'Pengguna',
        'message'          => 'chat_images/' . $filename,
        'incoming_msg_id'  => 4,
        'outgoing_msg_id'  => $request->id_pengguna,
        'created_at'       => now(),
        'unread'           => true,
        'status'           => 'unread',
    ]);

    return response()->json(['message' => $message], 201);
}


    // Upload file dari pengguna ke admin
    public function uploadFile(Request $request)
    {
        $request->validate([
            'id_pengguna' => 'required|integer',
            'file' => 'required|file|max:5120',
        ]);

        $path = $request->file('file')->store('chat_files', 'public');

        $message = Message::create([
            'id_pengguna'      => $request->id_pengguna,
            'sender_type'      => 'pengguna',
            'sender_name'      => 'Pengguna',
            'message'          => $path,
            'incoming_msg_id'  => 4,
            'outgoing_msg_id'  => $request->id_pengguna,
            'created_at'       => now(),
            'unread'           => true,
            'status'           => 'unread',
        ]);

        return response()->json(['message' => $message], 201);
    }

    // Admin membalas pesan ke pengguna (outgoing dari id 4)
    public function adminReply(Request $request)
    {
        $request->validate([
            'id_pengguna' => 'required|integer',
            'message'     => 'required|string',
        ]);

        $admin = AdminTabel::find(4); // ID admin tetap 4

        if (!$admin) {
            return response()->json(['error' => 'Admin dengan ID 4 tidak ditemukan.'], 404);
        }

        $message = Message::create([
            'id_pengguna'      => $request->id_pengguna,
            'sender_type'      => 'admin',
            'sender_name'      => $admin->nama_admin,
            'message'          => $request->message,
            'incoming_msg_id'  => $request->id_pengguna,
            'outgoing_msg_id'  => 4,
            'created_at'       => now(),
            'unread'           => true,
            'status'           => 'unread',
        ]);

        return response()->json($message, 201);
    }
}
