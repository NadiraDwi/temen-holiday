<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use App\Models\VehicleCategory;
use App\Models\Gallery;
use App\Models\Testimonial;

class HomeController extends Controller
{
    public function index()
    {
        $categories = VehicleCategory::with(['vehicles' => function($q){
            $q->orderBy('created_at', 'desc');
        }])->latest()->take(3)->get();

        $galeri = Gallery::latest()->get();
        $testimoni = Testimonial::latest()->take(3)->get();

        return view('landing.home', compact('categories', 'galeri', 'testimoni'));
    }
}
