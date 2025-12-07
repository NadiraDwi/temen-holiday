<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use App\Models\OpenTrip;
use App\Models\Wisata;
use App\Helpers\FormatHelper;

class PaketController extends Controller
{
    public function index()
    {
        // OpenTrip 3 item
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

        return view('landing.paket', compact('paket'));
    }

    // ==========================
    // DETAIL OPEN TRIP
    // ==========================
    public function detailOpenTrip($id)
    {
        $trip = OpenTrip::with([
                'contact',
                'destinations',
                'schedules',
                'itineraries.items'
            ])
            ->findOrFail($id);

        $fasilitas = array_filter(
            array_map('trim', explode(',', $trip->include ?? ''))
        );

        // nomor WA diformat
        $wa_number = FormatHelper::normalizePhone($trip->contact->no_hp ?? '');

        return view('landing.paket-detail', [
            'trip'        => $trip,
            'fasilitas'   => $fasilitas,
            'nomorAdmin'  => $wa_number,
        ]);
    }

    // ==========================
    // DETAIL WISATA
    // ==========================
    public function detailWisata($id)
    {
        $wisata = Wisata::with(['contact'])->findOrFail($id);

        $wa_number = FormatHelper::normalizePhone($wisata->contact->no_hp ?? '');

        return view('landing.wisata-detail', [
            'wisata'      => $wisata,
            'nomorAdmin'  => $wa_number,
        ]);
    }
}
