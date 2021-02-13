<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MateriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('materis')->insert([
            ['title' => 'Cara Pencegahan Infeksi', 'content' => 'Berikut adalah video pembelajaran tentang Cara Pencegahan Infeksi https://youtu.be/ql02JGwl9qM', 'category_id' => '3'],
            ['title' => 'Posisi Pemberian ASI', 'content' => 'Berikut adalah video pembelajaran tentang Posisi Pemberian ASI https://youtu.be/gNUg2ESe8QE', 'category_id' => '2'],
            ['title' => 'Cara memerah ASI dengan tangan', 'content' => 'Berikut adalah video pembelajaran tentang Cara memerah ASI dengan tangan https://youtu.be/taWaj3nvsYA', 'category_id' => '2'],
            ['title' => 'Cara memerah ASI dengan pompa', 'content' => 'Berikut adalah video pembelajaran tentang Cara memerah ASI dengan pompa https://youtu.be/jJ5LrJz2iy8', 'category_id' => '2'],
            ['title' => 'Cara menyimpan ASI Perah', 'content' => 'Berikut adalah video pembelajaran tentang Cara menyimpan ASI Perah https://youtu.be/EQaoOXdWEQE', 'category_id' => '2'],
            ['title' => 'Cara mencairkan dan menyiapkan ASI Perah yang beku', 'content' => 'Berikut adalah video pembelajaran tentang Cara mencairkan dan menyiapkan ASI Perah yang beku https://youtu.be/1JCmDsh0r70', 'category_id' => '2'],
            ['title' => 'Cara memberikan ASI Perah dengan cangkir ', 'content' => 'Berikut adalah video pembelajaran tentang Cara memberikan ASI Perah dengan cangkir https://youtu.be/U9FY1lDH1fA', 'category_id' => '2'],
            ['title' => 'Cara memberikan ASI Perah dengan sendok', 'content' => 'Berikut adalah video pembelajaran tentang Cara memberikan ASI Perah dengan sendok https://youtu.be/eKLyauvqxnY', 'category_id' => '2'],
            ['title' => 'Cara memberikan ASI Perah dengan botol', 'content' => 'Berikut adalah video pembelajaran tentang Cara memberikan ASI Perah dengan botol https://youtu.be/dqIxkSFENQw', 'category_id' => '2'],
            ['title' => 'Perawatan Metode Kanguru', 'content' => 'Berikut adalah video pembelajaran tentang Perawatan Metode Kanguru https://youtu.be/twYgLguIBAc', 'category_id' => '3'],
            ['title' => 'Cara pengukuran suhu axila', 'content' => 'Berikut adalah video pembelajaran tentang Cara pengukuran suhu axila https://youtu.be/kmR__j3DCiQ', 'category_id' => '3'],
        ]);
    }
}
