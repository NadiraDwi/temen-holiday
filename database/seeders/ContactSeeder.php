<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContactSeeder extends Seeder
{
    public function run()
    {
        DB::table('contacts')->insert([
            'id_contact' => 'd389af89-d1b5-11f0-97bf-54b203176797',
            'nama'       => 'nadira',
            'no_hp'      => '089630193693',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
