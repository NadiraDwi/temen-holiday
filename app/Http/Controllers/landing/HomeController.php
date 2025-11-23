<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use App\Models\VehicleCategory;

class HomeController extends Controller
{
    public function index()
    {
        $categories = VehicleCategory::with(['vehicles' => function($q){
            $q->orderBy('created_at', 'asc');
        }])->get();
        return view('landing.home', compact('categories'));
    }
}
