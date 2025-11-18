<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;

class PaketController extends Controller
{
    public function index()
    {
        return view('landing.paket');
    }
}
