<?php
require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Log;

// Users to delete based on screenshot (Juru Rekap users)
$userNoInduk = ['JR01', 'JR02', 'JR03', 'JR06', 'JR07', 'JR08', 'JR09', 'JR10'];

echo "===== DELETING USERS =====\n\n";

$deletedCount = 0;
foreach ($userNoInduk as $noInduk) {
    $user = User::where('no_induk', $noInduk)->first();

    if ($user) {
        echo "Deleting: {$user->nama} ({$user->no_induk})...\n";
        $user->delete();
        $deletedCount++;
        echo "✓ Deleted successfully\n";
    } else {
        echo "✗ User not found: {$noInduk}\n";
    }
}

echo "\n===== SUMMARY =====\n";
echo "Total deleted: {$deletedCount} users\n";
echo "Done!\n";
