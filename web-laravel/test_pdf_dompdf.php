<?php
// Direct test of DomPDF without Laravel framework
// This bypasses PHP 8.1/8.2 compatibility issues

require_once __DIR__ . '/vendor/autoload.php';

use Dompdf\Dompdf;

try {
    $dompdf = new Dompdf();

    $html = <<<HTML
    <!DOCTYPE html>
    <html>
    <head>
        <title>Test PDF</title>
    </head>
    <body>
        <h1>DomPDF Test Successful!</h1>
        <p>This confirms DomPDF is working correctly.</p>
        <p>Generated at: " . date('Y-m-d H:i:s') . "</p>
    </body>
    </html>
    HTML;

    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'landscape');
    $dompdf->render();

    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="test.pdf"');

    echo $dompdf->output();
} catch (\Exception $e) {
    http_response_code(500);
    echo "Error: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString();
}
