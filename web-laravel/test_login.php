<?php
// Test login verification tanpa Laravel
$db_host = 'localhost';
$db_name = 'perikanan';
$db_user = 'root';
$db_pass = '';

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "=== LOGIN TEST ===\n\n";

    // Get admin_pusat user
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute(['admin_pusat']);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        echo "❌ User tidak ditemukan!\n";
        exit;
    }

    echo "✓ User ditemukan: " . $user['nama'] . "\n";
    echo "  Role: " . $user['role'] . "\n";
    echo "  Username: " . $user['username'] . "\n";
    echo "  Password hash di database: " . substr($user['password'], 0, 50) . "...\n\n";

    // Test password
    $test_password = 'rahasia123';
    $stored_hash = $user['password'];

    // Check if it's bcrypt hash
    if (preg_match('/^\$2[ayb]\$.{56}$/', $stored_hash)) {
        echo "✓ Password menggunakan bcrypt hash\n";
        $match = password_verify($test_password, $stored_hash);
    } else {
        echo "✓ Password adalah plain text\n";
        $match = hash_equals($test_password, $stored_hash);
    }

    if ($match) {
        echo "✓ Password SESUAI! Login akan berhasil.\n";
        echo "\n📝 Login credentials yang benar:\n";
        echo "   Username: admin_pusat\n";
        echo "   Password: rahasia123\n";
    } else {
        echo "❌ Password TIDAK sesuai!\n";
    }

    echo "\n=== DATABASE STATUS ===\n";
    $result = $pdo->query("SELECT COUNT(*) as total FROM users");
    $count = $result->fetch()['total'];
    echo "Total users di database: " . $count . "\n";

    $result = $pdo->query("SELECT username, role FROM users");
    $users = $result->fetchAll(PDO::FETCH_ASSOC);
    echo "\nDaftar users:\n";
    foreach ($users as $u) {
        echo "  - " . $u['username'] . " (" . $u['role'] . ")\n";
    }
} catch (PDOException $e) {
    echo "❌ Database Error: " . $e->getMessage();
}
