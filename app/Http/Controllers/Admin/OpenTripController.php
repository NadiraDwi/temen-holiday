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
        'title'          => 'required|string|max:255',
        'description'    => 'required|string',
        'price'          => 'required|numeric|min:0',
        'price_label'    => 'nullable|string|max:255',
        'meeting_point'  => 'required|string|max:255',
        'include'        => 'required|string',
        'id_contact'     => 'nullable|uuid',

        // gambar
        'images'         => 'required',
        'images.*'       => 'image|mimes:jpg,jpeg,png,webp|max:4096',
    ], [
        'title.required'         => 'Nama trip wajib diisi.',
        'description.required'   => 'Deskripsi wajib diisi.',
        'price.required'         => 'Harga wajib diisi.',
        'price.numeric'          => 'Harga harus berupa angka.',
        'meeting_point.required' => 'Meeting point wajib diisi.',
        'include.required'       => 'Fasilitas / include wajib diisi.',

        'images.required'        => 'Minimal upload 1 gambar.',
        'images.*.image'         => 'File harus berupa gambar.',
        'images.*.mimes'         => 'Gambar harus berformat JPG, JPEG, PNG, atau WEBP.',
        'images.*.max'           => 'Ukuran maksimal gambar adalah 4 MB.',
    ]);

    // PROSES SIMPAN GAMBAR
    $manager = new ImageManager(new Driver());
    $paths = [];

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
        'id_contact'     => 'nullable|uuid',
        'images.*'       => 'nullable|image|max:4096',
        'deleted_images' => 'nullable|string',
    ]);

    $manager = new ImageManager(new Driver());
    $list = $trip->images ?? [];

    // HAPUS GAMBAR LAMA
    $hapus = json_decode($request->deleted_images, true) ?? [];

    foreach ($hapus as $file) {
        Storage::disk('public')->delete($file);
        $list = array_values(array_diff($list, [$file]));
    }

    // TAMBAH GAMBAR BARU
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $file) {

            $name = Str::uuid() . '.webp';
            $path = "opentrip/$name";

            $img = $manager->read($file)->toWebp(80);
            Storage::disk('public')->put($path, $img);

            $list[] = $path;
        }
    }

    // UPDATE DATA
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
