<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        $admins = Admin::all();
        return view('admin.admins.index', compact('admins'));
    }

    public function store(Request $request)
    {
        // Untuk membuka modal jika gagal
        $request->merge(['form' => 'add']);

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email', // ✔ VALIDASI KE TABEL users
            'password' => 'required|min:6',
            'role'     => 'required|in:admin,super_admin',
        ]);

        Admin::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        return back()->with('success', 'Admin berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $admin = Admin::findOrFail($id);

        // Untuk reopen modal edit jika validasi gagal
        $request->merge(['id' => $id]);

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id, // ✔ validasi sesuai table users
            'role'  => 'required|in:admin,super_admin',
        ]);

        // Tidak boleh menurunkan super admin
        if ($admin->role === 'super_admin' && $request->role !== 'super_admin') {
            return back()->with('edit_error', 'Role super admin tidak boleh diturunkan!');
        }

        $admin->name  = $request->name;
        $admin->email = $request->email;
        $admin->role  = $request->role;

        if ($request->password) {
            $admin->password = Hash::make($request->password);
        }

        $admin->save();

        return back()->with('success', 'Admin berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $admin = Admin::findOrFail($id);

        if ($admin->role === 'super_admin') {
            return back()->with('error', 'Super admin tidak boleh dihapus.');
        }

        $admin->delete();

        return back()->with('success', 'Admin berhasil dihapus.');
    }
}
