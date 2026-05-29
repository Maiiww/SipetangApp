<!DOCTYPE html>
<html>

<head>
    <title>SIPETANG - Login Test</title>
    <style>
        body {
            font-family: Arial;
            padding: 20px;
        }

        .success {
            color: green;
            padding: 10px;
            background: #e8f5e9;
            border-radius: 5px;
        }

        .error {
            color: red;
            padding: 10px;
            background: #ffebee;
            border-radius: 5px;
        }

        form {
            max-width: 300px;
            margin-top: 20px;
        }

        input {
            display: block;
            width: 100%;
            padding: 8px;
            margin: 10px 0;
        }

        button {
            padding: 10px 20px;
            background: #f16301;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <h2>🔐 SIPETANG Login Verification</h2>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $db_host = 'localhost';
        $db_name = 'perikanan';
        $db_user = 'root';
        $db_pass = '';

        try {
            $pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            // Get user from database
            $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
            $stmt->execute([$username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$user) {
                echo '<div class="error">❌ Username atau password salah.</div>';
            } else {
                // Check password
                $stored_hash = $user['password'];
                $password_match = false;

                if (preg_match('/^\$2[ayb]\$.{56}$/', $stored_hash)) {
                    $password_match = password_verify($password, $stored_hash);
                } else {
                    $password_match = hash_equals($password, $stored_hash);
                }

                if ($password_match) {
                    echo '<div class="success">✓ Login BERHASIL!</div>';
                    echo '<p><strong>User:</strong> ' . htmlspecialchars($user['nama']) . '</p>';
                    echo '<p><strong>Role:</strong> ' . htmlspecialchars($user['role']) . '</p>';
                    echo '<p><strong>Status:</strong> ' . htmlspecialchars($user['status_akun']) . '</p>';
                } else {
                    echo '<div class="error">❌ Username atau password salah.</div>';
                }
            }
        } catch (PDOException $e) {
            echo '<div class="error">❌ Database Error: ' . htmlspecialchars($e->getMessage()) . '</div>';
        }
    }
    ?>

    <form method="POST">
        <input type="text" name="username" placeholder="Username" value="admin_pusat" required>
        <input type="password" name="password" placeholder="Password" value="rahasia123" required>
        <button type="submit">Login</button>
    </form>

    <hr>
    <h3>Test Credentials:</h3>
    <ul>
        <li><strong>Admin:</strong> admin_pusat / rahasia123</li>
        <li><strong>Staff:</strong> staff_tpi / rahasia123</li>
    </ul>

    <p>Aplikasi Laravel memiliki dependency issue dengan PHP 8.1 (memerlukan 8.2).<br>
        Untuk fix: Upgrade PHP di Laragon ke 8.2, atau downgrade Laravel dependencies.</p>
</body>

</html>