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
                'registration_number' => 'ABC1234',
                'image' => 'images/bas1.jpg',
                'description' => 'A comfortable sedan with advanced features.'
            ],
            [
                'name' => 'Bas2',
                'type' => 'bas',
                'registration_number' => 'ABC1235',
                'image' => 'images/bas2.jpg',
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
                'registration_number' => 'ABC1237',
                'image' => 'images/kereta.jpg',
                'description' => 'A spacious bus for large groups.'
            ],

            [
                'name' => 'Van 1',
                'type' => 'van',
                'registration_number' => 'ABC1238',
                'image' => 'images/van.jpg',
                'description' => 'A spacious bus for large groups.'
            ],
            // Add more vehicle data as needed
        ];

        DB::table('vehicles')->insert($vehicles);
    }
}
