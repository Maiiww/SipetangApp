<?php
// Direct database migration runner - bypass Laravel dependency issues
$db_host = 'localhost';
$db_name = 'perikanan';
$db_user = 'root';
$db_pass = '';

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "=== Database Migration Runner ===\n\n";

    // Check existing tables
    $result = $pdo->query("SHOW TABLES");
    $tables = $result->fetchAll(PDO::FETCH_COLUMN, 0);
    echo "Existing tables: " . implode(', ', $tables) . "\n\n";

    // Create laporan table
    if (!in_array('laporan', $tables)) {
        $pdo->exec("
            CREATE TABLE `laporan` (
                `idLaporan` varchar(255) NOT NULL PRIMARY KEY,
                `user_id` bigint unsigned NOT NULL,
                `namaTPI` varchar(255) NOT NULL,
                `jenisIkan` varchar(255) NOT NULL,
                `beratTotal` decimal(10, 2) NOT NULL,
                `status` enum('pending', 'validated', 'rejected') DEFAULT 'pending',
                `tanggalInput` datetime NOT NULL,
                `tanggalValidasi` datetime NULL,
                `validasiOleh` varchar(255) NULL,
                `catatan` text NULL,
                `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
                `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                CONSTRAINT `laporan_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
                CONSTRAINT `laporan_validasiOleh_foreign` FOREIGN KEY (`validasiOleh`) REFERENCES `users` (`username`) ON DELETE SET NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ");
        echo "✓ Created 'laporan' table\n";
    } else {
        echo "✓ 'laporan' table already exists\n";
    }

    // Create menu table
    if (!in_array('menu', $tables)) {
        $pdo->exec("
            CREATE TABLE `menu` (
                `id` bigint unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
                `nama` varchar(255) NOT NULL,
                `deskripsi` text NULL,
                `icon` varchar(255) NULL,
                `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
                `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ");
        echo "✓ Created 'menu' table\n";
    } else {
        echo "✓ 'menu' table already exists\n";
    }

    // Create tangkapan table (hasil tangkap)
    if (!in_array('tangkapan', $tables)) {
        $pdo->exec("
            CREATE TABLE `tangkapan` (
                `id` bigint unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
                `laporan_id` varchar(255) NOT NULL,
                `jenis_ikan` varchar(255) NOT NULL,
                `berat_kg` decimal(10, 2) NOT NULL,
                `harga_per_kg` decimal(10, 2) NULL,
                `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
                `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                CONSTRAINT `tangkapan_laporan_id_foreign` FOREIGN KEY (`laporan_id`) REFERENCES `laporan` (`idLaporan`) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ");
        echo "✓ Created 'tangkapan' table\n";
    } else {
        echo "✓ 'tangkapan' table already exists\n";
    }

    // Create jenis_ikan table
    if (!in_array('jenis_ikan', $tables)) {
        $pdo->exec("
            CREATE TABLE `jenis_ikan` (
                `id` bigint unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
                `nama_ikan` varchar(255) NOT NULL,
                `kategori` varchar(100) NULL,
                `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
                `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ");
        echo "✓ Created 'jenis_ikan' table\n";
    } else {
        echo "✓ 'jenis_ikan' table already exists\n";
    }

    // Create juru_rekap table
    if (!in_array('juru_rekap', $tables)) {
        $pdo->exec("
            CREATE TABLE `juru_rekap` (
                `id` bigint unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
                `user_id` bigint unsigned NOT NULL,
                `no_induk` varchar(50) NULL,
                `wilayah` varchar(255) NULL,
                `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
                `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                CONSTRAINT `juru_rekap_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ");
        echo "✓ Created 'juru_rekap' table\n";
    } else {
        echo "✓ 'juru_rekap' table already exists\n";
    }

    // Create hasil_tangkap table
    if (!in_array('hasil_tangkap', $tables)) {
        $pdo->exec("
            CREATE TABLE `hasil_tangkap` (
                `id` bigint unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
                `laporan_id` varchar(255) NOT NULL,
                `jenis_ikan` varchar(255) NOT NULL,
                `berat_kg` decimal(10, 2) NOT NULL,
                `harga_eceran` decimal(10, 2) NULL,
                `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
                `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                CONSTRAINT `hasil_tangkap_laporan_id_foreign` FOREIGN KEY (`laporan_id`) REFERENCES `laporan` (`idLaporan`) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ");
        echo "✓ Created 'hasil_tangkap' table\n";
    } else {
        echo "✓ 'hasil_tangkap' table already exists\n";
    }

    // Create personal_access_tokens table
    if (!in_array('personal_access_tokens', $tables)) {
        $pdo->exec("
            CREATE TABLE `personal_access_tokens` (
                `id` bigint unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
                `tokenable_type` varchar(255) NOT NULL,
                `tokenable_id` bigint unsigned NOT NULL,
                `name` varchar(255) NOT NULL,
                `token` varchar(64) NOT NULL UNIQUE,
                `abilities` text NULL,
                `last_used_at` timestamp NULL,
                `expires_at` timestamp NULL,
                `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
                `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ");
        echo "✓ Created 'personal_access_tokens' table\n";
    } else {
        echo "✓ 'personal_access_tokens' table already exists\n";
    }

    echo "\n✅ All required tables created/verified!\n";
    echo "\nNow staff can access dashboard.\n";
    echo "Staff login: staff_tpi / rahasia123\n";
} catch (PDOException $e) {
    echo "❌ Error: " . $e->getMessage();
}
