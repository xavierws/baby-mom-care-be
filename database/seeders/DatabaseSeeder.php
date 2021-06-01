<?php

namespace Database\Seeders;

use App\Http\Controllers\ChatController;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            HospitalSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
            CategorySeeder::class,
            TopicSeeder::class,
            // ChatSeeder::class,
            SurveySeeder::class,
            MateriSeeder::class
        ]);
    }
}
