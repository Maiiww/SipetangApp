<?php
error_reporting(0);
ini_set('display_errors', 0);

// Read .env
$envFile = dirname(__FILE__) . '/.env';
$db_host = '';
$db_user = '';
$db_pass = '';
$db_name = '';

if (file_exists($envFile)) {
    $lines = file($envFile);
    foreach ($lines as $line) {
        if (strpos($line, 'DB_HOST=') === 0) {
            $db_host = trim(str_replace('DB_HOST=', '', $line), " \t\n\r\0\x0B'\"");
        }
        if (strpos($line, 'DB_USERNAME=') === 0) {
            $db_user = trim(str_replace('DB_USERNAME=', '', $line), " \t\n\r\0\x0B'\"");
        }
        if (strpos($line, 'DB_PASSWORD=') === 0) {
            $db_pass = trim(str_replace('DB_PASSWORD=', '', $line), " \t\n\r\0\x0B'\"");
        }
        if (strpos($line, 'DB_DATABASE=') === 0) {
            $db_name = trim(str_replace('DB_DATABASE=', '', $line), " \t\n\r\0\x0B'\"");
        }
    }
}

$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Update query
$sql = "UPDATE users SET alamat = 'Kantor Dinas Perikanan Pusat, Subang' WHERE username = 'staff_tpi'";

if (mysqli_query($conn, $sql)) {
    echo "Update successful!\n";

    // Verify
    $result = mysqli_query($conn, "SELECT nama, alamat FROM users WHERE username = 'staff_tpi'");
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        echo "Nama: " . $row['nama'] . "\n";
        echo "Alamat: " . $row['alamat'] . "\n";
    }
} else {
    echo "Error: " . mysqli_error($conn);
}

mysqli_close($conn);
