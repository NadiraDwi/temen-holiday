<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\OpenTrip;
use App\Models\OpenTripDestination;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class OpenTripDestinationController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'open_trip_id' => 'required',
            'name' => 'required',
        ]);

        OpenTripDestination::create([
            'open_trip_id' => $request->open_trip_id,
            'name' => $request->name,
            'category' => $request->category,
        ]);

        return back()->with('success', 'Destinasi ditambahkan');
    }

    public function delete($id)
    {
        OpenTripDestination::findOrFail($id)->delete();
        return back()->with('success', 'Destinasi dihapus');
    }
}
