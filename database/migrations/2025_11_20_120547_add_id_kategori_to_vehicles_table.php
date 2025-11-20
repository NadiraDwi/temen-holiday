<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {

            // Tambah kolom id_kategori (nullable dulu biar aman)
            $table->char('id_kategori', 36)->nullable()->after('id_vehicle');

            // Tambah foreign key ke tabel vehicle_categories
            $table->foreign('id_kategori')
                ->references('id_category')
                ->on('vehicle_categories')
                ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            // drop foreign key
            $table->dropForeign(['id_kategori']);

            // drop kolom
            $table->dropColumn('id_kategori');
        });
    }
};
