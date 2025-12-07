<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Wisata;
use App\Models\Contact;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class WisataController extends Controller
{
    /**
     * PAGE LIST
     */
    public function index()
    {
        return view('admin.wisata.list');
    }

    /**
     * PAGE CREATE
     */
    public function create()
    {
        return view('admin.wisata.create', [
            'contact' => Contact::orderBy('nama')->get()
        ]);
    }

    /**
     * PAGE EDIT
     */
    public function edit($id)
    {
        $data = Wisata::findOrFail($id);

        return view('admin.wisata.edit', [
            'data'    => $data,
            'contact' => Contact::orderBy('nama')->get()
        ]);
    }

    /**
     * DATATABLE LIST
     */
    public function list(Request $request)
    {
        if ($request->ajax()) {

            $data = Wisata::with('contact')->orderBy('title', 'ASC');

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('price', fn($row) =>
                    'Rp ' . number_format($row->price, 0, ',', '.')
                )
                ->addColumn('action', fn($row) => '
                    <button class="btn btn-sm btn-info btn-detail" data-id="' . $row->id . '">
                        <i class="fas fa-eye"></i> Detail
                    </button>
                ')
                ->rawColumns(['action'])
                ->make(true);
        }

        return abort(404);
    }

    /**
     * DETAIL (MODAL / AJAX)
     */
    public function detail($id)
    {
        $data = Wisata::with('contact')->findOrFail($id);

        // convert path → URL
        $data->images = collect($data->images ?? [])
            ->map(fn($img) => asset("storage/" . $img));

        return response()->json($data);
    }

    /**
     * STORE — MULTI IMAGE
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required',
            'price'       => 'required|numeric',
            'include'     => 'required',
            'images'      => 'nullable|array',
            'images.*'    => 'nullable|image|max:4096',
            'contact_id'  => 'nullable|exists:contacts,id_contact',
        ]);

        $manager = new ImageManager(new Driver());
        $paths = [];

        // Upload & konversi ke WEBP
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {

                $name = Str::uuid() . '.webp';
                $path = "wisata/$name";

                // Konversi ke WebP (biarkan sama karena stabil)
                $img = $manager->read($file)->toWebp(75);

                Storage::disk('public')->put($path, $img);
                $paths[] = $path;
            }
        }

        Wisata::create([
            'title'        => $request->title,
            'description'  => $request->description,
            'price'        => $request->price,
            'price_label'  => $request->price_label,
            'include'      => $request->include,
            'images'       => $paths,
            'id_contact'   => $request->contact_id,
            'map_url'      => $request->map_url
        ]);

        return response()->json(['success' => true]);
    }


    /**
     * UPDATE — MULTI IMAGE
     */
    public function update(Request $request, $id)
{
    $wisata = Wisata::findOrFail($id);

    $request->validate([
        'title'       => 'required|string|max:255',
        'description' => 'required|string',
        'price'       => 'required|numeric',
        'price_label' => 'required|string',
        'include'     => 'nullable|string',
        'map_url'     => 'nullable|string',
        'contact_id'  => 'nullable|exists:contacts,id_contact',
        'images.*'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
    ]);

    $wisata->title       = $request->title;
    $wisata->description = $request->description;
    $wisata->price       = $request->price;
    $wisata->price_label = $request->price_label;
    $wisata->include     = $request->include;
    $wisata->map_url     = $request->map_url;
    $wisata->id_contact  = $request->contact_id;

    // Hapus gambar lama
    $hapus = json_decode($request->hapus_images, true);
    if ($hapus && is_array($hapus)) {
        foreach ($hapus as $file) {
            Storage::disk('public')->delete($file);
        }
        $wisata->images = array_values(array_diff($wisata->images ?? [], $hapus));
    }

    // Tambah gambar baru
    if ($request->hasFile('images')) {
        $newImages = [];
        foreach ($request->file('images') as $img) {
            if ($img) {
                $path = $img->store('wisata', 'public');
                $newImages[] = $path;
            }
        }
        $wisata->images = array_merge($wisata->images ?? [], $newImages);
    }

    $wisata->save();

    return response()->json([
        'request' => $request->all(),
        'success' => true,
        'message' => 'Berhasil Update'
    ]);
}
    /**
     * DELETE
     */
    public function delete($id)
    {
        $wisata = Wisata::findOrFail($id);

        if ($wisata->images) {
            foreach ($wisata->images as $img) {
                Storage::disk('public')->delete($img);
            }
        }

        $wisata->delete();

        return response()->json(['success' => true]);
    }
}
