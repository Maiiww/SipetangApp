<?php
// Script untuk check struktur tabel laporan

require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=== STRUKTUR TABEL LAPORAN ===\n\n";

try {
    $columns = DB::select("SELECT COLUMN_NAME, COLUMN_TYPE, IS_NULLABLE, COLUMN_DEFAULT FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'laporan' AND TABLE_SCHEMA = 'perikanan'");

    if (empty($columns)) {
        echo "Tabel laporan tidak ditemukan!\n";
    } else {
        echo sprintf("%-20s | %-25s | %-10s | %-15s\n", "COLUMN", "TYPE", "NULLABLE", "DEFAULT");
        echo str_repeat("-", 75) . "\n";

        foreach ($columns as $column) {
            echo sprintf(
                "%-20s | %-25s | %-10s | %-15s\n",
                $column->COLUMN_NAME,
                $column->COLUMN_TYPE,
                $column->IS_NULLABLE,
                $column->COLUMN_DEFAULT ?? 'NULL'
            );
        }
    }

    echo "\n\n=== SAMPLE DATA ===\n";
    $data = DB::table('laporan')->limit(3)->get();
    echo "Total records: " . DB::table('laporan')->count() . "\n";
    foreach ($data as $row) {
        echo json_encode((array)$row, JSON_UNESCAPED_SLASHES) . "\n";
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
