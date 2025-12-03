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
        $request->validate([
            'nama_user'         => 'required|string|max:255',
            'pesan'             => 'required|string',
            'rating_fasilitas'  => 'required|integer|min:1|max:5',
            'rating_harga'      => 'required|integer|min:1|max:5',
            'images'            => 'nullable',
            'images.*'          => 'image|mimes:jpg,jpeg,png,webp|max:4096'
        ]);

        $manager = new ImageManager(new Driver());
        $imagePaths = [];

        // Jika ada file di-upload
        if ($request->hasFile('images')) {
            
            foreach ($request->file('images') as $img) {

                // Generate nama file WebP
                $fileName = Str::uuid() . '.webp';
                $path = 'testimoni/' . $fileName;

                // Convert ke WebP
                $image = $manager->read($img)->toWebp(75);

                // Simpan ke storage
                Storage::disk('public')->put($path, $image);

                // Simpan ke array
                $imagePaths[] = $path;
            }
        }

        // Simpan testimoni
        Testimonial::create([
            'nama_user'        => $request->nama_user,
            'pesan'            => $request->pesan,
            'rating_fasilitas' => $request->rating_fasilitas,
            'rating_harga'     => $request->rating_harga,
            'images'           => $imagePaths,
        ]);

        return redirect()->route('testimoni');
    }
}
