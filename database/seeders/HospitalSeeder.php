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
            ['id' => 1, 'name' => 'RSUD Kabupaten Tangerang', 'address' => 'Jl. Jend. Ahmad Yani No.9, RT.001/RW.003, Sukaasih, Kec. Tangerang, Kota Tangerang, Banten 15111', 'link' => 'https://goo.gl/maps/4Mt65y65o2KDjJPx6', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'RSUD dr. Chasbullah Abdulmadjid Kota Bekasi', 'address' => 'Jl. Pramuka No.55, RT.06/RW.6, Marga Jaya, Kec. Bekasi Sel., Kota Bks, Jawa Barat 17141', 'link' => 'https://goo.gl/maps/HU7UbLzyS1vQ9WxQ6', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'name' => 'RSUD Kabupaten Bekasi', 'address' => 'Jl. Raya Teuku Umar No.202, Wanasari, Kec. Cibitung, Bekasi, Jawa Barat 17520', 'link' => 'https://goo.gl/maps/MxNLMxtExoCC4Qaa8', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
