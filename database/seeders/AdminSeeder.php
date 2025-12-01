<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Service;
use Illuminate\Support\Facades\Hash;

public function run(): void
{
   
    User::create([
        'name' => 'Super Admin',
        'email' => 'admin@sca.com',
        'password' => Hash::make('password'), 
        'role' => 'admin',
        'phone' => '081234567890'
    ]);


    User::create([
        'name' => 'Djibril User',
        'email' => 'user@sca.com',
        'password' => Hash::make('password'),
        'role' => 'user',
        'phone' => '08987654321'
    ]);


    Service::insert([
        ['name' => 'Cuci Reguler', 'price' => 6000, 'unit' => '/kg'],
        ['name' => 'Cuci Kering', 'price' => 4000, 'unit' => '/kg'],
        ['name' => 'Cuci Express', 'price' => 9000, 'unit' => '/kg'],
        ['name' => 'Setrika Saja', 'price' => 5000, 'unit' => '/kg'],
    ]);
}