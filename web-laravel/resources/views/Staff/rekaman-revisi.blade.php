<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Revisi - SIPETANG</title>
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
            display: flex;
            min-height: 100vh;
        }

        .main-content {
            margin-left: 260px;
            flex: 1;
            padding: 30px;
        }

        .page-title {
            margin-bottom: 30px;
        }

        .page-title h1 {
            font-size: 28px;
            font-weight: 600;
            color: #1a4d7d;
            margin-bottom: 8px;
        }

        .page-title p {
            font-size: 14px;
            color: #666;
        }

        .alert {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-info {
            background: #d1ecf1;
            color: #0c5460;
            border: 1px solid #bee5eb;
        }

        .table-section {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
        }

        .table-title {
            font-size: 14px;
            font-weight: 600;
            color: #1a4d7d;
            margin-bottom: 20px;
        }

        .reports-table {
            width: 100%;
            border-collapse: collapse;
        }

        .reports-table thead {
            background: #f5f5f5;
        }

        .reports-table th {
            padding: 12px;
            text-align: left;
            font-size: 11px;
            text-transform: uppercase;
            color: #999;
            font-weight: 600;
            border-bottom: 1px solid #e0e0e0;
        }

        .reports-table td {
            padding: 12px;
            border-bottom: 1px solid #e0e0e0;
            font-size: 13px;
            color: #333;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            background: #fff3cd;
            color: #856404;
        }

        .btn-revisi {
            background: #007bff;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-revisi:hover {
            background: #0056b3;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #999;
        }

        .empty-state i {
            font-size: 48px;
            margin-bottom: 15px;
            opacity: 0.5;
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background: white;
            padding: 30px;
            border-radius: 12px;
            width: 90%;
            max-width: 600px;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        }

        .modal-header {
            font-size: 18px;
            font-weight: 600;
            color: #0d2640;
            margin-bottom: 20px;
            border-bottom: 1px solid #e0e0e0;
            padding-bottom: 15px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            color: #333;
            margin-bottom: 6px;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            font-size: 13px;
            font-family: inherit;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 80px;
        }

        .form-actions {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
            margin-top: 25px;
            border-top: 1px solid #e0e0e0;
            padding-top: 15px;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            font-size: 13px;
            transition: all 0.3s;
        }

        .btn-primary {
            background: #1a4d7d;
            color: white;
        }

        .btn-primary:hover {
            background: #0d2640;
        }

        .btn-secondary {
            background: #e0e0e0;
            color: #333;
        }

        .btn-secondary:hover {
            background: #d0d0d0;
        }

        .rejection-reason {
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 15px;
            color: #721c24;
            font-size: 13px;
        }

        .rejection-reason strong {
            display: block;
            margin-bottom: 8px;
        }
    </style>
</head>

<body>
    @include('components.sidebar-menu')

    <div class="main-content">
        <div class="page-title">
            <h1>Data yang Perlu Revisi</h1>
            <p>Daftar data hasil tangkap yang ditolak oleh staff dan perlu dilakukan revisi.</p>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        <div class="table-section">
            <div class="table-title">
                <i class="fas fa-redo"></i> Antrean Revisi ({{ $dataRevisi->total() }} data)
            </div>

            @if ($dataRevisi->count() > 0)
                <table class="reports-table">
                    <thead>
                        <tr>
                            <th>Tanggal Ditolak</th>
                            <th>Jenis Ikan</th>
                            <th>Berat (Kg)</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dataRevisi as $data)
                            <tr>
                                <td>{{ $data->rejected_at->format('d M Y H:i') }}</td>
                                <td>
                                    <strong>{{ $data->jenis_ikan }}</strong><br>
                                    <small style="color: #999;">{{ $data->nama_pembeli }}</small>
                                </td>
                                <td>{{ number_format($data->berat, 2) }}</td>
                                <td>
                                    <span class="badge">
                                        <i class="fas fa-exclamation-circle"></i> Perlu Revisi
                                    </span>
                                </td>
                                <td>
                                    <button type="button" class="btn-revisi"
                                        onclick="openRevisiModal({{ $data->id }}, '{{ $data->jenis_ikan }}', '{{ $data->nama_pembeli }}', '{{ $data->nama_nelayan }}', {{ $data->berat }}, {{ $data->harga_jual }}, `{{ $data->catatan }}`)">
                                        <i class="fas fa-edit"></i> Revisi
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $dataRevisi->links('pagination.custom') }}
            @else
                <div class="empty-state">
                    <i class="fas fa-inbox"></i>
                    <p>Tidak ada data yang perlu revisi</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Modal Revisi -->
    <div id="revisiModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                Revisi Data: <span id="modalJenisIkan"></span>
            </div>

            <div id="rejectionReason" class="rejection-reason" style="display: none;">
                <strong>Alasan Penolakan:</strong>
                <span id="rejectionReasonText"></span>
            </div>

            <form id="revisiForm" method="POST">
                @csrf
                <div class="form-group">
                    <label>Nama Pembeli</label>
                    <input type="text" name="nama_pembeli" id="nama_pembeli" required>
                </div>
                <div class="form-group">
                    <label>Nama Nelayan</label>
                    <input type="text" name="nama_nelayan" id="nama_nelayan" required>
                </div>
                <div class="form-group">
                    <label>Jenis Ikan</label>
                    <input type="text" name="jenis_ikan" id="jenis_ikan" required>
                </div>
                <div class="form-group">
                    <label>Berat (Kg)</label>
                    <input type="number" name="berat" id="berat" step="0.01" min="0.1" required>
                </div>
                <div class="form-group">
                    <label>Harga Jual</label>
                    <input type="number" name="harga_jual" id="harga_jual" min="0" required>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" onclick="closeRevisiModal()">Batal</button>
                    <button type="submit" class="btn btn-primary">Kirim Revisi</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openRevisiModal(id, jenisIkan, namaPembeli, namaNelayan, berat, hargaJual, catatan) {
            document.getElementById('modalJenisIkan').textContent = jenisIkan;
            document.getElementById('nama_pembeli').value = namaPembeli;
            document.getElementById('nama_nelayan').value = namaNelayan;
            document.getElementById('jenis_ikan').value = jenisIkan;
            document.getElementById('berat').value = berat;
            document.getElementById('harga_jual').value = hargaJual;

            if (catatan) {
                document.getElementById('rejectionReasonText').textContent = catatan;
                document.getElementById('rejectionReason').style.display = 'block';
            }

            document.getElementById('revisiForm').action = '/staff/rekaman-revisi/' + id;
            document.getElementById('revisiModal').style.display = 'flex';
        }

        function closeRevisiModal() {
            document.getElementById('revisiModal').style.display = 'none';
        }

        document.getElementById('revisiModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeRevisiModal();
            }
        });
    </script>
</body>

</html>
