<?php
$host = '127.0.0.1';
$db = 'perikanan';
$user_db = 'root';
$pass = '';
$pdo = new PDO("mysql:host=$host;dbname=$db", $user_db, $pass);

echo "=== Checking Menus Table ===\n\n";

// Check all menus
$stmt = $pdo->query("SELECT * FROM menus ORDER BY id");
$menus = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "Total menus: " . count($menus) . "\n\n";

foreach ($menus as $menu) {
    echo "ID: {$menu['id']}\n";
    echo "Title: {$menu['title']}\n";
    echo "Route: {$menu['route_name']}\n";
    echo "Role: {$menu['role']}\n";
    echo "Active: {$menu['is_active']}\n";
    echo "---\n";
}

echo "\n=== Checking for Duplicates ===\n";
$stmt = $pdo->query("SELECT title, role, COUNT(*) as count FROM menus GROUP BY title, role HAVING count > 1");
$duplicates = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (count($duplicates) > 0) {
    echo "Found duplicates:\n";
    foreach ($duplicates as $dup) {
        echo "  Title: {$dup['title']}, Role: {$dup['role']}, Count: {$dup['count']}\n";
    }
} else {
    echo "No duplicates found.\n";
}
