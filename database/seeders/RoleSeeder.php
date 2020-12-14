<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
           ['id' => 10, 'name' => 'patient', 'created_at' => now(), 'updated_at' => now()],
           ['id' => 20, 'name' => 'nurse', 'created_at' => now(), 'updated_at' => now()],
           ['id' => 21, 'name' => 'admin', 'created_at' => now(), 'updated_at' => now()],
           ['id' => 22, 'name' => 'super_admin', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
