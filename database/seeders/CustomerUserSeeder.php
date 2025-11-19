<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CustomerUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create sample customer users
        User::create([
            'name' => 'John Customer',
            'email' => 'customer@example.com',
            'password' => Hash::make('password123'),
            'status' => 'aktif',
            'roles' => 'customer',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Jane Smith',
            'email' => 'jane.customer@example.com',
            'password' => Hash::make('password123'),
            'status' => 'aktif',
            'roles' => 'customer',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Bob Wilson',
            'email' => 'bob.customer@example.com',
            'password' => Hash::make('password123'),
            'status' => 'aktif',
            'roles' => 'customer',
            'email_verified_at' => now(),
        ]);

        // Create an admin user for comparison
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('admin123'),
                'status' => 'aktif',
                'roles' => 'admin',
                'email_verified_at' => now(),
            ]
        );
    }
}
