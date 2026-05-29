<?php
$host = '127.0.0.1';
$db = 'perikanan';
$user_db = 'root';
$pass = '';
$pdo = new PDO("mysql:host=$host;dbname=$db", $user_db, $pass);

// Delete duplicate Manajemen User (keep ID 1, delete ID 2)
$stmt = $pdo->prepare("DELETE FROM menus WHERE id = 2");
$stmt->execute();

echo "✓ Deleted duplicate 'Manajemen User' entry (ID 2)\n";

// Verify
$stmt = $pdo->query("SELECT * FROM menus ORDER BY id");
$menus = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "\nRemaining menus:\n";
foreach ($menus as $menu) {
    echo "  - {$menu['title']}\n";
}
