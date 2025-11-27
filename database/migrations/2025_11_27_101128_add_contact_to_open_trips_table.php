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
        Schema::table('open_trips', function (Blueprint $table) {
            $table->char('id_contact')->nullable()->after('cover_image');

            $table->foreign('id_contact')
                ->references('id_contact')
                ->on('contacts')
                ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('open_trips', function (Blueprint $table) {
            $table->dropForeign(['id_contact']);
            $table->dropColumn('id_contact');
        });
    }

};
