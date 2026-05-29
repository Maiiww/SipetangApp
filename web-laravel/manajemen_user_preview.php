<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen User Preview - SIPETANG</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f5f5;
            padding: 30px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .content-header {
            margin-bottom: 30px;
        }

        .content-header h2 {
            font-size: 24px;
            color: #0d2640;
            margin-bottom: 5px;
        }

        .content-header p {
            color: #666;
            font-size: 14px;
        }

        .filter-row {
            display: flex;
            gap: 20px;
            margin-bottom: 30px;
            align-items: flex-end;
            flex-wrap: wrap;
        }

        .total-card {
            background: #0d2640;
            color: white;
            padding: 20px;
            border-radius: 12px;
            min-width: 150px;
        }

        .total-card small {
            font-size: 10px;
            opacity: 0.7;
            text-transform: uppercase;
        }

        .total-card h2 {
            font-size: 32px;
            margin-top: 5px;
        }

        .filter-form {
            background: white;
            padding: 20px;
            border-radius: 12px;
            display: flex;
            gap: 15px;
            flex: 1;
            min-width: 400px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
        }

        .form-group {
            flex: 1;
        }

        .form-group label {
            display: block;
            font-size: 11px;
            color: #888;
            font-weight: 700;
            margin-bottom: 5px;
            text-transform: uppercase;
        }

        .form-group select,
        .form-group input {
            width: 100%;
            padding: 8px;
            border: 1px solid #eee;
            border-radius: 6px;
            background: #fcfcfc;
            font-size: 13px;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 600;
            align-self: flex-end;
        }

        .btn-primary {
            background: #2563eb;
            color: white;
        }

        .table-container {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            text-align: left;
            padding: 12px;
            font-size: 12px;
            color: #888;
            border-bottom: 1px solid #eee;
            text-transform: uppercase;
            background: #f8f8f8;
        }

        td {
            padding: 15px 12px;
            font-size: 13px;
            border-bottom: 1px solid #eee;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 12px;
            color: white;
        }

        .avatar.admin {
            background: linear-gradient(135deg, #f59e0b 0%, #dc2626 100%);
        }

        .avatar.staff {
            background: linear-gradient(135deg, #3b82f6 0%, #06b6d4 100%);
        }

        .avatar.juruRekap {
            background: linear-gradient(135deg, #8b5cf6 0%, #ec4899 100%);
        }

        .tpi-badge {
            background: #e0f2fe;
            color: #0369a1;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 600;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            background: #dcfce7;
            color: #166534;
            border: 1px solid #86efac;
        }

        .role-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            background: #f3f4f6;
            color: #374151;
        }

        .role-badge.admin {
            background: #fed7aa;
            color: #92400e;
        }

        .role-badge.staff {
            background: #bfdbfe;
            color: #1e40af;
        }

        .role-badge.juruRekap {
            background: #ddd6fe;
            color: #5b21b6;
        }

        tr:hover {
            background-color: #f9fafb;
        }

        .pagination {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
        }

        .page-info {
            font-size: 12px;
            color: #888;
        }

        @media (max-width: 768px) {
            .filter-row {
                flex-direction: column;
            }

            .filter-form {
                min-width: 100%;
            }

            table {
                font-size: 11px;
            }

            td,
            th {
                padding: 8px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="content-header">
            <h2>Kelola Data Pengguna</h2>
            <p>Kelola seluruh data Juru Rekap, Staff, dan Admin</p>
        </div>

        <?php
        $db_host = 'localhost';
        $db_name = 'perikanan';
        $db_user = 'root';
        $db_pass = '';

        try {
            $pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $result = $pdo->query("SELECT * FROM users ORDER BY role, nama");
            $users = $result->fetchAll(PDO::FETCH_ASSOC);
            $totalUsers = count($users);
        ?>

            <div class="filter-row">
                <div class="total-card">
                    <small>TOTAL DATA USER</small>
                    <h2><?php echo $totalUsers; ?></h2>
                </div>
                <div class="filter-form">
                    <div class="form-group">
                        <label>CARI DATA PETUGAS</label>
                        <input type="text" placeholder="Ketik nama atau ID..." id="searchInput" onkeyup="filterTable()">
                    </div>
                    <div class="form-group">
                        <label>ROLE</label>
                        <select id="roleFilter" onchange="filterTable()">
                            <option value="">Semua Role</option>
                            <option value="admin">Admin</option>
                            <option value="juruRekap">Juru Rekap</option>
                            <option value="staff">Staff</option>
                        </select>
                    </div>
                    <button class="btn btn-primary">Terapkan</button>
                </div>
            </div>

            <div class="table-container">
                <table id="userTable">
                    <thead>
                        <tr>
                            <th>Nama Petugas</th>
                            <th>No. ID</th>
                            <th>Role</th>
                            <th>Asal TPI</th>
                            <th>Jenis Kelamin</th>
                            <th>No Telepon</th>
                            <th>Alamat</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                            <tr class="user-row" data-role="<?php echo strtolower($user['role']); ?>" data-name="<?php echo strtolower($user['nama'] ?? $user['username']); ?>">
                                <td>
                                    <div class="user-info">
                                        <div class="avatar <?php echo strtolower($user['role']); ?>">
                                            <?php echo strtoupper(substr($user['nama'] ?? $user['username'], 0, 2)); ?>
                                        </div>
                                        <div>
                                            <strong><?php echo htmlspecialchars($user['nama'] ?? $user['username']); ?></strong>
                                            <br>
                                            <small style="color: #999;"><?php echo htmlspecialchars($user['username']); ?></small>
                                        </div>
                                    </div>
                                </td>
                                <td><?php echo htmlspecialchars($user['no_induk'] ?? '-'); ?></td>
                                <td>
                                    <span class="role-badge <?php echo strtolower($user['role']); ?>">
                                        <?php
                                        $roles = [
                                            'admin' => 'Admin',
                                            'staff' => 'Staff',
                                            'juruRekap' => 'Juru Rekap'
                                        ];
                                        echo $roles[strtolower($user['role'])] ?? $user['role'];
                                        ?>
                                    </span>
                                </td>
                                <td><span class="tpi-badge"><?php echo htmlspecialchars($user['wilayah'] ?? 'Umum'); ?></span></td>
                                <td><?php echo htmlspecialchars($user['jenis_kelamin'] ?? '-'); ?></td>
                                <td><?php echo htmlspecialchars($user['no_telepon'] ?? '-'); ?></td>
                                <td><?php echo htmlspecialchars($user['alamat'] ?? '-'); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <div class="pagination">
                    <p class="page-info">
                        Menampilkan <strong><?php echo $totalUsers; ?></strong> data user
                    </p>
                </div>
            </div>

        <?php
        } catch (PDOException $e) {
            echo '<div style="color: red; padding: 20px; background: #ffebee; border-radius: 8px;">';
            echo '❌ Database Error: ' . htmlspecialchars($e->getMessage());
            echo '</div>';
        }
        ?>
    </div>

    <script>
        function filterTable() {
            const searchInput = document.getElementById('searchInput').value.toLowerCase();
            const roleFilter = document.getElementById('roleFilter').value.toLowerCase();
            const rows = document.querySelectorAll('.user-row');

            rows.forEach(row => {
                const name = row.getAttribute('data-name');
                const role = row.getAttribute('data-role');

                const matchSearch = name.includes(searchInput);
                const matchRole = roleFilter === '' || role === roleFilter;

                row.style.display = (matchSearch && matchRole) ? '' : 'none';
            });
        }
    </script>
</body>

</html>