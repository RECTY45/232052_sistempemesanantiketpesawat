<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\FlightClass;

class FlightClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $flightClasses = [
            [
                'name' => 'Economy',
                'code' => 'ECO',
                'description' => 'Kelas ekonomi dengan fasilitas standar',
                'amenities' => [
                    'Bagasi 20kg',
                    'Makanan ringan',
                    'Minuman',
                    'Entertainment system'
                ],
                'is_active' => true
            ],
            [
                'name' => 'Business',
                'code' => 'BUS',
                'description' => 'Kelas bisnis dengan fasilitas premium',
                'amenities' => [
                    'Bagasi 30kg',
                    'Makanan premium',
                    'Minuman premium',
                    'Kursi yang lebih luas',
                    'Priority check-in',
                    'Akses lounge',
                    'Entertainment system'
                ],
                'is_active' => true
            ],
            [
                'name' => 'First Class',
                'code' => 'FST',
                'description' => 'Kelas pertama dengan fasilitas mewah',
                'amenities' => [
                    'Bagasi 40kg',
                    'Makanan fine dining',
                    'Minuman premium unlimited',
                    'Kursi yang dapat direbahkan',
                    'Priority check-in',
                    'Akses lounge VIP',
                    'Personal entertainment system',
                    'Personal amenity kit'
                ],
                'is_active' => true
            ]
        ];

        foreach ($flightClasses as $class) {
            FlightClass::create($class);
        }
    }
}
