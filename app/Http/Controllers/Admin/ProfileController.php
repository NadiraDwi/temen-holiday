<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    // =======================
    // HALAMAN PROFIL
    // =======================
    public function index()
    {
        $user = Auth::user();
        return view('admin.profile.index', compact('user'));
    }

    // =======================
    // UPDATE PROFIL
    // =======================
    public function updateProfile(Request $request)
    {
        $user = Auth::guard('admin')->user();

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id . ',id',
        ]);

        $user->name  = $request->name;
        $user->email = $request->email;
        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui!');
    }

    // =======================
    // HALAMAN GANTI PASSWORD
    // =======================
    public function passwordPage()
    {
        return view('admin.profile.password');
    }

    // =======================
    // PROSES UPDATE PASSWORD
    // =======================
    public function updatePassword(Request $request)
    {
        // Validasi input
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6',
            'confirm_new_password' => 'required|same:new_password'
        ]);

        // Gunakan guard admin
        $user = auth()->guard('admin')->user();

        if (!$user) {
            return back()->with('error', 'User tidak ditemukan atau belum login.');
        }

        // Cek password lama
        if (!\Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Password lama tidak sesuai.');
        }

        // Update password
        $user->update([
            'password' => bcrypt($request->new_password)
        ]);

        return back()->with('success', 'Password berhasil diperbarui.');
    }
}
