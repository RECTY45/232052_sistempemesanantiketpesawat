<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Flight;
use App\Models\Aircraft;
use App\Models\Airport;
use App\Models\Airline;
use Carbon\Carbon;

class FlightSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $flightData = [];
        $baseDate = Carbon::today()->addDay();

        // Simple approach - use existing IDs
        // Assuming: airlines 1-6, airports 1-10, aircraft 1-12
        
        // Generate flights for the next 10 days
        for ($day = 0; $day < 10; $day++) {
            $currentDate = $baseDate->copy()->addDays($day);
            
            // Jakarta (CGK=1) - Denpasar (DPS=2) Routes
            $flightData[] = [
                'flight_number' => 'GA401' . str_pad($day, 2, '0', STR_PAD_LEFT),
                'airline_id' => 1, // Garuda Indonesia
                'aircraft_id' => 1,
                'departure_airport_id' => 1, // CGK
                'arrival_airport_id' => 2, // DPS
                'departure_time' => $currentDate->copy()->setTime(6, 0, 0),
                'arrival_time' => $currentDate->copy()->setTime(9, 15, 0),
                'duration_minutes' => 195,
                'economy_price' => 1200000,
                'business_price' => 2400000,
                'first_class_price' => 4800000,
                'available_economy_seats' => 150,
                'available_business_seats' => 20,
                'available_first_class_seats' => 8,
                'status' => 'scheduled',
                'gate' => 'A1',
                'is_active' => true
            ];

            $flightData[] = [
                'flight_number' => 'JT710' . str_pad($day, 2, '0', STR_PAD_LEFT),
                'airline_id' => 2, // Lion Air
                'aircraft_id' => 4,
                'departure_airport_id' => 1, // CGK
                'arrival_airport_id' => 2, // DPS
                'departure_time' => $currentDate->copy()->setTime(14, 30, 0),
                'arrival_time' => $currentDate->copy()->setTime(17, 45, 0),
                'duration_minutes' => 195,
                'economy_price' => 950000,
                'business_price' => 1900000,
                'first_class_price' => 0,
                'available_economy_seats' => 189,
                'available_business_seats' => 12,
                'available_first_class_seats' => 0,
                'status' => 'scheduled',
                'gate' => 'B3',
                'is_active' => true
            ];

            // Jakarta (CGK=1) - Surabaya (SUB=3) Routes
            $flightData[] = [
                'flight_number' => 'GA205' . str_pad($day, 2, '0', STR_PAD_LEFT),
                'airline_id' => 1, // Garuda Indonesia
                'aircraft_id' => 3,
                'departure_airport_id' => 1, // CGK
                'arrival_airport_id' => 3, // SUB
                'departure_time' => $currentDate->copy()->setTime(8, 15, 0),
                'arrival_time' => $currentDate->copy()->setTime(10, 30, 0),
                'duration_minutes' => 135,
                'economy_price' => 800000,
                'business_price' => 1600000,
                'first_class_price' => 3200000,
                'available_economy_seats' => 222,
                'available_business_seats' => 36,
                'available_first_class_seats' => 6,
                'status' => 'scheduled',
                'gate' => 'C2',
                'is_active' => true
            ];

            // Jakarta (CGK=1) - Malang (MLG=10) Routes
            $flightData[] = [
                'flight_number' => 'ID720' . str_pad($day, 2, '0', STR_PAD_LEFT),
                'airline_id' => 4, // Batik Air
                'aircraft_id' => 9,
                'departure_airport_id' => 1, // CGK
                'arrival_airport_id' => 10, // MLG
                'departure_time' => $currentDate->copy()->setTime(10, 45, 0),
                'arrival_time' => $currentDate->copy()->setTime(12, 15, 0),
                'duration_minutes' => 90,
                'economy_price' => 750000,
                'business_price' => 1500000,
                'first_class_price' => 0,
                'available_economy_seats' => 162,
                'available_business_seats' => 12,
                'available_first_class_seats' => 0,
                'status' => 'scheduled',
                'gate' => 'D1',
                'is_active' => true
            ];

            // Return flights
            $flightData[] = [
                'flight_number' => 'GA402' . str_pad($day, 2, '0', STR_PAD_LEFT),
                'airline_id' => 1, // Garuda Indonesia
                'aircraft_id' => 2,
                'departure_airport_id' => 2, // DPS
                'arrival_airport_id' => 1, // CGK
                'departure_time' => $currentDate->copy()->setTime(19, 30, 0),
                'arrival_time' => $currentDate->copy()->setTime(22, 45, 0),
                'duration_minutes' => 195,
                'economy_price' => 1250000,
                'business_price' => 2500000,
                'first_class_price' => 5000000,
                'available_economy_seats' => 268,
                'available_business_seats' => 38,
                'available_first_class_seats' => 8,
                'status' => 'scheduled',
                'gate' => 'F1',
                'is_active' => true
            ];
        }

        // Insert flight data
        foreach ($flightData as $flight) {
            Flight::create($flight);
        }

        $this->command->info('Flight schedules seeded successfully! Created ' . count($flightData) . ' flights.');
    }
}
