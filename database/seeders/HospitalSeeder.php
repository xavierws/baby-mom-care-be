<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HospitalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('hospitals')->insert([
            ['id' => 1, 'name' => 'RSUD Kabupaten Tangerang', 'address' => 'Jl. Jend. Ahmad Yani No.9, RT.001/RW.003, Sukaasih, Kec. Tangerang, Kota Tangerang, Banten 15111', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'RSUD dr. Chasbullah Abdulmajid Kota Bekasi', 'address' => 'Jl. Pramuka No.55, RT.06/RW.6, Marga Jaya, Kec. Bekasi Sel., Kota Bks, Jawa Barat 17141', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
