<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class TestimoniController extends Controller
{
    public function index()
    {
        $testimoni = Testimonial::latest()->get();
        return view('landing.testimoni', compact('testimoni'));
    }

    public function create()
    {
        return view('landing.testimoni-create');
    }

    public function store(Request $request)
{
    // VALIDASI
    $request->validate([
        'nama_user'         => 'required|string|max:255',
        'pesan'             => 'required|string|min:5',
        'rating_fasilitas'  => 'required|integer|min:1|max:5',
        'rating_harga'      => 'required|integer|min:1|max:5',
        'images'            => 'nullable',
        'images.*'          => 'image|mimes:jpg,jpeg,png,webp|max:4096'
    ]);

    $imageManager = new ImageManager(new Driver());
    $imagePaths = [];

    // HANDLE GAMBAR MULTIPLE
    if ($request->hasFile('images')) {

        foreach ($request->file('images') as $img) {

            $fileName = Str::uuid() . '.webp';
            $path = 'testimoni/' . $fileName;

            // convert ke webp (quality 75)
            $webp = $imageManager->read($img)->toWebp(75);

            Storage::disk('public')->put($path, $webp);

            $imagePaths[] = $path;
        }
    }

    // SIMPAN DATA
    Testimonial::create([
        'nama_user'         => $request->nama_user,
        'pesan'             => $request->pesan,
        'rating_fasilitas'  => $request->rating_fasilitas,
        'rating_harga'      => $request->rating_harga,
        'images'            => $imagePaths, // langsung array
    ]);

    return redirect()
        ->route('testimoni')
        ->with('success', 'Terima kasih! Testimoni kamu berhasil dikirim.');
}

}
