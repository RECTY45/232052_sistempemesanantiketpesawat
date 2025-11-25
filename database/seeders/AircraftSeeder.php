<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Aircraft;
use App\Models\Airline;

class AircraftSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $airlines = Airline::all();
        
        $aircraftData = [
            // Garuda Indonesia Aircraft
            [
                'airline_id' => $airlines->where('name', 'Garuda Indonesia')->first()->id ?? 1,
                'model' => 'Boeing 737-800',
                'registration' => 'PK-GFE',
                'economy_seats' => 150,
                'business_seats' => 20,
                'first_class_seats' => 8,
                'total_seats' => 178,
                'is_active' => true,
                'description' => 'Wide-body aircraft for long-haul flights'
            ],
            [
                'airline_id' => $airlines->where('name', 'Garuda Indonesia')->first()->id ?? 1,
                'model' => 'Boeing 777-300ER',
                'registration' => 'PK-GIG',
                'economy_seats' => 268,
                'business_seats' => 38,
                'first_class_seats' => 8,
                'total_seats' => 314,
                'is_active' => true,
                'description' => 'Long-range wide-body aircraft'
            ],
            [
                'airline_id' => $airlines->where('name', 'Garuda Indonesia')->first()->id ?? 1,
                'model' => 'Airbus A330-300',
                'registration' => 'PK-GPA',
                'economy_seats' => 222,
                'business_seats' => 36,
                'first_class_seats' => 6,
                'total_seats' => 264,
                'is_active' => true,
                'description' => 'Wide-body aircraft for medium to long-haul routes'
            ],

            // Lion Air Aircraft
            [
                'airline_id' => $airlines->where('name', 'Lion Air')->first()->id ?? 2,
                'model' => 'Boeing 737-900ER',
                'registration' => 'PK-LPE',
                'economy_seats' => 189,
                'business_seats' => 12,
                'first_class_seats' => 0,
                'total_seats' => 201,
                'is_active' => true,
                'description' => 'Single-aisle aircraft for domestic and short-haul international flights'
            ],
            [
                'airline_id' => $airlines->where('name', 'Lion Air')->first()->id ?? 2,
                'model' => 'Boeing 737-800',
                'registration' => 'PK-LQG',
                'economy_seats' => 189,
                'business_seats' => 0,
                'first_class_seats' => 0,
                'total_seats' => 189,
                'is_active' => true,
                'description' => 'All-economy configuration for budget-friendly travel'
            ],
            [
                'airline_id' => $airlines->where('name', 'Lion Air')->first()->id ?? 2,
                'model' => 'Airbus A320',
                'registration' => 'PK-LUF',
                'economy_seats' => 180,
                'business_seats' => 0,
                'first_class_seats' => 0,
                'total_seats' => 180,
                'is_active' => true,
                'description' => 'Narrow-body aircraft for short to medium-haul routes'
            ],

            // Citilink Aircraft
            [
                'airline_id' => $airlines->where('name', 'Citilink')->first()->id ?? 3,
                'model' => 'Airbus A320',
                'registration' => 'PK-GQD',
                'economy_seats' => 180,
                'business_seats' => 0,
                'first_class_seats' => 0,
                'total_seats' => 180,
                'is_active' => true,
                'description' => 'Low-cost carrier aircraft'
            ],
            [
                'airline_id' => $airlines->where('name', 'Citilink')->first()->id ?? 3,
                'model' => 'Airbus A320neo',
                'registration' => 'PK-GTB',
                'economy_seats' => 180,
                'business_seats' => 0,
                'first_class_seats' => 0,
                'total_seats' => 180,
                'is_active' => true,
                'description' => 'Fuel-efficient narrow-body aircraft'
            ],

            // Batik Air Aircraft
            [
                'airline_id' => $airlines->where('name', 'Batik Air')->first()->id ?? 4,
                'model' => 'Boeing 737-800',
                'registration' => 'PK-LBG',
                'economy_seats' => 162,
                'business_seats' => 12,
                'first_class_seats' => 0,
                'total_seats' => 174,
                'is_active' => true,
                'description' => 'Full-service narrow-body aircraft'
            ],
            [
                'airline_id' => $airlines->where('name', 'Batik Air')->first()->id ?? 4,
                'model' => 'Airbus A320',
                'registration' => 'PK-LAS',
                'economy_seats' => 156,
                'business_seats' => 12,
                'first_class_seats' => 0,
                'total_seats' => 168,
                'is_active' => true,
                'description' => 'Premium economy and business class configuration'
            ],

            // Sriwijaya Air Aircraft
            [
                'airline_id' => $airlines->where('name', 'Sriwijaya Air')->first()->id ?? 5,
                'model' => 'Boeing 737-500',
                'registration' => 'PK-CKD',
                'economy_seats' => 130,
                'business_seats' => 8,
                'first_class_seats' => 0,
                'total_seats' => 138,
                'is_active' => true,
                'description' => 'Older generation Boeing for domestic routes'
            ],
            [
                'airline_id' => $airlines->where('name', 'Sriwijaya Air')->first()->id ?? 5,
                'model' => 'Boeing 737-300',
                'registration' => 'PK-CJJ',
                'economy_seats' => 149,
                'business_seats' => 0,
                'first_class_seats' => 0,
                'total_seats' => 149,
                'is_active' => true,
                'description' => 'Classic Boeing aircraft for regional routes'
            ]
        ];

        foreach ($aircraftData as $aircraft) {
            Aircraft::create($aircraft);
        }

        $this->command->info('Aircraft seeded successfully!');
    }
}
