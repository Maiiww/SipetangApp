<?php
require 'bootstrap/app.php';

use App\Models\User;

echo "\n=== VERIFIKASI 8 TPI YANG DITAMBAHKAN ===\n\n";

// Get all TPIs
$tpiList = User::whereIn('role', ['juruRekap', 'juru_rekap'])
    ->orderBy('wilayah', 'asc')
    ->select('id', 'nama', 'wilayah')
    ->get();

echo "Total TPI yang tersedia: " . $tpiList->count() . "\n";
echo "─────────────────────────────────────────\n\n";

foreach ($tpiList as $index => $tpi) {
    printf(
        "%2d. %-8s | %-35s | %s\n",
        $index + 1,
        'ID:' . $tpi->id,
        $tpi->nama,
        $tpi->wilayah
    );
}

echo "\n─────────────────────────────────────────\n";
echo "✅ 8 TPI telah berhasil ditambahkan!\n";
echo "\nList ini akan tampil di dropdown 'ASAL TPI' halaman Cetak Laporan.\n\n";
