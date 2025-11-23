<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use App\Models\Gallery;

class GaleriController extends Controller
{
    public function index()
    {
        $galeri = Gallery::latest()->get();

        return view('landing.galeri', compact('galeri'));
    }
}
