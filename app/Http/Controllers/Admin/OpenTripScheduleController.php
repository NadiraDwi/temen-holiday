<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\OpenTrip;
use App\Models\OpenTripSchedule;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class OpenTripScheduleController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'open_trip_id' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        OpenTripSchedule::create($request->all());

        return back()->with('success', 'Jadwal ditambahkan');
    }

    public function delete($id)
    {
        OpenTripSchedule::findOrFail($id)->delete();
        return back()->with('success', 'Jadwal dihapus');
    }
}
