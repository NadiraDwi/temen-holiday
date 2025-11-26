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
        $kendaraan = Vehicle::where('id_vehicle', $request->id_kendaraan)->firstOrFail();

        // ambil nomor whatsapp di relasi contact
        $waNumber = $kendaraan->contact->no_hp ?? null;

        // Ubah 0 → 62
        if (substr($waNumber, 0, 1) === '0') {
            $waNumber = '62' . substr($waNumber, 1);
        }

        if (!$waNumber) {
            return back()->with('error', 'Nomor WhatsApp tidak tersedia.');
        }

        // Data form
        $nama   = $request->nama;
        $telp   = $request->telepon;
        $mulai  = $request->mulai;
        $selesai= $request->selesai;
        $alamat = $request->alamat;

        // Buat pesan
        $pesan = "
Halo Admin, saya ingin memesan kendaraan.

*IDENTITAS*
• Nama: $nama
• Telepon: $telp

*DETAIL KENDARAAN*
• Kendaraan: {$kendaraan->nama_kendaraan}
• Kapasitas: {$kendaraan->kapasitas} orang
• Harga: Rp " . number_format($kendaraan->harga,0,',','.') . "/hari 

*DETAIL PEMESANAN*
• Tanggal Mulai: $mulai
• Tanggal Selesai: $selesai

*Alamat Penjemputan*
$alamat
";

        // Encode URL untuk WhatsApp
        $pesan = urlencode($pesan);

        // Redirect ke WhatsApp
        return redirect("https://wa.me/$waNumber?text=$pesan");
    }
}
