<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\AdminTabel;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.admin-login'); // pastikan view ini tersedia
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $admin = AdminTabel::where('email', $credentials['email'])->first();

        if (!$admin) {
            return back()->withErrors(['email' => 'Email tidak ditemukan.']);
        }

        if (!Hash::check($credentials['password'], $admin->password)) {
            return back()->withErrors(['password' => 'Password salah.']);
        }

        Auth::guard('admin')->login($admin);

        return redirect()->route('admin.dashboard');
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}
