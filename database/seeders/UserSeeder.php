<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('nurse_profiles')->insert([
            [
                'name' => 'admin',
                'working_exp' => 1,
                'education' => 'S1',
                'phone' => '088888',
                'hospital_id' => 1,
                'is_approved' => true,
            ],
            [
                'name' => 'super_admin',
                'working_exp' => 1,
                'education' => 'S1',
                'phone' => '088888',
                'hospital_id' => 1,
                'is_approved' => true,
            ]
        ]);

        DB::table('users')->insert([
            [
                'username' => 'admin',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'role_id' => 21,
                'email' => null,
                'userable_id' => 1,
                'userable_type' => 'App\Models\NurseProfile'
            ],
            [
                'username' => 'super_admin',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'role_id' => 22,
                'email' => null,
                'userable_id' => 1,
                'userable_type' => 'App\Models\NurseProfile'
            ]
        ]);
    }
}
