<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use App\Models\VehicleCategory;
use App\Models\Contact;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class KendaraanController extends Controller
{
    /**
     * PAGE LIST KENDARAAN
     */
    public function index()
    {
        return view('admin.kendaraan.list');
    }

    /**
     * PAGE CREATE
     */
    public function create()
    {
        return view('admin.kendaraan.create', [
            'kategori' => VehicleCategory::orderBy('kategori')->get(),
            'contact'  => Contact::orderBy('nama')->get()
        ]);
    }

    /**
     * PAGE EDIT
     */
    public function edit($id)
    {
        $data = Vehicle::where('id_vehicle', $id)->firstOrFail();

        return view('admin.kendaraan.edit', [
            'data'     => $data,
            'kategori' => VehicleCategory::orderBy('kategori')->get(),
            'contact'  => Contact::orderBy('nama')->get()
        ]);
    }

    /**
     * DATATABLE LIST
     */
    public function list(Request $request)
    {
        if ($request->ajax()) {

            $data = Vehicle::with(['contact', 'updatedBy', 'kategori'])
                ->orderBy('nama_kendaraan', 'ASC');

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('kategori', fn($row) =>
                    $row->kategori?->kategori ?? '-'
                )
                ->editColumn('harga', fn($row) =>
                    'Rp ' . number_format($row->harga, 0, ',', '.')
                )
                ->addColumn('action', fn($row) => '
                    <button class="btn btn-sm btn-info btn-detail" data-id="' . $row->id_vehicle . '">
                        <i class="fas fa-eye"></i> Detail
                    </button>
                ')
                ->rawColumns(['action'])
                ->make(true);
        }

        return abort(404);
    }

    /**
     * DETAIL UNTUK MODAL / AJAX
     */
    public function detail($id)
    {
        $data = Vehicle::with(['contact', 'kategori'])
            ->where('id_vehicle', $id)
            ->firstOrFail();

        // KONVERSI PATH Gambar → URL
        $data->images = collect($data->images ?? [])
            ->map(fn($img) => asset("storage/" . $img));

        return response()->json($data);
    }

    /**
     * STORE — ADD MULTI IMAGE
     */
    public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'nama_kendaraan' => 'required|string|max:255',
        'kapasitas'      => 'required|numeric|min:1',
        'fasilitas'      => 'required|string',
        'harga'          => 'required|numeric|min:0',
        'images.*'       => 'nullable|image|max:4096|mimes:jpg,jpeg,png,webp',
        'id_contact'     => 'required|exists:contacts,id_contact',
        'id_kategori'    => 'required|exists:vehicle_categories,id_category',
    ], [
        // === Pesan Error Custom ===
        'nama_kendaraan.required' => 'Nama kendaraan wajib diisi.',
        'kapasitas.required'      => 'Kapasitas wajib diisi.',
        'kapasitas.numeric'       => 'Kapasitas harus berupa angka.',
        'fasilitas.required'      => 'Fasilitas wajib diisi.',
        'harga.required'          => 'Harga wajib diisi.',
        'harga.numeric'           => 'Harga harus berupa angka.',
        'images.*.image'          => 'File harus berupa gambar.',
        'images.*.max'            => 'Ukuran gambar maksimal 4MB.',
        'images.*.mimes'          => 'Format gambar harus JPG, JPEG, PNG, atau WEBP.',
        'id_contact.required'     => 'Kontak wajib dipilih.',
        'id_contact.exists'       => 'Kontak tidak valid.',
        'id_kategori.required'    => 'Kategori wajib dipilih.',
        'id_kategori.exists'      => 'Kategori tidak valid.',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'errors' => $validator->errors()
        ], 422);
    }

    // ========================
    //   PROSES SIMPAN GAMBAR
    // ========================
    $manager = new ImageManager(new Driver());
    $paths = [];

    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $file) {

            $name = Str::uuid() . '.webp';
            $path = "kendaraan/$name";

            $img = $manager->read($file)->toWebp(75);
            Storage::disk('public')->put($path, $img);

            $paths[] = $path;
        }
    }

    // ========================
    //   SIMPAN KE DATABASE
    // ========================
    Vehicle::create([
        'nama_kendaraan' => $request->nama_kendaraan,
        'kapasitas'      => $request->kapasitas,
        'fasilitas'      => $request->fasilitas,
        'harga'          => $request->harga,
        'images'         => $paths,
        'id_contact'     => $request->id_contact,
        'id_kategori'    => $request->id_kategori,
        'tampilkan_harga'=> $request->tampilkan_harga ? 1 : 0,
        'updated_by'     => Auth::id()
    ]);

    return response()->json(['success' => true]);
}

    /**
     * UPDATE — MULTI IMAGE
     */
    public function update(Request $request, $id)
    {
        $kendaraan = Vehicle::where('id_vehicle', $id)->firstOrFail();

        $validator = Validator::make($request->all(), [
            'nama_kendaraan' => 'required|string|max:255',
            'kapasitas'      => 'required|numeric|min:1',
            'fasilitas'      => 'required|string',
            'harga'          => 'required|numeric|min:0',
            'images.*'       => 'nullable|image|max:4096|mimes:jpg,jpeg,png,webp',
            'hapus_images'   => 'nullable',
            'id_contact'     => 'required|exists:contacts,id_contact',
            'id_kategori'    => 'required|exists:vehicle_categories,id_category',
        ], [
            // Custom error messages
            'nama_kendaraan.required' => 'Nama kendaraan wajib diisi.',
            'kapasitas.required'      => 'Kapasitas wajib diisi.',
            'kapasitas.numeric'       => 'Kapasitas harus berupa angka.',
            'kapasitas.min'           => 'Kapasitas minimal 1 orang.',
            'fasilitas.required'      => 'Fasilitas wajib diisi.',
            'harga.required'          => 'Harga wajib diisi.',
            'harga.numeric'           => 'Harga harus berupa angka.',
            'images.*.image'          => 'File harus berupa gambar.',
            'images.*.max'            => 'Ukuran gambar maksimal 4MB.',
            'images.*.mimes'          => 'Format gambar harus JPG, JPEG, PNG, atau WEBP.',
            'id_contact.required'     => 'Kontak wajib dipilih.',
            'id_contact.exists'       => 'Kontak tidak valid.',
            'id_kategori.required'    => 'Kategori wajib dipilih.',
            'id_kategori.exists'      => 'Kategori tidak valid.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $manager = new ImageManager(new Driver());
        $list = $kendaraan->images ?? [];

        // ===============================
        //  FIX: DECODE JSON
        // ===============================
        $hapus = json_decode($request->hapus_images, true) ?? [];

        // ===============================
        //  HAPUS GAMBAR
        // ===============================
        if (!empty($hapus)) {
            foreach ($hapus as $file) {
                Storage::disk('public')->delete($file);
                $list = array_values(array_diff($list, [$file]));
            }
        }

        // ===============================
        //  TAMBAH GAMBAR BARU
        // ===============================
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $name = Str::uuid() . '.webp';
                $path = "kendaraan/$name";

                $img = $manager->read($file)->toWebp(75);
                Storage::disk('public')->put($path, $img);

                $list[] = $path;
            }
        }

        // ===============================
        //  UPDATE DATA
        // ===============================
        $kendaraan->update([
            'nama_kendaraan' => $request->nama_kendaraan,
            'kapasitas'      => $request->kapasitas,
            'fasilitas'      => $request->fasilitas,
            'harga'          => $request->harga,
            'images'         => $list,
            'id_contact'     => $request->id_contact,
            'id_kategori'    => $request->id_kategori,
            'tampilkan_harga'=> $request->tampilkan_harga ? 1 : 0,
            'updated_by'     => Auth::id(),
        ]);

        return response()->json(['success' => true]);
    }

    /**
     * DELETE
     */
    public function delete($id)
    {
        $kendaraan = Vehicle::where('id_vehicle', $id)->firstOrFail();

        if ($kendaraan->images) {
            foreach ($kendaraan->images as $img) {
                Storage::disk('public')->delete($img);
            }
        }

        $kendaraan->delete();

        return response()->json(['success' => true]);
    }

    /**
     * UPDATE STATUS TAMPILKAN HARGA
     */
    public function updateTampilkanHarga(Request $request)
    {
        $kendaraan = Vehicle::where('id_vehicle', $request->id)->firstOrFail();
        $kendaraan->tampilkan_harga = $request->tampilkan_harga ? 1 : 0;
        $kendaraan->save();

        return response()->json(['success' => true]);
    }
}
