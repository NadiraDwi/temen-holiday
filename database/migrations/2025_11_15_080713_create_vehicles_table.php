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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->char('id_vehicle', 36)->primary();
            $table->string('nama_kendaraan');
            $table->integer('kapasitas');
            $table->string('gambar')->nullable();
            $table->text('fasilitas')->nullable();
            $table->decimal('harga', 12, 2);
            
            $table->char('id_contact', 36);
            $table->foreign('id_contact')->references('id_contact')->on('contacts');

            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('updated_by')
                ->references('id')
                ->on('users')
                ->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
