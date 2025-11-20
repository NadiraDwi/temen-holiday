<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class KendaraanController extends Controller
{
    public function index()
    {
        return view('admin.kendaraan.list');
    }

    /**
     * AJAX Datatable
     */
    public function list(Request $request)
    {
        if ($request->ajax()) {

            $data = Vehicle::with(['contact', 'updatedBy'])->orderBy('nama_kendaraan', 'ASC');

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('kategori', function ($row) {
                    return $row->kategori ? $row->kategori->kategori : '-';
                })
                // Gambar di tabel
                ->editColumn('gambar', function ($row) {
                    if (!$row->gambar) {
                        return '<span class="text-muted">Tidak ada gambar</span>';
                    }
                    return '<img src="'.asset('storage/kendaraan/'.$row->gambar).'"
                            class="img-thumbnail" width="70">';
                })

                // Harga format Rp
                ->editColumn('harga', function ($row) {
                    return 'Rp ' . number_format($row->harga, 0, ',', '.');
                })

                // Action Button
                ->addColumn('action', function ($row) {
                    return '
                        <button class="btn btn-sm btn-outline-primary me-1"
                            onclick="detailData(\''.$row->id_vehicle.'\')">
                            <i class="fas fa-eye"> Detail</i>
                        </button>
                    ';
                })

                ->rawColumns(['gambar', 'action'])
                ->make(true);
        }

        return abort(404);
    }

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

    public function create()
    {
        $contacts = \App\Models\Contact::orderBy('nama')->get();
        return view('admin.kendaraan.create', compact('contacts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kendaraan' => 'required',
            'kapasitas' => 'required|numeric',
            'fasilitas' => 'required',
            'harga' => 'required|numeric',
            'gambar' => 'nullable|image|max:2048',
            'contact_id' => 'required|exists:contacts,contact_id',
        ]);

        // Upload gambar
        $gambar_name = null;
        if ($request->hasFile('gambar')) {
            $gambar_name = time().'_'.$request->gambar->getClientOriginalName();
            $request->gambar->storeAs('kendaraan', $gambar_name, 'public');
        }

        Vehicle::create([
            'nama_kendaraan' => $request->nama_kendaraan,
            'kapasitas' => $request->kapasitas,
            'fasilitas' => $request->fasilitas,
            'harga' => $request->harga,
            'gambar' => $gambar_name,
            'id_contact' => $request->id_contact,   // 🟦 DITAMBAH
            'updated_by' => Auth::user()->id,        // user login
        ]);

        return redirect()->route('admin.kendaraan.index')
            ->with('success', 'Data kendaraan berhasil ditambahkan!');
    }

    public function delete(Request $request)
    {
        $id = $request->id;

        $kendaraan = Vehicle::find($id);

        if (!$kendaraan) {
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        }

        if ($kendaraan->gambar) {
            Storage::disk('public')->delete('kendaraan/' . $kendaraan->gambar);
        }

        $kendaraan->delete();

        return response()->json(['success' => true]);
    }
}
