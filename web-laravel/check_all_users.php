<?php
require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;

// Get all users
$users = User::all();

echo "===== ALL USERS IN DATABASE =====\n\n";
foreach ($users as $user) {
    echo "Name: {$user->nama}\n";
    echo "Username: {$user->username}\n";
    echo "No Induk: {$user->no_induk}\n";
    echo "Role: {$user->role}\n";
    echo "ID: {$user->id}\n";
    echo "---\n";
}

echo "\nTotal users found: " . count($users) . "\n";
