<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CreateTestUsersSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create seller account
        User::create([
            'name' => 'Aditya Budi',
            'email' => 'aditya.budi@ui.ac.id',
            'username' => 'aditya.budi',
            'phone' => '08121111111',
            'password' => bcrypt('w4hy0n01'),
            'role' => 'penjual',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        // Create buyer account
        User::create([
            'name' => 'Aditya Abimata',
            'email' => 'aditya.abimata@gmail.com',
            'username' => 'aditya.abimata',
            'phone' => '08122222222',
            'password' => bcrypt('w4hy0n02'),
            'role' => 'pembeli',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);
    }
}
