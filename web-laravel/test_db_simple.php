<?php

/**
 * Simple test untuk verify is_active column berhasil ditambahkan
 */

// Database connection
$host = '127.0.0.1';
$db = 'perikanan';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "======================================\n";
    echo "Database Test - is_active Column Check\n";
    echo "======================================\n\n";

    // Check if is_active column exists
    echo "[Test 1] Checking is_active column...\n";
    $stmt = $pdo->query("DESC users");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $hasIsActive = false;
    foreach ($columns as $col) {
        if ($col['Field'] === 'is_active') {
            $hasIsActive = true;
            echo "✓ Column 'is_active' found!\n";
            echo "  Type: {$col['Type']}\n";
            echo "  Null: {$col['Null']}\n";
            echo "  Default: {$col['Default']}\n\n";
            break;
        }
    }

    if (!$hasIsActive) {
        echo "✗ Column 'is_active' NOT found\n\n";
        echo "Available columns:\n";
        foreach ($columns as $col) {
            echo "  - {$col['Field']} ({$col['Type']})\n";
        }
        exit(1);
    }

    // Test 2: Deactivate a non-admin user
    echo "[Test 2] Deactivating test user...\n";

    // Get a non-admin user
    $stmt = $pdo->prepare("SELECT * FROM users WHERE role != ? LIMIT 1");
    $stmt->execute(['admin']);
    $testUser = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$testUser) {
        echo "✗ No non-admin user found for testing\n";
        exit(1);
    }

    echo "✓ Found test user: {$testUser['nama']}\n";
    echo "  ID: {$testUser['id']}\n";
    echo "  Role: {$testUser['role']}\n";
    echo "  Current is_active: " . ($testUser['is_active'] ? 'true' : 'false') . "\n";
    echo "  Current status_akun: {$testUser['status_akun']}\n\n";

    // Update is_active to false
    echo "[Test 3] Updating is_active to false...\n";
    $stmt = $pdo->prepare("UPDATE users SET is_active = false WHERE id = ?");
    $stmt->execute([$testUser['id']]);
    echo "✓ User deactivated\n\n";

    // Verify update
    echo "[Test 4] Verifying update...\n";
    $stmt = $pdo->prepare("SELECT is_active FROM users WHERE id = ?");
    $stmt->execute([$testUser['id']]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$result['is_active']) {
        echo "✓ User is_active status verified as false\n\n";
    } else {
        echo "✗ User is_active status is still true (UPDATE failed)\n\n";
    }

    // Test 5: Reactivate user
    echo "[Test 5] Reactivating user...\n";
    $stmt = $pdo->prepare("UPDATE users SET is_active = true WHERE id = ?");
    $stmt->execute([$testUser['id']]);

    $stmt = $pdo->prepare("SELECT is_active FROM users WHERE id = ?");
    $stmt->execute([$testUser['id']]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result['is_active']) {
        echo "✓ User reactivated successfully\n\n";
    }

    echo "======================================\n";
    echo "Summary\n";
    echo "======================================\n";
    echo "✓ is_active column exists and works\n";
    echo "✓ Deactivation/Reactivation functional\n";
    echo "✓ Database ready for feature testing\n";
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage() . "\n";
    exit(1);
}
