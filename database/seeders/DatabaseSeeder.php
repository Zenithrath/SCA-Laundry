<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Service; // <--- WAJIB DITAMBAHKAN
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash; // <--- WAJIB DITAMBAHKAN

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. User Test (Optional, kalau tidak butuh bisa dihapus)
        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    
        // 2. Akun Admin Paten
        User::updateOrCreate(
            ['email' => 'admin@sca.com'], // Cek apakah email ini ada?
            [
                'name' => 'Admin',
                'password' => Hash::make('password'), 
                'role' => 'admin',
                'phone' => '081234567890'
            ]
        );

        // 3. Akun User Biasa
        User::updateOrCreate(
            ['email' => 'user@sca.com'], 
            [
                'name' => 'Djibril User',
                'password' => Hash::make('password'),
                'role' => 'user',
                'phone' => '08987654321'
            ]
        );

        // 4. Services (Daftar Layanan)
        // Saya ubah sedikit agar 'insert' bisa jalan (biasanya insert butuh array manual)
        // Kalau insertOrIgnore gagal, bisa ganti jadi upsert atau loop
        
        $services = [
            ['name' => 'Cuci Reguler', 'price' => 6000, 'unit' => '/kg'],
            ['name' => 'Cuci Kering', 'price' => 4000, 'unit' => '/kg'],
            ['name' => 'Cuci Express', 'price' => 9000, 'unit' => '/kg'],
            ['name' => 'Setrika Saja', 'price' => 5000, 'unit' => '/kg'],
        ];

        foreach ($services as $service) {
            Service::updateOrCreate(
                ['name' => $service['name']], // Cek berdasarkan nama layanan
                $service
            );
        }
    }
}