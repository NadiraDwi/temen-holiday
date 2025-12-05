<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use App\Models\VehicleCategory;
use App\Models\Gallery;
use App\Models\Testimonial;
use App\Models\OpenTrip;
use App\Models\Wisata;

class HomeController extends Controller
{
    public function index()
    {
        $categories = VehicleCategory::with(['vehicles' => function($q){
            $q->orderBy('created_at', 'desc');
        }])->latest()->take(3)->get();

        $galeri = Gallery::latest()->get();
        $testimoni = Testimonial::latest()->take(3)->get();

        $openTrip = OpenTrip::take(3)->get()->map(function ($item) {
            return (object)[
                'id'     => $item->id,
                'title'  => $item->title,
                'price'  => $item->price,
                'images' => $item->images,
                'type'   => 'opentrip',
            ];
        });

        $wisata = Wisata::take(3)->get()->map(function ($item) {
            return (object)[
                'id'     => $item->id,
                'title'  => $item->title,
                'price'  => $item->price,
                'images' => $item->images,
                'type'   => 'wisata',
            ];
        });

        $paket = $openTrip->merge($wisata);

        return view('landing.home', compact('categories', 'galeri', 'testimoni', 'paket'));
    }
}
