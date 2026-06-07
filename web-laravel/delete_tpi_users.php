<?php
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;

// User-user yang akan dihapus berdasarkan screenshot
$tpiNamesToDelete = [
    'Patimban',
    'Genteng',
    'Mayangan',
    'Cirewang',
    'Muara Ciasem',
    'Blanakan',
    'Rawameneng',
    'Cilamaya Girang'
];

echo "=== DELETE TPI USERS ===\n\n";

foreach ($tpiNamesToDelete as $tpiName) {
    $deletedCount = User::where('wilayah', $tpiName)
        ->where('role', 'juruRekap')
        ->delete();

    if ($deletedCount > 0) {
        echo "✓ Deleted $deletedCount user(s) for TPI: $tpiName\n";
    } else {
        echo "✗ No users found for TPI: $tpiName\n";
    }
}

echo "\n=== Deletion Complete ===\n";
