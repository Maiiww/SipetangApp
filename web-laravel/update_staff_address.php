<?php
// Direct database update without Laravel
$envFile = __DIR__ . '/.env';

// Parse .env file
$env = [];
if (file_exists($envFile)) {
    $lines = file($envFile);
    foreach ($lines as $line) {
        $line = trim($line);
        if (!empty($line) && $line[0] !== '#' && strpos($line, '=') !== false) {
            list($key, $value) = explode('=', $line, 2);
            $env[trim($key)] = trim($value, '\'"');
        }
    }
}

$host = $env['DB_HOST'] ?? 'localhost';
$user = $env['DB_USERNAME'] ?? 'root';
$pass = $env['DB_PASSWORD'] ?? '';
$db = $env['DB_DATABASE'] ?? '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);

    // Check current data
    $stmt = $pdo->prepare("SELECT nama, alamat FROM users WHERE username = ?");
    $stmt->execute(['staff_tpi']);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    echo "=== BEFORE UPDATE ===\n";
    if ($result) {
        echo "Nama: " . $result['nama'] . "\n";
        echo "Alamat: " . $result['alamat'] . "\n";
    } else {
        echo "User not found\n";
    }

    // Update alamat
    $updateStmt = $pdo->prepare("UPDATE users SET alamat = ? WHERE username = ?");
    $updateStmt->execute(['Kantor Dinas Perikanan Pusat, Subang', 'staff_tpi']);

    echo "\nUpdate executed.\n";

    // Check after update
    $stmt = $pdo->prepare("SELECT nama, alamat FROM users WHERE username = ?");
    $stmt->execute(['staff_tpi']);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    echo "\n=== AFTER UPDATE ===\n";
    if ($result) {
        echo "Nama: " . $result['nama'] . "\n";
        echo "Alamat: " . $result['alamat'] . "\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
