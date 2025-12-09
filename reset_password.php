<?php
require 'vendor/autoload.php';
require 'bootstrap/app.php';

use App\Models\User;
use Illuminate\Support\Facades\Hash;

$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$user = User::where('email', 'test@example.com')->first();
if ($user) {
    $user->password = Hash::make('password');
    $user->save();
    echo "Password reset untuk test@example.com ke 'password'\n";
} else {
    echo "User tidak ditemukan\n";
}
