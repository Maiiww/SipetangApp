<?php

$host = '127.0.0.1';
$db = 'perikanan';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "========== INFORMASI KONEKSI DATABASE ==========\n";
    echo "Host: $host\n";
    echo "Database: $db\n";
    echo "User: $user\n\n";
    
    echo "========== STRUKTUR TABEL 'laporan' ==========\n";
    echo "Field                Type               Null  Key  Default              Extra\n";
    echo "---                  ---                ----  ---  -------              -----\n";
    
    $columns = $pdo->query("DESCRIBE laporan")->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($columns as $col) {
        $field = str_pad($col['Field'], 20);
        $type = str_pad($col['Type'], 18);
        $null = str_pad($col['Null'], 5);
        $key = str_pad($col['Key'] ?? '', 4);
        $default = str_pad($col['Default'] ?? 'NULL', 20);
        $extra = $col['Extra'] ?? '';
        
        echo "$field $type $null $key $default $extra\n";
    }
    
    echo "\n========== STATUS KOLOM 'status' ==========\n";
    $statusCol = array_filter($columns, fn($c) => $c['Field'] === 'status');
    if (!empty($statusCol)) {
        echo "✓ Kolom 'status' DITEMUKAN\n";
        $status = reset($statusCol);
        echo "  Type: " . $status['Type'] . "\n";
        echo "  Nullable: " . $status['Null'] . "\n";
        echo "  Default: " . ($status['Default'] ?? 'NONE') . "\n";
    } else {
        echo "✗ Kolom 'status' TIDAK DITEMUKAN\n";
    }
    
    echo "\n========== DAFTAR SEMUA KOLOM ==========\n";
    foreach ($columns as $i => $col) {
        echo ($i+1) . ". " . $col['Field'] . " (" . $col['Type'] . ")\n";
    }
    
    echo "\n========== SAMPLE DATA (5 BARIS PERTAMA) ==========\n";
    $data = $pdo->query("SELECT * FROM laporan LIMIT 5")->fetchAll(PDO::FETCH_ASSOC);
    
    if (empty($data)) {
        echo "Tabel laporan kosong (tidak ada data)\n";
    } else {
        echo "Total kolom: " . count($data[0]) . "\n";
        echo "Menampilkan 5 baris pertama:\n\n";
        
        foreach ($data as $idx => $row) {
            echo "--- ROW " . ($idx+1) . " ---\n";
            foreach ($row as $key => $val) {
                echo sprintf("  %-20s: %s\n", $key, $val ?? 'NULL');
            }
            echo "\n";
        }
    }
    
    echo "========== JUMLAH TOTAL DATA ==========\n";
    $count = $pdo->query("SELECT COUNT(*) as total FROM laporan")->fetch(PDO::FETCH_ASSOC);
    echo "Total baris di tabel laporan: " . $count['total'] . "\n";
    
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
