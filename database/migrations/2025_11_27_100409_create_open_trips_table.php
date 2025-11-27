<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('open_trips', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // contoh: Open Trip Kawah Ijen - Yogyakarta
            $table->string('meeting_point')->nullable(); // contoh: Stasiun Malang Kota Baru
            $table->text('description')->nullable(); // deskripsi atau catatan tambahan
            $table->integer('price'); // contoh: 685000
            $table->string('price_label')->nullable(); // contoh: "685K / pax"
            $table->text('include')->nullable(); // fasilitas: transportasi, makan, dll
            $table->string('cover_image')->nullable(); // upload poster
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('open_trips');
    }
};
