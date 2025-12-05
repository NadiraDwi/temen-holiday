<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\OpenTrip;
use App\Models\OpenTripItinerary;
use App\Models\OpenTripItineraryItem;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class OpenTripController extends Controller
{
    public function index()
    {
        return view('admin.opentrip.index');
    }

    public function list(Request $request)
    {
        $data = OpenTrip::query();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function detail($id)
    {
        $trip = OpenTrip::with(['contact', 'destinations', 'schedules'])->findOrFail($id);

        return view('admin.opentrip.detail', compact('trip'));
    }

    public function create()
    {
        $contacts = Contact::orderBy('nama')->get();
        return view('admin.opentrip.create', compact('contacts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'          => 'required',
            'description'    => 'nullable',
            'price'          => 'required|numeric',
            'include'        => 'nullable',
            'meeting_point'  => 'nullable',
            'price_label'    => 'nullable',
            'images.*'       => 'nullable|image|max:4096',
            'id_contact'     => 'nullable|uuid',
        ]);

        $manager = new ImageManager(new Driver());
        $paths = [];

        // ---------- SIMPAN WEBP ----------
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {

                $name = Str::uuid() . '.webp';
                $path = "opentrip/$name";

                $img = $manager->read($file)->toWebp(80);
                Storage::disk('public')->put($path, $img);

                $paths[] = $path;
            }
        }

        OpenTrip::create([
            'title'         => $request->title,
            'description'   => $request->description,
            'price'         => $request->price,
            'price_label'   => $request->price_label,
            'meeting_point' => $request->meeting_point,
            'include'       => $request->include,
            'id_contact'    => $request->id_contact,
            'images'        => $paths,
        ]);

        return redirect()->route('trip.index')
            ->with('success', 'Open Trip berhasil ditambahkan');
    }

    public function storeItinerary(Request $request)
    {
        $request->validate([
            'open_trip_id' => 'required',
            'day_title' => 'required'
        ]);

        OpenTripItinerary::create([
            'open_trip_id' => $request->open_trip_id,
            'day_title'    => $request->day_title
        ]);

        return back()->with('success', 'Hari itinerary berhasil ditambahkan');
    }

    public function storeItineraryItem(Request $request)
    {
        $request->validate([
            'itinerary_id' => 'required',
            'activity'     => 'required',
        ]);

        OpenTripItineraryItem::create([
            'itinerary_id' => $request->itinerary_id,
            'time'         => $request->time,
            'activity'     => $request->activity
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
        $contacts = Contact::orderBy('nama')->get();
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
            'images.*'       => 'nullable|image|max:4096',
            'hapus_images'   => 'nullable',
            'id_contact'     => 'nullable|uuid',
        ]);

        $manager = new ImageManager(new Driver());

        $list = $trip->images ?? [];

        // ------------------------------
        //  DELETE OLD IMAGES
        // ------------------------------
        $hapus = json_decode($request->hapus_images, true) ?? [];

        if (!empty($hapus)) {
            foreach ($hapus as $file) {
                Storage::disk('public')->delete($file);
                $list = array_values(array_diff($list, [$file]));
            }
        }

        // ------------------------------
        //  ADD NEW WEBP IMAGES
        // ------------------------------
        if ($request->hasFile('images')) {

            foreach ($request->file('images') as $file) {

                $name = Str::uuid() . '.webp';
                $path = "opentrip/$name";

                $img = $manager->read($file)->toWebp(80);
                Storage::disk('public')->put($path, $img);

                $list[] = $path;
            }
        }

        // ------------------------------
        // UPDATE TRIP
        // ------------------------------
        $trip->update([
            'title'         => $request->title,
            'description'   => $request->description,
            'price'         => $request->price,
            'price_label'   => $request->price_label,
            'meeting_point' => $request->meeting_point,
            'include'       => $request->include,
            'id_contact'    => $request->id_contact,
            'images'        => $list,
        ]);

        return redirect()->route('trip.detail', $trip->id)
            ->with('success', 'Trip berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $trip = OpenTrip::findOrFail($id);

        if ($trip->images) {
            foreach ($trip->images as $img) {
                Storage::disk('public')->delete($img);
            }
        }

        $trip->destinations()->delete();
        $trip->schedules()->delete();
        $trip->itineraries()->delete();
        $trip->delete();

        return redirect()->route('trip.index')
            ->with('success', 'Trip berhasil dihapus.');
    }
}
