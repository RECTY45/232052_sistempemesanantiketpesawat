<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Airport;

class AirportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $airports = [
            [
                'code' => 'CGK',
                'name' => 'Soekarno-Hatta International Airport',
                'city' => 'Jakarta',
                'country' => 'Indonesia',
                'latitude' => -6.1256,
                'longitude' => 106.6556,
                'timezone' => 'Asia/Jakarta',
                'is_active' => true
            ],
            [
                'code' => 'DPS',
                'name' => 'Ngurah Rai International Airport',
                'city' => 'Denpasar',
                'country' => 'Indonesia',
                'latitude' => -8.7481,
                'longitude' => 115.1672,
                'timezone' => 'Asia/Makassar',
                'is_active' => true
            ],
            [
                'code' => 'SUB',
                'name' => 'Juanda International Airport',
                'city' => 'Surabaya',
                'country' => 'Indonesia',
                'latitude' => -7.3797,
                'longitude' => 112.7869,
                'timezone' => 'Asia/Jakarta',
                'is_active' => true
            ],
            [
                'code' => 'UPG',
                'name' => 'Sultan Hasanuddin Airport',
                'city' => 'Makassar',
                'country' => 'Indonesia',
                'latitude' => -5.0619,
                'longitude' => 119.5544,
                'timezone' => 'Asia/Makassar',
                'is_active' => true
            ],
            [
                'code' => 'MDN',
                'name' => 'Kualanamu International Airport',
                'city' => 'Medan',
                'country' => 'Indonesia',
                'latitude' => 3.6422,
                'longitude' => 98.8853,
                'timezone' => 'Asia/Jakarta',
                'is_active' => true
            ],
            [
                'code' => 'YGY',
                'name' => 'Yogyakarta International Airport',
                'city' => 'Yogyakarta',
                'country' => 'Indonesia',
                'latitude' => -7.9006,
                'longitude' => 110.0519,
                'timezone' => 'Asia/Jakarta',
                'is_active' => true
            ],
            [
                'code' => 'PLM',
                'name' => 'Sultan Mahmud Badaruddin II Airport',
                'city' => 'Palembang',
                'country' => 'Indonesia',
                'latitude' => -2.9032,
                'longitude' => 104.6997,
                'timezone' => 'Asia/Jakarta',
                'is_active' => true
            ],
            [
                'code' => 'PKU',
                'name' => 'Sultan Syarif Kasim II Airport',
                'city' => 'Pekanbaru',
                'country' => 'Indonesia',
                'latitude' => 0.4606,
                'longitude' => 101.4447,
                'timezone' => 'Asia/Jakarta',
                'is_active' => true
            ],
            [
                'code' => 'BJM',
                'name' => 'Syamsudin Noor Airport',
                'city' => 'Banjarmasin',
                'country' => 'Indonesia',
                'latitude' => -3.4424,
                'longitude' => 114.7628,
                'timezone' => 'Asia/Makassar',
                'is_active' => true
            ],
            [
                'code' => 'MLG',
                'name' => 'Abdul Rachman Saleh Airport',
                'city' => 'Malang',
                'country' => 'Indonesia',
                'latitude' => -7.9258,
                'longitude' => 112.7144,
                'timezone' => 'Asia/Jakarta',
                'is_active' => true
            ]
        ];

        foreach ($airports as $airport) {
            Airport::create($airport);
        }
    }
}
