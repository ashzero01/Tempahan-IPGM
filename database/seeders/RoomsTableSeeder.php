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
            ['name' => 'Dewan Wawasan', 'description' => 'dewan', 'image' => 'dewanwawasan.jpg'],
            ['name' => 'Dewan Bakti', 'description' => 'dewan', 'image' => 'dewanbakti.jpg'],
            ['name' => 'Dewan Kuliah K39', 'description' => 'dewan', 'image' => 'dewankuliahk39.jpg'],
            ['name' => 'Dewan Gerko', 'description' => 'dewan', 'image' => 'dewangerko.jpg'],
            ['name' => 'Bilik Seminar(DK3)', 'description' => 'bilik', 'image' => 'bilikseminar(dk3).jpg'],
            ['name' => 'Dewan Asrama', 'description' => 'dewan', 'image' => 'dewanasrama.jpg'],
            ['name' => 'Dewan KDP', 'description' => 'dewan', 'image' => 'dewankdp.jpg'],
            ['name' => 'Bilik Mesy. Gerakan', 'description' => 'bilik', 'image' => 'bilikgerakan.jpg'],
            ['name' => 'Bilik Kuliah Mahpoor Baba', 'description' => 'bilik', 'image' => 'bilikkuliahmahpoorbaba.jpg'],
        ]);
    }
}
