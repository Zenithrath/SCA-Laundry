<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder; // Jangan lupa import ini
use App\Models\User;
use App\Models\Service;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Admin
        User::updateOrCreate(
            ['email' => 'admin@sca.com'], // <--- KUNCI PENCARIAN (Cek email ini dulu)
            [
                'name' => 'Admin',
                'password' => Hash::make('password'), // <--- DATA YANG DIUPDATE/INSERT
                'role' => 'admin',
                'phone' => '081234567890'
            ]
        );

        // 2. Akun User (Gunakan updateOrCreate juga biar aman kalau di-seed 2x)
        User::updateOrCreate(
            ['email' => 'user@sca.com'], 
            [
                'name' => 'Djibril User',
                'password' => Hash::make('password'),
                'role' => 'user',
                'phone' => '08987654321'
            ]
        );


        Service::insertOrIgnore([
            ['name' => 'Cuci Reguler', 'price' => 6000, 'unit' => '/kg'],
            ['name' => 'Cuci Kering', 'price' => 4000, 'unit' => '/kg'],
            ['name' => 'Cuci Express', 'price' => 9000, 'unit' => '/kg'],
            ['name' => 'Setrika Saja', 'price' => 5000, 'unit' => '/kg'],
        ]);
    }
}