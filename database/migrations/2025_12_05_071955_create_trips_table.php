<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('wisata', function (Blueprint $table) {
            $table->id();

            $table->string('title');               // Nama wisata
            $table->text('description')->nullable(); 
            
            $table->integer('price');              // Harga
            $table->string('price_label')->nullable(); // contoh: "325K / orang"
            
            $table->text('include')->nullable();   // fasilitas
            
            $table->json('images')->nullable();    // multi-image JSON

            // kontak → cuma ID, tidak pakai email / phone
            $table->char('id_contact', 36);
            $table->foreign('id_contact')->references('id_contact')->on('contacts');

            // maps
            $table->string('map_url')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wisata');
    }
};
