<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimoniController extends Controller
{
    public function index()
    {
        $testimoni = Testimonial::latest()->get();
        return view('landing.testimoni', compact('testimoni'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_user' => 'required|string|max:255',
            'pesan'     => 'required|string',
            'rating'    => 'required|integer|min:1|max:5',
        ]);

        Testimonial::create([
            'nama_user' => $request->nama_user,
            'pesan'     => $request->pesan,
            'rating'    => $request->rating,
        ]);

        return back()->with('success', 'Terima kasih! Ulasanmu telah dikirim.');
    }

}
