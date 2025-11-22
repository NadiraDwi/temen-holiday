<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VehicleCategory;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;

class CategoryKendaraanController extends Controller
{
    public function index()
    {
        return view('admin.kategori-kendaraan.list');
    }

    public function list(Request $request)
    {
        if ($request->ajax()) {

            $data = VehicleCategory::orderBy('kategori', 'ASC');

            return DataTables::of($data)
                ->addIndexColumn()

                ->addColumn('action', function ($row) {
                return '
                    <button class="btn btn-sm btn-warning me-1"
                        onclick="editData(\''.$row->id_category.'\')">
                        Edit
                    </button>

                    <button class="btn btn-sm btn-outline-danger"
                        onclick="deleteData(\''.$row->id_category.'\')">
                        Hapus
                    </button>
                ';
            })

                ->rawColumns(['action'])
                ->make(true);
        }

        return abort(404);
    }

    public function create()
    {
        return view('kategori-kendaraan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori' => 'required'
        ]);

        VehicleCategory::create([
            'id_category' => Str::uuid(),
            'kategori' => $request->kategori,
            'keterangan' => $request->keterangan
        ]);

        return response()->json(['success' => true]);
    }

    public function show(Request $request)
    {
        $data = VehicleCategory::find($request->id);
        return response()->json($data);
    }

    public function update(Request $request)
    {
        $request->validate([
            'kategori' => 'required'
        ]);

        VehicleCategory::where('id_category', $request->id)->update([
            'kategori' => $request->kategori,
            'keterangan' => $request->keterangan
        ]);

        return response()->json(['success' => true]);
    }

    public function delete(Request $request)
    {
        $data = VehicleCategory::find($request->id);

        if (!$data) {
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        }

        $data->delete();

        return response()->json(['success' => true]);
    }
}
