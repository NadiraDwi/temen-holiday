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
