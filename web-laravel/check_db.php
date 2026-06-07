<?php
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

echo "=== DB CHECK ===\n";

// Check users
echo "SELECT * FROM users LIMIT 5:\n";
$result = $db->query('SELECT id,username,role,wilayah FROM users LIMIT 5');
foreach ($result as $row) {
    echo "  ID:{$row[0]} | User:{$row[1]} | Role:{$row[2]} | TPI:{$row[3]}\n";
}

// Check tangkapan status distribution
echo "\nTangkapan by status:\n";
$result = $db->query('SELECT status, COUNT(*) as cnt FROM hasil_tangkap GROUP BY status');
foreach ($result as $row) {
    echo "  {$row[0]}: {$row[1]}\n";
}

// Check recent tangkapan
echo "\nLatest tangkapan:\n";
$result = $db->query('SELECT t.id, t.user_id, t.status, t.jenis_ikan, u.username, u.wilayah FROM hasil_tangkap t LEFT JOIN users u ON t.user_id=u.id ORDER BY t.created_at DESC LIMIT 5');
foreach ($result as $row) {
    echo "  ID:{$row[0]} | UID:{$row[1]} | Status:{$row[2]} | Fish:{$row[3]} | User:{$row[4]} | TPI:{$row[5]}\n";
}
