<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('galleries', function (Blueprint $table) {

            // Ubah tipe kolom ke unsignedBigInteger
            $table->unsignedBigInteger('created_by')->nullable()->change();

            // Tambah FK ke users
            $table->foreign('created_by')
                ->references('id')->on('users')
                ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('galleries', function (Blueprint $table) {
            $table->dropForeign(['created_by']);
            $table->char('created_by', 36)->nullable()->change();
        });
    }
};
