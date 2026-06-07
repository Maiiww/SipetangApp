<?php
require 'vendor/autoload.php';

// Load laravel environment
$app = require 'bootstrap/app.php';

// Get application instance
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

// Test 1: Check if there are validated reports
echo "=== TEST 1: Cek Laporan Tervalidasi ===\n";
$validatedCount = \App\Models\Tangkapan::where('status', 'Divalidasi')->count();
echo "Jumlah laporan dengan status 'Divalidasi': $validatedCount\n";

if ($validatedCount > 0) {
    $sample = \App\Models\Tangkapan::where('status', 'Divalidasi')->with('user')->first();
    echo "Sample: ID={$sample->id}, User={$sample->user?->nama}, Status={$sample->status}\n\n";
} else {
    echo "PERHATIAN: Tidak ada laporan dengan status 'Divalidasi'!\n";
    echo "Silakan validasi beberapa laporan terlebih dahulu.\n\n";
}

// Test 2: Check TPI list
echo "=== TEST 2: Cek Daftar TPI ===\n";
$tpiList = \App\Models\User::whereIn('role', ['juruRekap', 'juru_rekap'])
    ->orderBy('wilayah', 'asc')
    ->select('id', 'nama', 'wilayah')
    ->where('wilayah', '!=', null)
    ->distinct('wilayah')
    ->get();

echo "Jumlah TPI yang tersedia: " . $tpiList->count() . "\n";
foreach ($tpiList as $tpi) {
    $laporanCount = \App\Models\Tangkapan::where('user_id', $tpi->id)->where('status', 'Divalidasi')->count();
    echo "- ID: {$tpi->id}, Nama: {$tpi->nama}, Wilayah: {$tpi->wilayah}, Laporan Tervalidasi: $laporanCount\n";
}

echo "\n=== TEST 3: Filter Test ===\n";
if ($tpiList->count() > 0) {
    $firstTpi = $tpiList->first();
    $filtered = \App\Models\Tangkapan::where('user_id', $firstTpi->id)
        ->where('status', 'Divalidasi')
        ->get();
    echo "Filter by TPI ID {$firstTpi->id} ({$firstTpi->wilayah}): {$filtered->count()} laporan\n";
}

echo "\n=== TEST SELESAI ===\n";
echo "Jika semua test menunjukkan data, fitur download seharusnya bekerja.\n";
