<?php
require 'vendor/autoload.php';
require 'bootstrap/app.php';

use App\Models\User;

// Cek jumlah juru rekap
$count = User::where('role', 'juruRekap')->count();
echo "Total Juru Rekap: " . $count . "\n\n";

// Tampilkan semua juru rekap dengan wilayahnya
echo "Daftar Juru Rekap:\n";
echo str_repeat("-", 60) . "\n";

$users = User::where('role', 'juruRekap')
    ->orderBy('wilayah', 'asc')
    ->select('id', 'nama', 'wilayah', 'no_induk')
    ->get();

foreach ($users as $user) {
    echo "ID: " . str_pad($user->id, 3) . " | Nama: " . str_pad($user->nama, 30) . " | Wilayah: " . $user->wilayah . "\n";
}

echo str_repeat("-", 60) . "\n";
