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
            ['id' => 1, 'name' => 'category_1', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'category_2', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'name' => 'category_3', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'name' => 'category_4', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'name' => 'category_5', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
