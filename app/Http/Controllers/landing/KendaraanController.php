<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use App\Models\VehicleCategory;

class KendaraanController extends Controller
{
    public function index()
    {
        $categories = VehicleCategory::all();
        $vehicles = Vehicle::with('kategori')->get();

        return view('landing.kendaraan', compact('categories', 'vehicles'));
    }
}
