<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen User - SIPETANG</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Menggunakan CSS yang Anda berikan sebelumnya */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f5f5;
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 200px;
            background: linear-gradient(180deg, #0d2640 0%, #1a4d7d 100%);
            color: white;
            padding: 30px 20px;
            display: flex;
            flex-direction: column;
            position: fixed;
            height: 100vh;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            overflow-y: auto;
            z-index: 100;
        }

        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 40px;
            font-weight: 700;
        }

        .sidebar-logo-box {
            background: white;
            width: 40px;
            height: 40px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #0d2640;
        }

        .sidebar-logo-text h3 {
            font-size: 14px;
            margin: 0;
        }

        .sidebar-logo-text p {
            font-size: 9px;
            opacity: 0.7;
            margin: 0;
        }

        .sidebar-menu {
            flex: 1;
            list-style: none;
        }

        .sidebar-menu li {
            margin-bottom: 20px;
        }

        .sidebar-menu a {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 10px;
            border-radius: 6px;
            transition: background 0.2s ease, transform 0.1s ease;
            font-size: 14px;
        }

        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background: rgba(255, 255, 255, 0.1);
        }

        .sidebar-menu a:active {
            background: rgba(255, 255, 255, 0.16);
            transform: scale(0.98);
        }

        .sidebar-logout {
            margin-top: auto;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
        }

        .sidebar-logout a {
            color: white;
            text-decoration: none;
            font-size: 14px;
        }

        /* Main Content Area */
        .main-content {
            margin-left: 200px;
            flex: 1;
            padding: 30px;
        }

        /* Header */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .search-box {
            display: flex;
            align-items: center;
            padding: 0 15px;
            background: #f5f5f5;
            border-radius: 6px;
            border: 1px solid #e0e0e0;
            width: 300px;
        }

        .search-box input {
            border: none;
            background: none;
            width: 100%;
            font-size: 14px;
            padding: 10px 0;
            outline: none;
            margin-left: 10px;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 10px;
            text-align: right;
        }

        .user-profile img {
            width: 35px;
            height: 35px;
            border-radius: 6px;
        }

        /* Content Components */
        .content-header {
            margin-bottom: 25px;
        }

        .content-header h2 {
            font-size: 24px;
            color: #0d2640;
        }

        .content-header p {
            color: #666;
            font-size: 14px;
        }

        /* Filter Row */
        .filter-row {
            display: flex;
            gap: 20px;
            margin-bottom: 30px;
            align-items: flex-end;
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
        }

        .filter-form {
            background: white;
            padding: 20px;
            border-radius: 12px;
            display: flex;
            gap: 15px;
            flex: 1;
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
        }

        .btn-primary {
            background: #2563eb;
            color: white;
        }

        .btn-dark {
            background: #0d2640;
            color: white;
        }

        /* Table User */
        .table-container {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
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
            width: 35px;
            height: 35px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 12px;
        }

        .tpi-badge {
            background: #e0f2fe;
            color: #0369a1;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 600;
        }

        /* Pagination */
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

        .page-nav {
            display: flex;
            gap: 5px;
        }

        .page-link {
            padding: 5px 10px;
            border: 1px solid #eee;
            border-radius: 4px;
            text-decoration: none;
            color: #334155;
            font-size: 12px;
        }

        .page-link.active {
            background: #0d2640;
            color: white;
            border-color: #0d2640;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 60px;
                padding: 20px 10px;
            }

            .sidebar-logo-text,
            .sidebar-menu span,
            .sidebar-logout span {
                display: none;
            }

            .main-content {
                margin-left: 60px;
            }
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            overflow: auto;
        }

        .modal.active {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background-color: white;
            padding: 30px;
            border-radius: 12px;
            width: 90%;
            max-width: 500px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            max-height: 90vh;
            overflow-y: auto;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }

        .modal-header h2 {
            font-size: 20px;
            color: #0d2640;
            margin: 0;
        }

        .modal-close {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: #888;
            padding: 0;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-close:hover {
            color: #0d2640;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 15px;
        }

        .form-row.full {
            grid-template-columns: 1fr;
        }

        .form-group-modal {
            display: flex;
            flex-direction: column;
        }

        .form-group-modal label {
            font-size: 12px;
            color: #0d2640;
            font-weight: 700;
            margin-bottom: 8px;
            text-transform: uppercase;
        }

        .form-group-modal input,
        .form-group-modal select,
        .form-group-modal textarea {
            padding: 10px 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 13px;
            font-family: inherit;
            background: #fcfcfc;
            transition: border-color 0.2s ease;
        }

        .form-group-modal input:focus,
        .form-group-modal select:focus,
        .form-group-modal textarea:focus {
            outline: none;
            border-color: #2563eb;
            background: white;
        }

        .form-group-modal textarea {
            resize: vertical;
            min-height: 80px;
        }

        .modal-footer {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
            margin-top: 25px;
            padding-top: 15px;
            border-top: 1px solid #eee;
        }

        .btn-cancel {
            padding: 10px 20px;
            border: 1px solid #ddd;
            background: white;
            color: #666;
            border-radius: 6px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .btn-cancel:hover {
            background: #f5f5f5;
            border-color: #bbb;
        }

        .btn-submit {
            padding: 10px 20px;
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 600;
            transition: background 0.2s ease;
        }

        .btn-submit:hover {
            background: #1d4ed8;
        }

        .btn-submit:disabled {
            background: #ccc;
            cursor: not-allowed;
        }
    </style>
</head>

<body>
    @include('components.sidebar-menu')

    <div class="main-content">
        <div class="header">
            <div style="flex: 1;"></div>
            <div class="header-right">
                <i class="fas fa-bell" style="color: #64748b;"></i>
                <i class="fas fa-cog" style="color: #64748b;"></i>
                <div class="user-profile">
                    <div>
                        <p style="font-size: 14px; font-weight: bold;">Admin</p>
                        <small style="color: #888;">DINAS PERIKANAN</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="content-header">
            <h2>Kelola Data Pengguna</h2>
            <p>Kelola seluruh data Juru Rekap</p>
        </div>

        <div class="filter-row">
            <div class="total-card">
                <small>TOTAL DATA USER</small>
                <h2>{{ count($users) }}</h2>
            </div>
            <div class="filter-form">
                <div class="form-group">
                    <label>CARI DATA PETUGAS</label>
                    <input type="text" placeholder="Ketik nama atau ID...">
                </div>
                <div class="form-group">
                    <label>ROLE</label>
                    <select>
                        <option>Semua Role</option>
                        <option>Admin</option>
                        <option>Juru Rekap</option>
                        <option>Staff</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>JENIS KELAMIN</label>
                    <select>
                        <option>Semua</option>
                        <option>Laki-laki</option>
                        <option>Perempuan</option>
                    </select>
                </div>
                <button class="btn btn-primary">Terapkan</button>
            </div>
            <button class="btn btn-dark" onclick="openModal()"><i class="fas fa-user-plus"></i> Tambah Pengguna</button>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Nama Petugas</th>
                        <th>Asal TPI</th>
                        <th>Jenis Kelamin</th>
                        <th>No Telepon</th>
                        <th>Alamat</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>
                                <div class="user-info">
                                    <div class="avatar"
                                        style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                                        {{ strtoupper(substr($user->nama ?? $user->username, 0, 2)) }}
                                    </div>
                                    <div>
                                        <strong>{{ $user->nama ?? $user->username }}</strong>
                                        <br>
                                        <small style="color: #999;">{{ $user->no_induk ?? '-' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td><span class="tpi-badge">{{ $user->wilayah ?? 'Umum' }}</span></td>
                            <td>{{ $user->jenis_kelamin ?? '-' }}</td>
                            <td>{{ $user->no_telepon ?? '-' }}</td>
                            <td>{{ $user->alamat ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center; color: #999; padding: 30px;">Tidak ada data
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="pagination">
                <p class="page-info">
                    {{ count($users) > 0 ? 'Menampilkan ' . count($users) . ' data' : 'Tidak ada data' }}</p>
                <div class="page-nav">
                    <a href="#" class="page-link"><i class="fas fa-chevron-left"></i></a>
                    <a href="#" class="page-link active">1</a>
                    <a href="#" class="page-link">2</a>
                    <a href="#" class="page-link">3</a>
                    <span style="color: #ccc;">...</span>
                    <a href="#" class="page-link">321</a>
                    <a href="#" class="page-link"><i class="fas fa-chevron-right"></i></a>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah User -->
    <div id="tambahUserModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Tambah User Baru</h2>
                <button class="modal-close" onclick="closeModal()">&times;</button>
            </div>

            <form id="formTambahUser" action="{{ route('admin.user.store') }}" method="POST">
                @csrf
                <div class="form-row">
                    <div class="form-group-modal">
                        <label>Nama Petugas *</label>
                        <input type="text" name="nama" placeholder="Masukkan nama lengkap" required>
                    </div>
                    <div class="form-group-modal">
                        <label>No. Id *</label>
                        <input type="text" name="no_induk" placeholder="Contoh: JR-001" required>
                    </div>
                </div>

                <div class="form-row full">
                    <div class="form-group-modal">
                        <label>Username *</label>
                        <input type="text" name="username" placeholder="Masukkan username" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group-modal">
                        <label>Password *</label>
                        <input type="password" name="password" placeholder="Masukkan password" required>
                    </div>
                    <div class="form-group-modal">
                        <label>Konfirmasi Password *</label>
                        <input type="password" name="password_confirmation" placeholder="Konfirmasi password" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group-modal">
                        <label>Role *</label>
                        <select name="role" id="roleSelect" required onchange="updateRoleFields()">
                            <option value="">Pilih Role</option>
                            <option value="staff">Staff</option>
                            <option value="juruRekap">Juru Rekap</option>
                            <option value="Admin">Admin</option>
                        </select>
                    </div>
                    <div class="form-group-modal">
                        <label>Jenis Kelamin *</label>
                        <select name="jenis_kelamin" required>
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                </div>

                <div class="form-row full" id="asal_tpi_field" style="display: none;">
                    <div class="form-group-modal">
                        <label>Asal TPI (Wilayah) <span id="wilayah_required" style="display: none;">*</span></label>
                        <input type="text" name="wilayah" id="wilayah_input" placeholder="Contoh: TPI Blanakan">
                    </div>
                </div>

                <div class="form-row full">
                    <div class="form-group-modal">
                        <label>No. Telepon *</label>
                        <input type="tel" name="no_telepon" placeholder="Contoh: +62 812-3456-7890" required>
                    </div>
                </div>

                <div class="form-row full">
                    <div class="form-group-modal">
                        <label>Alamat *</label>
                        <textarea name="alamat" placeholder="Masukkan alamat lengkap" required></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn-cancel" onclick="closeModal()">Batal</button>
                    <button type="submit" class="btn-submit">Tambah User</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openModal() {
            document.getElementById('tambahUserModal').classList.add('active');
        }

        function closeModal() {
            document.getElementById('tambahUserModal').classList.remove('active');
            document.getElementById('formTambahUser').reset();
            document.getElementById('asal_tpi_field').style.display = 'none';
        }

        function updateRoleFields() {
            const role = document.getElementById('roleSelect').value;
            const asal_tpi_field = document.getElementById('asal_tpi_field');
            const wilayah_input = document.getElementById('wilayah_input');
            const wilayah_required = document.getElementById('wilayah_required');

            // Show asal TPI field only for juruRekap role
            if (role === 'juruRekap') {
                asal_tpi_field.style.display = 'grid';
                wilayah_input.setAttribute('required', 'required');
                wilayah_required.style.display = 'inline';
            } else {
                asal_tpi_field.style.display = 'none';
                wilayah_input.removeAttribute('required');
                wilayah_required.style.display = 'none';
            }
        }

        // Close modal when clicking outside of it
        window.onclick = function(event) {
            const modal = document.getElementById('tambahUserModal');
            if (event.target == modal) {
                closeModal();
            }
        }

        // Handle form submission
        document.getElementById('formTambahUser').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);

            // Log data untuk debugging
            console.log('Form Data:');
            for (let [key, value] of formData.entries()) {
                console.log(key + ': ' + value);
            }

            fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    console.log('Response:', data);

                    if (data.success) {
                        alert('User berhasil ditambahkan!');
                        closeModal();
                        // Reload halaman untuk melihat data terbaru
                        location.reload();
                    } else {
                        // Tampilkan error messages detail
                        let errorMsg = data.message || 'Gagal menambahkan user';
                        if (data.errors) {
                            errorMsg += '\n\nDetail Error:\n';
                            for (let field in data.errors) {
                                if (Array.isArray(data.errors[field])) {
                                    errorMsg += '• ' + field + ': ' + data.errors[field].join(', ') + '\n';
                                }
                            }
                        }
                        alert(errorMsg);
                        console.error('Validation Errors:', data.errors);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan: ' + error);
                });
        });
    </script>
</body>

</html>
