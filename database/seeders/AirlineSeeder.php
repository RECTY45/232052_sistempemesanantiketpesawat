<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Airline;

class AirlineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $airlines = [
            [
                'code' => 'GA',
                'name' => 'Garuda Indonesia',
                'description' => 'Maskapai penerbangan nasional Indonesia',
                'country' => 'Indonesia',
                'website' => 'https://www.garuda-indonesia.com',
                'phone' => '+62-804-1-807-807',
                'is_active' => true
            ],
            [
                'code' => 'JT',
                'name' => 'Lion Air',
                'description' => 'Maskapai penerbangan berbiaya rendah Indonesia',
                'country' => 'Indonesia',
                'website' => 'https://www.lionair.co.id',
                'phone' => '+62-21-6379-8000',
                'is_active' => true
            ],
            [
                'code' => 'ID',
                'name' => 'Batik Air',
                'description' => 'Maskapai penerbangan layanan penuh Indonesia',
                'country' => 'Indonesia',
                'website' => 'https://www.batikair.com',
                'phone' => '+62-21-6379-8000',
                'is_active' => true
            ],
            [
                'code' => 'QZ',
                'name' => 'AirAsia Indonesia',
                'description' => 'Maskapai penerbangan berbiaya rendah',
                'country' => 'Indonesia',
                'website' => 'https://www.airasia.com',
                'phone' => '+62-21-2927-0999',
                'is_active' => true
            ],
            [
                'code' => 'SJ',
                'name' => 'Sriwijaya Air',
                'description' => 'Maskapai penerbangan Indonesia',
                'country' => 'Indonesia',
                'website' => 'https://www.sriwijayaair.co.id',
                'phone' => '+62-21-2927-9777',
                'is_active' => true
            ],
            [
                'code' => 'IW',
                'name' => 'Wings Air',
                'description' => 'Maskapai penerbangan regional Indonesia',
                'country' => 'Indonesia',
                'website' => 'https://www.wingsair.com',
                'phone' => '+62-21-6379-8000',
                'is_active' => true
            ]
        ];

        foreach ($airlines as $airline) {
            Airline::create($airline);
        }
    }
}
