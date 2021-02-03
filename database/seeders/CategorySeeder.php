<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            ['name' => 'Seputar BBLR', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Nutrisi', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Perawatan BBLR', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Kegawatan bayi', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Imunisasi', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Pertumbuhan dan perkembangan', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
