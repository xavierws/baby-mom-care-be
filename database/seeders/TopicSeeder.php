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
        DB::table('categories')->insert([
            ['id' => 1, 'name' => 'topic_1', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'topic_2', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'name' => 'topic_3', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'name' => 'topic_4', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'name' => 'topic_5', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
