<?php
// Test staff dashboard login
$db_host = 'localhost';
$db_name = 'perikanan';
$db_user = 'root';
$db_pass = '';

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "=== STAFF LOGIN TEST ===\n\n";

    if ($_SERVER['REQUEST_METHOD'] === 'POST' || isset($_GET['test'])) {
        $username = $_POST['username'] ?? $_GET['username'] ?? 'staff_tpi';
        $password = $_POST['password'] ?? $_GET['password'] ?? 'rahasia123';

        // Get staff user
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            echo '<div style="color: red; padding: 10px; background: #ffebee; border-radius: 5px;">';
            echo "❌ User tidak ditemukan!\n";
            echo '</div>';
        } else {
            $stored_hash = $user['password'];
            $password_match = false;

            if (preg_match('/^\$2[ayb]\$.{56}$/', $stored_hash)) {
                $password_match = password_verify($password, $stored_hash);
            } else {
                $password_match = hash_equals($password, $stored_hash);
            }

            if ($password_match) {
                if (strtolower($user['role']) !== 'staff') {
                    echo '<div style="color: orange; padding: 10px; background: #fff3cd; border-radius: 5px;">';
                    echo "⚠️ User ini adalah " . ucfirst($user['role']) . ", bukan Staff!\n";
                    echo '</div>';
                } else {
                    echo '<div style="color: green; padding: 10px; background: #e8f5e9; border-radius: 5px;">';
                    echo "✓ Login BERHASIL!\n";
                    echo "User: " . htmlspecialchars($user['nama']) . "\n";
                    echo "Role: " . htmlspecialchars($user['role']) . "\n";
                    echo '</div>';

                    // Check dashboard data
                    echo "<h3>Dashboard Data Check:</h3>";

                    // Check laporan table
                    $stmt = $pdo->query("SELECT COUNT(*) as total FROM laporan");
                    $laporanCount = $stmt->fetch()['total'];
                    echo "Total Laporan: <strong>$laporanCount</strong><br>";

                    if ($laporanCount == 0) {
                        echo '<p style="color: #ff9800;">⚠️ Belum ada data laporan. Dashboard akan menampilkan data kosong.</p>';
                    }

                    // Check recent laporan
                    $stmt = $pdo->query("SELECT * FROM laporan ORDER BY tanggalInput DESC LIMIT 5");
                    $laporanList = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    if (count($laporanList) > 0) {
                        echo "<h4>Laporan Terbaru:</h4>";
                        foreach ($laporanList as $lap) {
                            echo "- " . htmlspecialchars($lap['idLaporan']) . " (" . htmlspecialchars($lap['status']) . ")<br>";
                        }
                    }
                }
            } else {
                echo '<div style="color: red; padding: 10px; background: #ffebee; border-radius: 5px;">';
                echo "❌ Password salah!\n";
                echo '</div>';
            }
        }
    }
?>

    <!DOCTYPE html>
    <html>

    <head>
        <title>Staff Dashboard Test</title>
        <style>
            body {
                font-family: Arial;
                padding: 20px;
                max-width: 600px;
            }

            form {
                margin: 20px 0;
            }

            input {
                display: block;
                width: 100%;
                padding: 8px;
                margin: 10px 0;
                box-sizing: border-box;
            }

            button {
                padding: 10px 20px;
                background: #2196F3;
                color: white;
                border: none;
                border-radius: 5px;
                cursor: pointer;
            }

            h3,
            h4 {
                color: #333;
            }
        </style>
    </head>

    <body>
        <h2>🔐 Staff Dashboard Test</h2>

        <form method="POST">
            <input type="text" name="username" placeholder="Username" value="staff_tpi" required>
            <input type="password" name="password" placeholder="Password" value="rahasia123" required>
            <button type="submit">Test Login</button>
        </form>

        <hr>
        <h3>Database Status:</h3>
        <?php
        $result = $pdo->query("SHOW TABLES");
        $tables = $result->fetchAll(PDO::FETCH_COLUMN, 0);
        echo "Tables: " . implode(', ', $tables) . "<br>";

        $result = $pdo->query("SELECT COUNT(*) as total FROM users");
        $userCount = $result->fetch()['total'];
        echo "Total Users: $userCount<br>";

        $result = $pdo->query("SELECT username, role FROM users");
        $users = $result->fetchAll(PDO::FETCH_ASSOC);
        echo "<h4>Available Users:</h4>";
        foreach ($users as $u) {
            echo "- " . htmlspecialchars($u['username']) . " (" . htmlspecialchars($u['role']) . ")<br>";
        }
        ?>
    </body>

    </html>

<?php
} catch (PDOException $e) {
    echo "❌ Database Error: " . $e->getMessage();
}
?>