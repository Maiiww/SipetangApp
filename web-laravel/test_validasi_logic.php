<?php
// Quick test to verify ValidasiController logic
error_reporting(E_ALL);
ini_set('display_errors', 1);

$envPath = __DIR__ . '/.env';
if (file_exists($envPath)) {
    $lines = file($envPath);
    foreach ($lines as $line) {
        $line = trim($line);
        if (!empty($line) && strpos($line, '=') !== false && strpos($line, '#') === false) {
            list($key, $val) = explode('=', $line, 2);
            putenv($key . '=' . $val);
        }
    }
}

$db = new PDO(
    'mysql:host=' . getenv('DB_HOST') . ';dbname=' . getenv('DB_DATABASE'),
    getenv('DB_USERNAME'),
    getenv('DB_PASSWORD')
);

echo "=== TESTING VALIDASI LOGIC ===\n\n";

// Get staff user (ID 4)
$result = $db->query('SELECT id, username, wilayah FROM users WHERE id = 4');
$staff = $result->fetch(PDO::FETCH_ASSOC);
echo "Staff User: {$staff['username']} | wilayah: {$staff['wilayah']}\n";

// Test LIKE logic for "Pusat" check
$isPusat = strpos($staff['wilayah'], 'Pusat') !== false || strpos($staff['wilayah'], 'pusat') !== false;
echo "Is Pusat staff: " . ($isPusat ? 'YES' : 'NO') . "\n";

// Count records that should be visible
echo "\nRecords visible to this staff (using LIKE query):\n";
$sql = "SELECT t.id, t.jenis_ikan, t.status, u.username, u.wilayah 
        FROM hasil_tangkap t 
        LEFT JOIN users u ON t.user_id = u.id 
        WHERE t.status IN ('Draft', 'Menunggu Validasi', 'Divalidasi', 'Ditolak') 
        AND u.wilayah LIKE '%' || ? || '%'
        ORDER BY t.created_at DESC";

// For Pusat staff, they should see ALL records (no LIKE filter needed)
$sql2 = "SELECT t.id, t.jenis_ikan, t.status, u.username, u.wilayah 
        FROM hasil_tangkap t 
        LEFT JOIN users u ON t.user_id = u.id 
        WHERE t.status IN ('Draft', 'Menunggu Validasi', 'Divalidasi', 'Ditolak')
        ORDER BY t.created_at DESC";

$result = $db->query($sql2);
$count = 0;
foreach ($result as $row) {
    echo "  ID:{$row[0]} | Fish:{$row[1]} | Status:{$row[2]} | User:{$row[3]} | TPI:{$row[4]}\n";
    $count++;
}
echo "Total visible: $count\n";
