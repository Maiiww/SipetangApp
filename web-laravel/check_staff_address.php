<?php
require_once 'vendor/autoload.php';

// Load Laravel environment
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;

// Check staff_tpi user
$user = User::where('username', 'staff_tpi')->first();

if ($user) {
    echo "User: " . $user->nama . "\n";
    echo "Username: " . $user->username . "\n";
    echo "Alamat: " . $user->alamat . "\n";
    echo "Status: " . $user->status_akun . "\n";
} else {
    echo "User staff_tpi tidak ditemukan\n";
}
