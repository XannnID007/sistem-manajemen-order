<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin
        User::create([
            'name' => 'Admin Pangkalan',
            'email' => 'admin@gmail.com',
            'nik' => '3174010101900001',
            'phone' => '081234567890',
            'address' => 'Jl. Pangkalan No. 1, Jakarta',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // Create Sample Customer
        User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@gmail.com',
            'nik' => '3174010101900002',
            'phone' => '081234567891',
            'address' => 'Jl. Customer No. 1, Jakarta',
            'password' => Hash::make('customer123'),
            'role' => 'customer',
        ]);

        // Create Settings
        Setting::create([
            'pangkalan_name' => 'Pangkalan LPG Sejahtera',
            'pangkalan_address' => 'Jl. Raya Pangkalan No. 123, Jakarta Selatan',
            'pangkalan_phone' => '021-12345678',
            'price_per_unit' => 20000,
        ]);
    }
}
