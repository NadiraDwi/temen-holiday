<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('galleries', function (Blueprint $table) {

            // 1. Drop FK lama ke admins (kalau ada)
            try {
                $table->dropForeign(['created_by']);
            } catch (\Exception $e) {}

            // 2. Ubah tipe kolom updated_by agar cocok dengan users.id
            $table->unsignedBigInteger('created_by')->nullable()->change();

            // 3. Tambahkan foreign key baru ke users
            $table->foreign('created_by')
                ->references('id')
                ->on('users')
                ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('galleries', function (Blueprint $table) {

            // rollback FK ke users
            try {
                $table->dropForeign(['created_by']);
            } catch (\Exception $e) {}

            // ubah kembali ke char(36)
            $table->char('created_by', 36)->nullable()->change();

            // tambah kembali FK ke admins.id_admin
            $table->foreign('created_by')
                ->references('id_admin')
                ->on('admins')
                ->onDelete('set null');
        });
    }
};
