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
        Schema::create('tour_packages', function (Blueprint $table) {
            $table->char('id_paket', 36)->primary();
            $table->char('kategori_id', 36);
            $table->foreign('kategori_id')->references('id_kategori')->on('categories');

            $table->string('nama_paket');
            $table->string('gambar')->nullable();
            $table->text('deskripsi')->nullable();
            $table->text('fasilitas')->nullable();
            $table->text('destinasi')->nullable();
            $table->integer('kapasitas');
            $table->decimal('harga', 12, 2);

            $table->char('id_contact', 36);
            $table->foreign('id_contact')->references('id_contact')->on('contacts');

            $table->char('updated_by', 36)->nullable();
            $table->foreign('updated_by')->references('id_admin')->on('admins')
                ->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tour_packages');
    }
};
