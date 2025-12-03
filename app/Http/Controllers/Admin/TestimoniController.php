<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestimoniController extends Controller
{
    public function index()
    {
        $testimoni = Testimonial::latest()->get();
        return view('admin.testimoni.index', compact('testimoni'));
    }

    public function reply(Request $request, $id)
    {
        $request->validate([
            'reply_admin' => 'required|string',
        ]);

        $t = Testimonial::where('id_testimoni', $id)->firstOrFail();
        $t->reply_admin = $request->reply_admin;
        $t->save();

        return back()->with('success', 'Balasan berhasil dikirim.');
    }

    public function destroy($id)
    {
        $t = Testimonial::where('id_testimoni', $id)->firstOrFail();

        if ($t->images) {
            foreach ($t->images as $img) {
                Storage::disk('public')->delete($img);
            }
        }

        $t->delete();

        return back()->with('success', 'Testimoni berhasil dihapus.');
    }
}
