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
                'image' => 'images/dewanwawasan.jpg'
            ],
            [
                'name' => 'Dewan Bakti',
                'description' => 'dewan',
                'image' => 'images/dewanbakti.jpg'
            ],
            [
                'name' => 'Dewan Kuliah K39',
                'description' => 'dewan',
                'image' => 'images/dewankuliah(k39).jpg'
            ],
            [
                'name' => 'Dewan Gerko',
                'description' => 'dewan',
                'image' => 'images/dewangerko.jpg'
            ],
            [
                'name' => 'Bilik Seminar(DK3)',
                'description' => 'bilik',
                'image' => 'images/bilikseminar(dk3).jpg'
            ],
            [
                'name' => 'Dewan Asrama',
                'description' => 'dewan',
                'image' => 'images/dewanasrama.jpg'
            ],
            [
                'name' => 'Dewan KDP',
                'description' => 'dewan',
                'image' => 'images/dewankdp.jpg'
            ],
            [
                'name' => 'Bilik Mesy. Gerakan',
                'description' => 'bilik',
                'image' => 'images/bilikgerakan.jpg'
            ],
            [
                'name' => 'Bilik Kuliah Mahpoor Baba',
                'description' => 'bilik',
                'image' => 'images/bilikkuliahmahpoorbaba.jpg'
            ],
            [
                'name' => 'Bilik Mesy. Gigih',
                'description' => 'bilik',
                'image' => 'images/bilikgigih.jpg'
            ]
        ]);
    }
}
