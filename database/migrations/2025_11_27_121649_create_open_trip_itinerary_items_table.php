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
        Schema::create('open_trip_itinerary_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('itinerary_id')->constrained('open_trip_itineraries')->onDelete('cascade');
            $table->time('time')->nullable(); // contoh: 08:00
            $table->string('activity');       // contoh: "Naik speedboat dan trip dimulai"
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('open_trip_itinerary_items');
    }

};
