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
        Schema::create('open_trip_itineraries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('open_trip_id')->constrained('open_trips')->onDelete('cascade');
            $table->string('day_title'); // contoh: "Hari Ke 1"
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('open_trip_itineraries');
    }

};
