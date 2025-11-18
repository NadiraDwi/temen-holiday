<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;

class GaleriController extends Controller
{
    public function index()
    {
        $galeri = [
            [
                "path" => "assets/image/galeri1.jpg",
                "title" => "Pantai Kuta"
            ],
            [
                "path" => "assets/image/galeri2.jpg",
                "title" => "Gunung Bromo"
            ],
            [
                "path" => "assets/image/galeri3.jpg",
                "title" => "Labuan Bajo"
            ],
            [
                "path" => "assets/image/galeri4.jpg",
                "title" => "Candi Borobudur"
            ],
        ];

        return view('landing.galeri', compact('galeri'));
    }
}
