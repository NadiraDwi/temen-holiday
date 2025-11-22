<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GaleriController extends Controller
{
    public function index()
    {
        return view('admin.galeri.list');
    }

    // ✅ LIST (JSON UNTUK CARD)
    public function list()
    {
        $galeri = Gallery::latest()->get();

        return response()->json([
            'success' => true,
            'data' => $galeri
        ]);
    }

    // ✅ STORE (AJAX + RETURN JSON)
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'gambar' => 'required|image|max:2048'
        ]);

        $fileName = time().'.'.$request->gambar->extension();
        $request->gambar->storeAs('galeri', $fileName, 'public');

        $galeri = Gallery::create([
            'judul' => $request->judul,
            'gambar' => $fileName,
            'created_by' => auth()->id(),
        ]);

        return response()->json([
            'success' => true,
            'data' => $galeri
        ]);
    }

    // ✅ EDIT (RETURN JSON SESUAI AJAX)
    public function edit($id)
    {
        $galeri = Gallery::where('id_galeri', $id)->firstOrFail();

        return response()->json([
            'success' => true,
            'data' => $galeri
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required',
            'gambar' => 'nullable|image|max:2048'
        ]);

        $gallery = Gallery::findOrFail($id);
        $fileName = $gallery->gambar;

        if ($request->hasFile('gambar')) {
            if (Storage::disk('public')->exists('galeri/'.$fileName)) {
                Storage::disk('public')->delete('galeri/'.$fileName);
            }

            $fileName = time().'.'.$request->gambar->extension();
            $request->gambar->storeAs('galeri', $fileName, 'public');
        }

        $gallery->update([
            'judul' => $request->judul,
            'gambar' => $fileName
        ]);

        return response()->json([
            'success' => true,
            'data' => $gallery
        ]);
    }

    // ✅ DELETE (AJAX)
    public function delete(Request $request)
    {
        $galeri = Gallery::where('id_galeri', $request->id)->firstOrFail();

        if (Storage::disk('public')->exists('galeri/'.$galeri->gambar)) {
            Storage::disk('public')->delete('galeri/'.$galeri->gambar);
        }

        $galeri->delete();

        return response()->json([
            'success' => true
        ]);
    }
}
