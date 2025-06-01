<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        $totalUser = $users->count();

        return view('admin.user.index', compact('users', 'totalUser'));
    }

    public function destroy($id_pengguna)
    {
        // Menemukan user berdasarkan id_pengguna
        $user = User::findOrFail($id_pengguna);
        
        // Menghapus user
        $user->delete();
    
        // Redirect kembali dengan pesan sukses
        return redirect()->route('admin.user.index')->with('success', 'User berhasil dihapus');
    }

}
