<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function login()
    {
        return view('admin.login');
    }

    public function loginAction(Request $request)
    {
        // Validasi
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:4'
        ]);

        // Ambil input
        $credentials = $request->only('email', 'password');

        // Login pakai guard admin
        if (Auth::guard('admin')->attempt($credentials, true)) {
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors([
            'login' => 'Email atau password salah!'
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
