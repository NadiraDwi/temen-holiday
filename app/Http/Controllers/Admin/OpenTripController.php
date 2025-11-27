<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\OpenTrip;
use App\Models\OpenTripItinerary;
use App\Models\OpenTripItineraryItem;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class OpenTripController extends Controller
{
    public function index()
    {
        return view('admin.opentrip.index');
    }

    // JSON list untuk DataTables
    public function list(Request $request)
    {
        $data = OpenTrip::query();

        return DataTables::of($data)
            ->addIndexColumn()   // <–– wajib kalau ingin DT_RowIndex muncul di JSON
            ->make(true);
    }

    // Detail page
    public function detail($id)
    {
        $trip = OpenTrip::with(['contact', 'destinations', 'schedules'])->findOrFail($id);

        return view('admin.opentrip.detail', compact('trip'));
    }

    // PAGE CREATE
    public function create()
    {
        $contacts = Contact::all();
        return view('admin.opentrip.create', compact('contacts'));
    }

    // STORE DATA
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'nullable',
            'price' => 'required|integer',
            'include' => 'nullable',
            'meeting_point' => 'nullable',
            'cover_image' => 'nullable|mimes:jpg,jpeg,png',
        ]);

        // upload file
        $filename = null;
        if ($request->hasFile('cover_image')) {
            $filename = time().'_'.$request->cover_image->getClientOriginalName();
            $request->cover_image->storeAs('opentrip', $filename, 'public');
        }

        OpenTrip::create([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'price_label' => $request->price_label,
            'meeting_point' => $request->meeting_point,
            'include' => $request->include,
            'cover_image' => $filename,
        ]);

        return redirect()->route('trip.index')->with('success', 'Open Trip berhasil ditambahkan');
    }

    public function storeItinerary(Request $request)
    {
        $request->validate([
            'open_trip_id' => 'required',
            'day_title' => 'required'
        ]);

        OpenTripItinerary::create([
            'open_trip_id' => $request->open_trip_id,
            'day_title' => $request->day_title
        ]);

        return back()->with('success', 'Hari itinerary berhasil ditambahkan');
    }

    public function storeItineraryItem(Request $request)
    {
        $request->validate([
            'itinerary_id' => 'required',
            'activity' => 'required',
        ]);

        OpenTripItineraryItem::create([
            'itinerary_id' => $request->itinerary_id,
            'time' => $request->time,
            'activity' => $request->activity
        ]);

        return back()->with('success', 'Aktivitas berhasil ditambahkan');
    }

    public function deleteItinerary($id)
    {
        OpenTripItinerary::findOrFail($id)->delete();
        return back();
    }

    public function deleteItineraryItem($id)
    {
        OpenTripItineraryItem::findOrFail($id)->delete();
        return back();
    }

    public function edit($id)
    {
        $trip = OpenTrip::findOrFail($id);
        $contacts = Contact::all();
        return view('admin.opentrip.edit', compact('trip', 'contacts'));
    }

    public function update(Request $request, $id)
    {
        $trip = OpenTrip::findOrFail($id);

        $request->validate([
            'title'          => 'required|string|max:255',
            'description'    => 'nullable|string',
            'price'          => 'required|numeric',
            'price_label'    => 'nullable|string|max:255',
            'meeting_point'  => 'nullable|string|max:255',
            'include'        => 'nullable|string',
            'cover_image'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        // UPLOAD GAMBAR
        if ($request->hasFile('cover_image')) {

            // hapus gambar lama kalau ada
            if ($trip->cover_image && file_exists(storage_path('app/public/opentrip/' . $trip->cover_image))) {
                unlink(storage_path('app/public/opentrip/' . $trip->cover_image));
            }

            $file = $request->file('cover_image');
            $fileName = time() . '_' . $file->getClientOriginalName();

            // simpan ke storage/public/opentrip seperti CREATE
            $file->storeAs('opentrip', $fileName, 'public');

            $trip->cover_image = $fileName;
        }

        // UPDATE DATA
        $trip->title         = $request->title;
        $trip->description   = $request->description;
        $trip->price         = $request->price;
        $trip->price_label   = $request->price_label;
        $trip->meeting_point = $request->meeting_point;
        $trip->include       = $request->include;
        $trip->id_contact    = $request->id_contact;

        $trip->save();

        return redirect()->route('trip.detail', $trip->id)
            ->with('success', 'Trip berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $trip = OpenTrip::findOrFail($id);

        // hapus destinasi / jadwal jika terkait
        $trip->destinations()->delete();
        $trip->schedules()->delete();
        $trip->itineraries()->delete();

        $trip->delete();

        return redirect()->route('trip.index')
            ->with('success', 'Trip berhasil dihapus.');
    }

}
