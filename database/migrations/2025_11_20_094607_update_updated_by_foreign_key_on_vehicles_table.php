<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {

            // 1. Drop FK lama ke admins (kalau ada)
            try {
                $table->dropForeign(['updated_by']);
            } catch (\Exception $e) {}

            // 2. Ubah tipe kolom updated_by agar cocok dengan users.id
            $table->unsignedBigInteger('updated_by')->nullable()->change();

            // 3. Tambahkan foreign key baru ke users
            $table->foreign('updated_by')
                ->references('id')
                ->on('users')
                ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {

            // rollback FK ke users
            try {
                $table->dropForeign(['updated_by']);
            } catch (\Exception $e) {}

            // ubah kembali ke char(36)
            $table->char('updated_by', 36)->nullable()->change();

            // tambah kembali FK ke admins.id_admin
            $table->foreign('updated_by')
                ->references('id_admin')
                ->on('admins')
                ->onDelete('set null');
        });
    }
};
