<?php

require __DIR__ . '/vendor/autoload.php';

$app = require __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Laporan;

// Test insert with generated ID
try {
    $laporan = Laporan::create([
        'idLaporan' => 'LPR-20260507-00001',
        'idUser' => 'USR001',
        'namaTPI' => 'TPI Muara Angke',
        'jenisIkan' => 'Tuna',
        'beratTotal' => 5.25,
        'tanggalTangkap' => date('Y-m-d'),
        'tanggalInput' => now(),
        'status' => 'pending',
        'catatan' => 'Test berhasil'
    ]);

    echo "✓ Insert berhasil! ID: " . $laporan->idLaporan . "\n";
    echo "✓ Laporan untuk user: " . $laporan->idUser . "\n";
    echo "✓ TPI: " . $laporan->namaTPI . "\n";
    echo "✓ Jenis Ikan: " . $laporan->jenisIkan . "\n";
    echo "✓ Berat: " . $laporan->beratTotal . " ton\n";
    echo "✓ Status: " . $laporan->status . "\n";
} catch (Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
}
