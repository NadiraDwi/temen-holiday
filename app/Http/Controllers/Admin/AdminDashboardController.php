<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use App\Models\Wisata;
use App\Models\OpenTrip;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Hitung kendaraan per kategori dengan join (lebih cepat)
        $vehiclesByCategory = Vehicle::leftJoin('vehicle_categories', 'vehicles.id_kategori', '=', 'vehicle_categories.id_category')
            ->select(
                DB::raw("COALESCE(vehicle_categories.kategori, 'Tanpa Kategori') AS kategori"),
                DB::raw("COUNT(vehicles.id_vehicle) AS total")
            )
            ->groupBy('kategori')
            ->pluck('total', 'kategori');

        return view('admin.dashboard', [
            'totalVehicles'      => Vehicle::count(),
            'totalWisata'        => Wisata::count(),
            'totalOpenTrip'      => OpenTrip::count(),
            'vehiclesByCategory' => $vehiclesByCategory,
        ]);
    }
}
