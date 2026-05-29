<?php

/**
 * Test deactivation feature via API endpoint
 * This simulates clicking the three-dot menu and selecting deactivate
 */

// Get CSRF token by fetching login page or session
$ch = curl_init('http://localhost/SipetangApp/web-laravel/public/login');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_COOKIEJAR, __DIR__ . '/cookies.txt');
$response = curl_exec($ch);

// Extract CSRF token from response
preg_match('/"csrf-token" content="([^"]+)"/', $response, $matches);
$csrfToken = $matches[1] ?? null;

if (!$csrfToken) {
    echo "Could not extract CSRF token\n";
    var_dump($response);
    exit(1);
}

echo "✓ Got CSRF token: " . substr($csrfToken, 0, 10) . "...\n";
echo "✓ Got cookies\n\n";

// Get test user ID
$ch = curl_init('http://localhost/SipetangApp/web-laravel/public/api/users');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_COOKIEFILE, __DIR__ . '/cookies.txt');
$response = curl_exec($ch);

// Try direct database query instead
$host = '127.0.0.1';
$db = 'perikanan';
$user_db = 'root';
$pass = '';
$pdo = new PDO("mysql:host=$host;dbname=$db", $user_db, $pass);

// Get a non-admin user to test
$stmt = $pdo->prepare("SELECT id FROM users WHERE role != ? LIMIT 1");
$stmt->execute(['admin']);
$testUser = $stmt->fetch(PDO::FETCH_ASSOC);
$userId = $testUser['id'];

echo "======================================\n";
echo "Testing Deactivation API Endpoint\n";
echo "======================================\n\n";

echo "[Test 1] Getting test user\n";
echo "✓ Test user ID: $userId\n\n";

echo "[Test 2] Sending deactivation request...\n";

// Send deactivation request
$ch = curl_init('http://localhost/SipetangApp/web-laravel/public/admin/user/update-status');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'X-CSRF-TOKEN: ' . $csrfToken,
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
    'user_id' => $userId,
    'is_active' => false,
]));
curl_setopt($ch, CURLOPT_COOKIEFILE, __DIR__ . '/cookies.txt');

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

echo "✓ Request sent\n";
echo "  HTTP Status: $httpCode\n";
echo "  Response: " . substr($response, 0, 100) . "...\n\n";

// Verify in database
echo "[Test 3] Verifying database update...\n";
$stmt = $pdo->prepare("SELECT is_active FROM users WHERE id = ?");
$stmt->execute([$userId]);
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$result['is_active']) {
    echo "✓ User successfully deactivated!\n";
} else {
    echo "✗ User still appears active in database\n";
}

echo "\n✓ API endpoint test complete\n";
