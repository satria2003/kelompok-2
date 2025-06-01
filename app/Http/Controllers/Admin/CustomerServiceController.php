<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CustomerServiceController extends Controller
{
    public function index($id_pengguna = null)
    {
        $adminId = 4;

        $pengguna_ids = Message::where(function ($q) use ($adminId) {
            $q->where('incoming_msg_id', $adminId)
              ->orWhere('outgoing_msg_id', $adminId);
        })->select('id_pengguna')->distinct()->pluck('id_pengguna');

        $pengguna = Pengguna::whereIn('id_pengguna', $pengguna_ids)->get();

        $selected_pengguna = null;
        $messages = collect();

        if ($id_pengguna) {
            $selected_pengguna = Pengguna::find($id_pengguna);

            $messages = Message::where('id_pengguna', $id_pengguna)
                ->where(function ($q) use ($adminId) {
                    $q->where('incoming_msg_id', $adminId)
                      ->orWhere('outgoing_msg_id', $adminId);
                })
                ->orderBy('id', 'asc')
                ->get();
        }

        return view('admin.cs.index', compact('pengguna', 'selected_pengguna', 'messages'));
    }

   public function sendMessage(Request $request)
{
    $request->validate([
        'id_pengguna' => 'required|exists:pengguna,id_pengguna',
    ]);

    $adminId = 4;
    $messageText = $request->input('message');

    // Cek kalau ada file
    if ($request->hasFile('upload')) {
        $file = $request->file('upload');
        $extension = $file->getClientOriginalExtension();
        $folder = in_array($extension, ['jpg','jpeg','png','gif']) ? 'chat_images' : 'chat_files';

        $filename = time() . '_' . uniqid() . '.' . $extension;
        $file->move(public_path($folder), $filename);

        $filePath = $folder . '/' . $filename;

        // Simpan pesan berupa file
        Message::create([
            'id_pengguna'     => $request->id_pengguna,
            'sender_type'     => 'admin',
            'sender_name'     => 'Admin',
            'message'         => $filePath,
            'incoming_msg_id' => $request->id_pengguna,
            'outgoing_msg_id' => $adminId,
            'unread'          => true,
            'status'          => 'sent',
            'created_at'      => now(),
        ]);
    }

    // Simpan pesan teks jika ada
    if ($messageText) {
        Message::create([
            'id_pengguna'     => $request->id_pengguna,
            'sender_type'     => 'admin',
            'sender_name'     => 'Admin',
            'message'         => $messageText,
            'incoming_msg_id' => $request->id_pengguna,
            'outgoing_msg_id' => $adminId,
            'unread'          => true,
            'status'          => 'sent',
            'created_at'      => now(),
        ]);
    }

    return redirect()
        ->route('admin.cs.index', $request->id_pengguna)
        ->with('success', 'Pesan berhasil dikirim.');
}



    public function deleteMessage(Request $request)
    {
        $message = Message::findOrFail($request->id);

        if ($message->sender_type !== 'admin') {
            return response()->json(['error' => 'Tidak dapat menghapus pesan ini.'], 403);
        }

        // Hapus file kalau isi pesan adalah file path
        if (Str::startsWith($message->message, 'chat_images/') || Str::startsWith($message->message, 'chat_files/')) {
            Storage::disk('public')->delete($message->message);
        }

        $message->delete();

        return response()->json(['success' => true]);
    }
}
