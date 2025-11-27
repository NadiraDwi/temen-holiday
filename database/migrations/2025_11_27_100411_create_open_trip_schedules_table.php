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
        Schema::create('open_trip_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('open_trip_id')->constrained('open_trips')->onDelete('cascade');
            $table->date('start_date'); // contoh: 2025-11-22
            $table->date('end_date');   // contoh: 2025-11-23
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('open_trip_schedules');
    }
};
