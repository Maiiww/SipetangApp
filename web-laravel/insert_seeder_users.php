<?php
// Insert all seeder users to database
$db_host = 'localhost';
$db_name = 'perikanan';
$db_user = 'root';
$db_pass = '';

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "=== Insert Seeder Users ===\n\n";

    // Define all users from seeder
    $users = [
        [
            'username' => 'imamarifin',
            'password_plain' => 'rahasia123',
            'role' => 'juruRekap',
            'nama' => 'IMAM ARIFIN',
            'no_induk' => 'JR04',
            'jenis_kelamin' => 'Laki-laki',
            'no_telepon' => '0895346788823',
            'alamat' => 'Jl. Raya Blanakan No. 12, Subang',
            'wilayah' => 'TPI Blanakan',
            'status_akun' => 'Aktif',
        ],
        [
            'username' => 'budidoremi',
            'password_plain' => '12345678',
            'role' => 'juruRekap',
            'nama' => 'BUDI DOREMI',
            'no_induk' => 'JR05',
            'jenis_kelamin' => 'Laki-laki',
            'no_telepon' => '081234567890',
            'alamat' => 'Pamanukan, Subang',
            'wilayah' => 'TPI Pamanukan',
            'status_akun' => 'Aktif',
        ],
        [
            'username' => 'admin_pusat',
            'password_plain' => 'rahasia123',
            'role' => 'admin',
            'nama' => 'ADMIN PUSAT',
            'no_induk' => 'ADM01',
            'jenis_kelamin' => 'Laki-laki',
            'no_telepon' => '082111222333',
            'alamat' => 'Kantor Dinas Perikanan Pusat, Subang',
            'wilayah' => 'Dinas Pusat',
            'status_akun' => 'Aktif',
        ],
        [
            'username' => 'staff_tpi',
            'password_plain' => 'rahasia123',
            'role' => 'staff',
            'nama' => 'STAFF VALIDASI TPI',
            'no_induk' => 'STF01',
            'jenis_kelamin' => 'Perempuan',
            'no_telepon' => '083144555666',
            'alamat' => 'Kantor Cabang Dinas Blanakan',
            'wilayah' => 'TPI Blanakan',
            'status_akun' => 'Aktif',
        ]
    ];

    // Insert/update each user
    $stmt = $pdo->prepare("
        INSERT IGNORE INTO users 
        (username, password, role, nama, no_induk, jenis_kelamin, no_telepon, alamat, wilayah, status_akun, created_at, updated_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())
    ");

    foreach ($users as $user) {
        $password_hash = password_hash($user['password_plain'], PASSWORD_BCRYPT);

        $stmt->execute([
            $user['username'],
            $password_hash,
            $user['role'],
            $user['nama'],
            $user['no_induk'],
            $user['jenis_kelamin'],
            $user['no_telepon'],
            $user['alamat'],
            $user['wilayah'],
            $user['status_akun']
        ]);

        echo "✓ " . $user['username'] . " (" . $user['role'] . ")\n";
    }

    // Show all users
    echo "\n=== All Users in Database ===\n";
    $result = $pdo->query("SELECT username, role, nama, wilayah FROM users ORDER BY role, nama");
    $allUsers = $result->fetchAll(PDO::FETCH_ASSOC);

    echo "Total Users: " . count($allUsers) . "\n\n";

    foreach ($allUsers as $u) {
        echo "- " . str_pad($u['username'], 15) . " | Role: " . str_pad($u['role'], 10) . " | " . $u['nama'] . " | " . $u['wilayah'] . "\n";
    }

    echo "\n✅ All seeder users added to database!\n";
    echo "\n📋 Login Credentials:\n";
    echo "   Admin      : admin_pusat / rahasia123\n";
    echo "   Staff      : staff_tpi / rahasia123\n";
    echo "   Juru Rekap : imamarifin / rahasia123\n";
    echo "   Juru Rekap : budidoremi / 12345678\n";
} catch (PDOException $e) {
    echo "❌ Error: " . $e->getMessage();
}
