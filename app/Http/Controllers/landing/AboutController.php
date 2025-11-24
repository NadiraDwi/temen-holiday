<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;

class AboutController extends Controller
{
    public function index()
    {
        return view('landing.about');
    }
}
