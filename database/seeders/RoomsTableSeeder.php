<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('rooms')->insert([
            [
                'name' => 'Dewan Wawasan',
                'description' => 'dewan',
                'images' => json_encode([
                    'images/dewanwawasan.jpg',
                    'images/dewanwawasan2.jpg'
                ])
            ],
            ['name' => 'Dewan Bakti', 'description' => 'dewan', 'images' => json_encode(['images/dewanbakti.jpg','images/dewanbakti2.jpg'])],
            ['name' => 'Dewan Kuliah K39', 'description' => 'dewan', 'images' => json_encode(['images/dewankuliah(k39).jpg','images/dewankuliah(k39)2.jpg'])],
            ['name' => 'Dewan Gerko', 'description' => 'dewan', 'images' => json_encode(['images/dewangerko.jpg','images/dewangerko2.jpg'])],
            ['name' => 'Bilik Seminar(DK3)', 'description' => 'bilik', 'images' => json_encode(['images/bilikseminar(dk3).jpg','images/bilikseminar(dk3)2.jpg'])],
            ['name' => 'Dewan Asrama', 'description' => 'dewan', 'images' => json_encode(['images/dewanasrama.jpg','images/dewanasrama2.jpg'])],
            ['name' => 'Dewan KDP', 'description' => 'dewan', 'images' => json_encode(['images/dewankdp.jpg','images/dewankdp2.jpg'])],
            ['name' => 'Bilik Mesy. Gerakan', 'description' => 'bilik', 'images' => json_encode(['images/bilikgerakan.jpg','images/bilikgerakan2.jpg'])],
            ['name' => 'Bilik Kuliah Mahpoor Baba', 'description' => 'bilik', 'images' => json_encode(['images/bilikkuliahmahpoorbaba.jpg','images/bilikkuliahmahpoorbaba2.jpg'])],
        ]);
    }
}
