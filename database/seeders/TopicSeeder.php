<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TopicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('topics')->insert([
            ['id' => 1, 'name' => 'Seputar BBLR', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'Nutrisi', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'name' => 'Perawatan BBLR', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'name' => 'Kegawatan bayi', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'name' => 'Imunisasi', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 6, 'name' => 'Pertumbuhan dan perkembangan', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 7, 'name' => 'Lain-lain', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
