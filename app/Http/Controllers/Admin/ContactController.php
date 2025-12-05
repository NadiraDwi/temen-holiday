<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    // Tampilkan daftar kontak
    public function index()
    {
        $contacts = Contact::orderBy('nama')->get();
        return view('admin.kontak.index', compact('contacts'));
    }

    // Store data kontak baru
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'no_hp' => 'required|string|max:20',
        ]);

        Contact::create([
            'nama' => $request->nama,
            'no_hp' => $request->no_hp,
        ]);

        return back()->with('success', 'Kontak berhasil ditambahkan.');
    }

    // Update data kontak
    public function update(Request $request, $id_contact)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'no_hp' => 'required|string|max:20',
        ]);

        $contact = Contact::findOrFail($id_contact);
        $contact->update([
            'nama' => $request->nama,
            'no_hp' => $request->no_hp,
        ]);

        return back()->with('success', 'Kontak berhasil diupdate.');
    }

    // Delete kontak
    public function destroy($id_contact)
    {
        Contact::destroy($id_contact);
        return back()->with('success', 'Kontak berhasil dihapus.');
    }
}
