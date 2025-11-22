<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use App\Models\VehicleCategory;
use App\Models\Contact;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class KendaraanController extends Controller
{
    /**
     * HALAMAN LIST
     */
    public function index()
    {
        return view('admin.kendaraan.list', [
            'kategori' => VehicleCategory::orderBy('kategori')->get(),
            'contact'  => Contact::orderBy('nama')->get()
        ]);
    }

    /**
     * DATATABLE AJAX
     */
    public function list(Request $request)
    {
        if ($request->ajax()) {

            $data = Vehicle::with(['contact', 'updatedBy', 'kategori'])
                        ->orderBy('nama_kendaraan', 'ASC');

            return DataTables::of($data)
                ->addIndexColumn()

                ->addColumn('kategori', function ($row) {
                    return $row->kategori ? $row->kategori->kategori : '-';
                })

                ->editColumn('harga', function ($row) {
                    return 'Rp ' . number_format($row->harga, 0, ',', '.');
                })

                ->addColumn('action', function ($row) {
                    return '
                        <button class="btn btn-sm btn-info btn-detail" data-id="' . $row->id_vehicle . '">
                            <i class="fas fa-eye"></i> Detail
                        </button>
                    ';
                })

                ->rawColumns(['harga', 'action'])
                ->make(true);
        }

        return abort(404);
    }

    /**
     * DETAIL DATA
     */
    public function detail($id)
    {
        $data = Vehicle::with(['contact', 'updatedBy', 'kategori'])
                    ->where('id_vehicle', $id)
                    ->first();

        if (!$data) {
            return response()->json(['error' => 'Not Found'], 404);
        }

        return response()->json($data);
    }

    /**
     * STORE DATA
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kendaraan' => 'required',
            'kapasitas'      => 'required|numeric',
            'fasilitas'      => 'required',
            'harga'          => 'required|numeric',
            'gambar'         => 'nullable|image|max:2048',
            'id_contact'     => 'required|exists:contacts,id_contact',
            'id_kategori'    => 'required|exists:vehicle_categories,id_category',
            'tampilkan_harga'=> 'nullable|boolean'
        ]);

        $gambar_name = null;
        if ($request->hasFile('gambar')) {
            $gambar_name = time().'_'.$request->gambar->getClientOriginalName();
            $request->gambar->storeAs('kendaraan', $gambar_name, 'public');
        }

        Vehicle::create([
            'nama_kendaraan'  => $request->nama_kendaraan,
            'kapasitas'       => $request->kapasitas,
            'fasilitas'       => $request->fasilitas,
            'harga'           => $request->harga,
            'gambar'          => $gambar_name,
            'id_contact'      => $request->id_contact,
            'id_kategori'     => $request->id_kategori,
            'tampilkan_harga' => $request->has('tampilkan_harga'),
            'updated_by'      => Auth::id(),
        ]);

        return response()->json(['success' => true]);
    }

    /**
     * UPDATE DATA
     */
    public function update(Request $request, $id)
    {
        $kendaraan = Vehicle::where('id_vehicle', $id)->first();

        if (!$kendaraan) {
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        }

        $request->validate([
            'nama_kendaraan' => 'required',
            'kapasitas'      => 'required|numeric',
            'fasilitas'      => 'required',
            'harga'          => 'required|numeric',
            'gambar'         => 'nullable|image|max:2048',
            'id_contact'     => 'required|exists:contacts,id_contact',
            'id_kategori'   => 'required|exists:vehicle_categories,id_category',
            'hapus_gambar'   => 'nullable|boolean',
            'tampilkan_harga'=> 'nullable|boolean'
        ]);

        // Hapus gambar jika user klik tombol remove
        if ($request->hapus_gambar && $kendaraan->gambar) {
            Storage::disk('public')->delete('kendaraan/' . $kendaraan->gambar);
            $kendaraan->gambar = null;
        }

        // Upload gambar baru
        if ($request->hasFile('gambar')) {
            if ($kendaraan->gambar) {
                Storage::disk('public')->delete('kendaraan/' . $kendaraan->gambar);
            }

            $gambar_name = time().'_'.$request->gambar->getClientOriginalName();
            $request->gambar->storeAs('kendaraan', $gambar_name, 'public');
            $kendaraan->gambar = $gambar_name;
        }

        // Update field lain
        $kendaraan->update([
            'nama_kendaraan'  => $request->nama_kendaraan,
            'kapasitas'       => $request->kapasitas,
            'fasilitas'       => $request->fasilitas,
            'harga'           => $request->harga,
            'id_contact'      => $request->id_contact,
            'id_kategori'     => $request->id_kategori,
            'tampilkan_harga' => $request->has('tampilkan_harga'),
            'updated_by'      => Auth::id(),
        ]);

        return response()->json(['success' => true]);
    }

    /**
     * DELETE DATA (SUDAH JALAN)
     */
    public function delete(Request $request)
    {
        $kendaraan = Vehicle::find($request->id);

        if (!$kendaraan) {
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        }

        if ($kendaraan->gambar) {
            Storage::disk('public')->delete('kendaraan/' . $kendaraan->gambar);
        }

        $kendaraan->delete();

        return response()->json(['success' => true]);
    }

    public function updateTampilkanHarga(Request $request)
    {
        $data = Vehicle::findOrFail($request->id);
        $data->tampilkan_harga = $request->tampilkan_harga;
        $data->save();

        return response()->json(['success' => true]);
    }

}
