<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
            // [
            //     'name' => 'admin',
            //     'working_exp' => 1,
            //     'education' => 'S1',
            //     'phone' => '089765432100',
            //     'hospital_id' => 1,
            //     'is_approved' => true,
            // ],
            // [
            //     'name' => 'super_admin',
            //     'working_exp' => 1,
            //     'education' => 'S1',
            //     'phone' => '089765432100',
            //     'hospital_id' => 1,
            //     'is_approved' => true,
            // ],
            // [
            //     'name' => 'Raka',
            //     'working_exp' => 1,
            //     'education' => 'S1',
            //     'phone' => '089765432100',
            //     'hospital_id' => 1,
            //     'is_approved' => true,
            // ]
            [
                'name' => 'kristiawati',
                'working_exp' => 1,
                'education' => 'S1',
                'phone' => '081334746022',
                'hospital_id' => 1,
                'is_approved' => true,
            ]
        ]);

        DB::table('users')->insert([
            // [
            //     'username' => 'admin',
            //     'password' => Hash::make('admin-123'),
            //     'role_id' => 21,
            //     'email' => null,
            //     'userable_id' => 1,
            //     'userable_type' => 'App\Models\NurseProfile'
            // ],
            // [
            //     'username' => 'super_admin',
            //     'password' => Hash::make('admin-123'),
            //     'role_id' => 22,
            //     'email' => null,
            //     'userable_id' => 2,
            //     'userable_type' => 'App\Models\NurseProfile'
            // ],
            // [
            //     'username' => 'raka',
            //     'password' => Hash::make('admin-123'),
            //     'role_id' => 20,
            //     'email' => null,
            //     'userable_id' => 3,
            //     'userable_type' => 'App\Models\NurseProfile'
            // ]
            [
                'username' => 'kristiawati',
                'password' => Hash::make('Cektokosebelah123'),
                'role_id' => 22,
                'email' => null,
                'userable_id' => 1,
                'userable_type' => 'App\Models\NurseProfile'
            ]
        ]);
    }
}
