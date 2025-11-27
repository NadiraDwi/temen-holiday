<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use App\Models\OpenTrip;

class PaketController extends Controller
{
    public function index()
    {
        $trips = OpenTrip::with(['destinations', 'schedules'])->get(); // ambil semua open trip
        return view('landing.paket', compact('trips'));
    }

    public function detail($id)
    {
        $trip = OpenTrip::with(['destinations', 'schedules', 'itineraries.items', 'contacts'])
            ->findOrFail($id);

        // fasilitas = kolom include dipisah berdasarkan koma
        $fasilitas = array_filter(array_map('trim', explode(',', $trip->include ?? '')));

        return view('landing.paket-detail', compact('trip', 'fasilitas'));
    }

}
