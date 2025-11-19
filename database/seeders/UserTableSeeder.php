<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $testUsers = [
            [
                'name' => 'administrator',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('admin123'),
                'status' => 'aktif',
                'roles' => 'admin',
                'email_verified_at' => now(),
            ],
        ];

        foreach ($testUsers as $user) {
            User::create($user);
        }
    }
}
