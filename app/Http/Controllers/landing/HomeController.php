<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use App\Models\VehicleCategory;
use App\Models\Gallery;
use App\Models\Testimonial;
use App\Models\OpenTrip;
use Illuminate\Http\Request;
use App\Models\Vehicle;
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

        // CEK KONDISI
        if ($openTrip->isNotEmpty() && $wisata->isNotEmpty()) {
            // KEDUANYA ADA
            $paket = $openTrip->merge($wisata);

        } elseif ($openTrip->isNotEmpty() && $wisata->isEmpty()) {
            // HANYA OPENTRIP YANG ADA
            $paket = $openTrip;

        } elseif ($openTrip->isEmpty() && $wisata->isNotEmpty()) {
            // HANYA WISATA YANG ADA
            $paket = $wisata;

        } else {
            // KEDUANYA KOSONG
            $paket = collect([]);
        }


        return view('landing.home', compact('categories', 'galeri', 'testimoni', 'paket'));
    }

    public function search(Request $request)
    {
        $q = $request->q;

        // 🔍 Cari Open Trip
        $openTrip = OpenTrip::where('title', 'like', "%$q%")
            ->get()
            ->map(function ($item) {
                return (object)[
                    'id'     => $item->id,
                    'title'  => $item->title,
                    'price'  => $item->price,
                    'images' => $item->images,
                    'type'   => 'opentrip',
                    'url'    => route('opentrip.detail', $item->id),
                ];
            });

        // 🔍 Cari Wisata
        $wisata = Wisata::where('title', 'like', "%$q%")
            ->get()
            ->map(function ($item) {
                return (object)[
                    'id'     => $item->id,
                    'title'  => $item->title,
                    'price'  => $item->price,
                    'images' => $item->images,
                    'type'   => 'wisata',
                    'url'    => route('wisata.user.detail', $item->id),
                ];
            });

        // 🔍 Cari Kendaraan
        $kendaraan = Vehicle::where('nama_kendaraan', 'like', "%$q%")
            ->get()
            ->map(function ($item) {
                return (object)[
                    'id'     => $item->id_vehicle,
                    'title'  => $item->nama_kendaraan,
                    'price'  => $item->harga,
                    'images' => $item->images,
                    'type'   => 'kendaraan',
                    'url'    => route('pesan.kendaraan', $item->id_vehicle),
                ];
            });

        // 🔗 Gabungkan semua hasil (tanpa error getKey)
        $results = collect()
            ->concat($openTrip)
            ->concat($wisata)
            ->concat($kendaraan)
            ->values();

        return view('landing.search-result', compact('q', 'results'));
    }
}
