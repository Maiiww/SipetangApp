<?php
require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;

// Get all users to see what we have
$users = User::where('role', 'juruRekap')->get();

echo "===== CHECKING USERS =====\n\n";
foreach ($users as $user) {
    echo "Name: {$user->nama}\n";
    echo "No Induk: {$user->no_induk}\n";
    echo "ID: {$user->id}\n";
    echo "---\n";
}

echo "\nTotal users found: " . count($users) . "\n";
