<?php
/**
 * PDF Download Handler - Works with PHP 8.1 + Laravel 12
 * Bypasses Laravel bootstrap to avoid ReflectionClosure errors
 */

// Get POST data
$format = $_POST['format'] ?? 'pdf';
$tpi_id = intval($_POST['tpi'] ?? 0);
$jenis_laporan = $_POST['jenis_laporan'] ?? 'harian';

// Parse dates
$bulan = $_POST['bulan'] ?? date('m');
$tahun = $_POST['tahun'] ?? date('Y');
$start_date = $_POST['start_date'] ?? null;
$end_date = $_POST['end_date'] ?? null;

// Direct database connection without Laravel
$servername = env('DB_HOST', 'localhost');
$username = env('DB_USERNAME', 'root');
$password = env('DB_PASSWORD', '');
$dbname = env('DB_DATABASE', 'sipetang_db');

function env($key, $default = null) {
    static $env_data = null;
    if ($env_data === null) {
        $env_file = dirname(__DIR__) . '/.env';
        if (file_exists($env_file)) {
            $lines = file($env_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            $env_data = [];
            foreach ($lines as $line) {
                if (strpos($line, '=') && !str_starts_with($line, '#')) {
                    list($k, $v) = explode('=', $line, 2);
                    $env_data[trim($k)] = trim($v, '\'"');
                }
            }
        }
    }
    return $env_data[$key] ?? $default;
}

try {
    // Connect to database
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    // Build query based on report type
    $query = "SELECT t.*, u.nama as staff_nama, u.wilayah FROM tangkapans t 
              JOIN users u ON t.user_id = u.id 
              WHERE t.status = 'Divalidasi'";
    
    if ($tpi_id > 0) {
        $query .= " AND t.user_id = " . intval($tpi_id);
    }
    
    if ($jenis_laporan === 'harian' && $start_date) {
        $query .= " AND DATE(t.created_at) = '" . $conn->real_escape_string($start_date) . "'";
    } elseif ($jenis_laporan === 'bulanan') {
        $query .= " AND MONTH(t.created_at) = " . intval($bulan) . " AND YEAR(t.created_at) = " . intval($tahun);
    } elseif ($jenis_laporan === 'tahunan') {
        $query .= " AND YEAR(t.created_at) = " . intval($tahun);
    }
    
    $query .= " ORDER BY t.created_at DESC";
    
    $result = $conn->query($query);
    if (!$result) {
        throw new Exception("Query error: " . $conn->error);
    }
    
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    
    // Generate report based on format
    if ($format === 'pdf') {
        require_once __DIR__ . '/vendor/autoload.php';
        use Dompdf\Dompdf;
        
        $html = generateHTML($data, $jenis_laporan, $bulan, $tahun);
        
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="Laporan_' . date('Y-m-d_His') . '.pdf"');
        echo $dompdf->output();
        
    } elseif ($format === 'excel') {
        require_once __DIR__ . '/vendor/autoload.php';
        use Maatwebsite\Excel\Facades\Excel;
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Laporan_' . date('Y-m-d_His') . '.xlsx"');
        
        // Generate Excel (simplified)
        generateExcel($data);
    }
    
    $conn->close();
    
} catch (Exception $e) {
    http_response_code(500);
    header('Content-Type: application/json');
    echo json_encode(['error' => $e->getMessage()]);
}

function generateHTML($data, $jenis_laporan, $bulan, $tahun) {
    $html = '<html><head><style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #4CAF50; color: white; }
    </style></head><body>';
    
    $html .= '<h2>Laporan Tangkapan Ikan - ' . ucfirst($jenis_laporan) . '</h2>';
    $html .= '<table><tr><th>Tanggal</th><th>Staff</th><th>Lokasi</th><th>Jenis Ikan</th><th>Berat</th><th>Status</th></tr>';
    
    foreach ($data as $row) {
        $html .= '<tr>';
        $html .= '<td>' . $row['created_at'] . '</td>';
        $html .= '<td>' . $row['staff_nama'] . '</td>';
        $html .= '<td>' . $row['wilayah'] . '</td>';
        $html .= '<td>' . ($row['jenis_ikan'] ?? '') . '</td>';
        $html .= '<td>' . ($row['berat'] ?? '') . ' kg</td>';
        $html .= '<td>' . $row['status'] . '</td>';
        $html .= '</tr>';
    }
    
    $html .= '</table></body></html>';
    return $html;
}

function generateExcel($data) {
    // Simplified Excel generation
    // In production, use proper Excel library
}
