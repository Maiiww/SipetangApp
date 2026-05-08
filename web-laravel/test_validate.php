<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Laporan;
use App\Models\User;

// Get the first pending laporan
$laporan = Laporan::where('status', 'pending')->first();
// Get a valid user
$user = User::first();

if ($laporan && $user) {
    echo "Laporan ditemukan: " . $laporan->idLaporan . " - Status: " . $laporan->status . "\n";
    echo "User: " . $user->username . "\n";

    $laporan->update([
        'status' => 'validated',
        'tanggalValidasi' => now(),
        'validasiOleh' => $user->username,
    ]);
    $laporan->refresh();
    echo "Status setelah update: " . $laporan->status . "\n";
    echo "Tanggal Validasi: " . $laporan->tanggalValidasi . "\n";
    echo "Validasi Oleh: " . $laporan->validasiOleh . "\n";
    echo "\nBerhasil! Laporan telah divalidasi.\n";
} else {
    echo "Tidak ada laporan pending atau user\n";
}
