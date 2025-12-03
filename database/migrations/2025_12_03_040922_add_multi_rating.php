<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('testimonials', function (Blueprint $table) {
            // rating lama optional, bisa dihapus atau tetap dipakai
            // $table->dropColumn('rating');

            $table->unsignedTinyInteger('rating_fasilitas')->default(0)->after('nama_user');
            $table->unsignedTinyInteger('rating_harga')->default(0)->after('rating_fasilitas');
        });
    }

    public function down(): void
    {
        Schema::table('testimonials', function (Blueprint $table) {
            $table->dropColumn('rating_hasilitas');
            $table->dropColumn('rating_harga');
        });
    }
};
