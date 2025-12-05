<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('landing_pages', function (Blueprint $table) {
            $table->char('id_landing', 36)->primary();
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->string('alamat')->nullable();
            $table->string('kontak')->nullable();
            $table->string('gambar_header')->nullable();
            $table->text('embed_maps')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('landing_pages');
    }
};
