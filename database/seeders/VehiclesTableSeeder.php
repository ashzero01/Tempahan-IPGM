<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class VehiclesTableSeeder extends Seeder
{
    public function run()
    {
        $vehicles = [
            [
                'name' => 'Bas 1',
                'type' => 'bas',
                'registration_number' => 'BGJ 1263',
                'image' => 'images/bas1.jpg',
                'description' => 'A comfortable sedan with advanced features.'
            ],
            [
                'name' => 'Bas 2',
                'type' => 'bas',
                'registration_number' => 'ABC1235',
                'image' => 'images/bas1.jpg',
                'description' => 'A versatile van for various needs.'
            ],
            [
                'name' => 'Pajero 1',
                'type' => 'pajero',
                'registration_number' => 'ABC1236',
                'image' => 'images/pajero.jpg',
                'description' => 'A reliable SUV with great performance.'
            ],
            [
                'name' => 'Kereta 1',
                'type' => 'kereta',
                'registration_number' => 'DAY 674',
                'image' => 'images/kereta.jpg',
                'description' => 'A spacious bus for large groups.'
            ],

            [
                'name' => 'Van 1',
                'type' => 'van',
                'registration_number' => 'VFR 3802',
                'image' => 'images/van.jpg',
                'description' => 'A spacious bus for large groups.'
            ],

            [
                'name' => 'Coaster',
                'type' => 'mini bus',
                'registration_number' => 'ABC1239',
                'image' => 'images/coaster.jpg',
                'description' => 'A mini bus for medium groups.'
            ],
            // Add more vehicle data as needed
        ];

        DB::table('vehicles')->insert($vehicles);
    }
}
