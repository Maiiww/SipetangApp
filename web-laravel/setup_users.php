<?php
// Direct database connection tanpa Laravel
$db_host = 'localhost';
$db_name = 'perikanan';
$db_user = 'root';
$db_pass = '';

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if users table exists and has correct columns
    $result = $pdo->query("DESC users");
    $columns = $result->fetchAll(PDO::FETCH_COLUMN, 0);

    echo "Current columns in users table:\n";
    print_r($columns);

    // Add missing columns if needed
    if (!in_array('nama', $columns)) {
        $pdo->exec("ALTER TABLE users ADD COLUMN nama VARCHAR(255) NULL AFTER username");
        echo "\n✓ Added 'nama' column\n";
    }

    if (!in_array('no_induk', $columns)) {
        $pdo->exec("ALTER TABLE users ADD COLUMN no_induk VARCHAR(50) NULL AFTER nama");
        echo "✓ Added 'no_induk' column\n";
    }

    if (!in_array('jenis_kelamin', $columns)) {
        $pdo->exec("ALTER TABLE users ADD COLUMN jenis_kelamin ENUM('Laki-laki', 'Perempuan') NULL AFTER password");
        echo "✓ Added 'jenis_kelamin' column\n";
    }

    if (!in_array('no_telepon', $columns)) {
        $pdo->exec("ALTER TABLE users ADD COLUMN no_telepon VARCHAR(15) NULL");
        echo "✓ Added 'no_telepon' column\n";
    }

    if (!in_array('alamat', $columns)) {
        $pdo->exec("ALTER TABLE users ADD COLUMN alamat TEXT NULL");
        echo "✓ Added 'alamat' column\n";
    }

    if (!in_array('wilayah', $columns)) {
        $pdo->exec("ALTER TABLE users ADD COLUMN wilayah VARCHAR(100) NULL");
        echo "✓ Added 'wilayah' column\n";
    }

    if (!in_array('status_akun', $columns)) {
        $pdo->exec("ALTER TABLE users ADD COLUMN status_akun VARCHAR(50) DEFAULT 'Aktif'");
        echo "✓ Added 'status_akun' column\n";
    }

    if (!in_array('foto_profil', $columns)) {
        $pdo->exec("ALTER TABLE users ADD COLUMN foto_profil VARCHAR(255) NULL");
        echo "✓ Added 'foto_profil' column\n";
    }

    // Now insert admin user
    $password_hash = password_hash('rahasia123', PASSWORD_BCRYPT);

    $stmt = $pdo->prepare("
        INSERT IGNORE INTO users 
        (username, password, role, nama, no_induk, jenis_kelamin, no_telepon, alamat, wilayah, status_akun, foto_profil, created_at, updated_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())
    ");

    $stmt->execute([
        'admin_pusat',
        $password_hash,
        'admin',
        'ADMIN PUSAT',
        'ADM01',
        'Laki-laki',
        '082111222333',
        'Kantor Dinas Perikanan Pusat, Subang',
        'Dinas Pusat',
        'Aktif',
        null
    ]);

    echo "\n✓ admin_pusat user created/verified!\n";
    echo "\nLogin dengan:\n";
    echo "Username: admin_pusat\n";
    echo "Password: rahasia123\n";

    // Also create staff user
    $stmt->execute([
        'staff_tpi',
        $password_hash,
        'staff',
        'STAFF VALIDASI TPI',
        'STF01',
        'Perempuan',
        '083144555666',
        'Kantor Dinas Perikanan Pusat, Subang',
        'TPI Blanakan',
        'Aktif',
        null
    ]);

    echo "\n✓ staff_tpi user created!\n";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
