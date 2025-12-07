<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use App\Models\VehicleCategory;
use Illuminate\Http\Request;

class KendaraanController extends Controller
{
    public function index()
    {
        $categories = VehicleCategory::all();
        $vehicles = Vehicle::with('kategori')->get();

        return view('landing.kendaraan', compact('categories', 'vehicles'));
    }

    public function pesan($id)
    {
        $kendaraan = Vehicle::findOrFail($id);

        return view('landing.pesan-kendaraan', compact('kendaraan'));
    }

    public function kirimWhatsApp(Request $request)
{
    $request->validate([
        'nama'      => 'required|string|max:255',
        'telepon'   => 'required|string|max:20',
        'mulai'     => 'required|date',
        'selesai'   => 'required|date|after_or_equal:mulai',
        'alamat'    => 'required|string|max:500',
        'destinasi' => 'required|array|min:1',
        'destinasi.*' => 'required|string|max:255',
    ], [
        'nama.required' => 'Nama wajib diisi.',
        'telepon.required' => 'Nomor telepon wajib diisi.',
        'mulai.required' => 'Tanggal mulai wajib diisi.',
        'selesai.required' => 'Tanggal selesai wajib diisi.',
        'selesai.after_or_equal' => 'Tanggal selesai harus setelah tanggal mulai.',
        'alamat.required' => 'Alamat penjemputan wajib diisi.',
        'destinasi.required' => 'Minimal harus ada satu tujuan destinasi.',
        'destinasi.*.required' => 'Tujuan destinasi tidak boleh kosong.',
    ]);
    
    $kendaraan = Vehicle::where('id_vehicle', $request->id_kendaraan)
                ->with('contact')
                ->firstOrFail();

    // Ambil nomor WA dari relasi contact
    $waNumber = $kendaraan->contact->no_hp ?? null;

    if (!$waNumber) {
        return back()->with('error', 'Nomor WhatsApp tidak tersedia.');
    }

    // Normalisasi nomor: 08xxxx → 628xxxx
    if (substr($waNumber, 0, 1) === '0') {
        $waNumber = '62' . substr($waNumber, 1);
    }

    // ===== DATA FORM =====
    $nama     = $request->nama;
    $telp     = $request->telepon;
    $mulai    = $request->mulai;
    $selesai  = $request->selesai;
    $alamat   = $request->alamat;

    // Ambil daftar destinasi (array → bullet list)
    $destinasiList = "";
    if ($request->destinasi && is_array($request->destinasi)) {
        foreach ($request->destinasi as $d) {
            $clean = trim($d);
            if ($clean !== "") {
                $destinasiList .= "• $clean\n";
            }
        }
    }

    // ===== BENTUK PESAN WHATSAPP =====
    $pesan = "
Halo Admin, saya ingin memesan kendaraan.

*IDENTITAS*
• Nama: $nama
• Telepon: $telp

*DETAIL KENDARAAN*
• Kendaraan: {$kendaraan->nama_kendaraan}
• Kapasitas: {$kendaraan->kapasitas} orang
• Harga: Rp " . number_format($kendaraan->harga, 0, ',', '.') . "/hari

*DETAIL PEMESANAN*
• Tanggal Mulai: $mulai
• Tanggal Selesai: $selesai

*Tujuan Destinasi*
$destinasiList

*Alamat Penjemputan*
$alamat
";

    // Encode pesan agar aman dipakai di URL
    $encoded = urlencode($pesan);

    return redirect("https://wa.me/$waNumber?text=$encoded");
}

}
