<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class LaporanExport implements FromArray, WithHeadings, WithStyles, ShouldAutoSize
{
    private $laporan;
    private $validated;

    public function __construct($laporan, $validated)
    {
        $this->laporan = $laporan;
        $this->validated = $validated;
    }

    /**
     * @return array
     */
    public function array(): array
    {
        $rows = [];

        // Add summary section
        $rows[] = ['LAPORAN DATA MARITIM SIPETANG'];
        $rows[] = [];
        $rows[] = ['Tipe Laporan:', ucfirst(str_replace('_', ' ', $this->validated['laporan_type']))];
        $rows[] = ['Tanggal Generate:', now()->format('d/m/Y H:i:s')];
        $rows[] = ['Total Record:', $this->laporan->count()];
        $rows[] = ['Total Berat (kg):', number_format($this->laporan->sum('beratTotal'), 2, ',', '.')];
        $rows[] = [];

        // Add data headers
        $rows[] = [
            'ID Laporan',
            'Nama TPI',
            'Jenis Ikan',
            'Berat Total (kg)',
            'Tanggal Tangkap',
            'Tanggal Input',
            'Status'
        ];

        // Add data rows
        foreach ($this->laporan as $item) {
            $rows[] = [
                $item->idLaporan,
                $item->namaTPI,
                $item->jenisIkan,
                number_format($item->beratTotal, 2, ',', '.'),
                $item->tanggalTangkap ? $item->tanggalTangkap->format('d/m/Y') : '-',
                $item->tanggalInput ? $item->tanggalInput->format('d/m/Y H:i:s') : '-',
                ucfirst($item->status),
            ];
        }

        return $rows;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [];
    }

    /**
     * @param Worksheet $sheet
     * @return array
     */
    public function styles(Worksheet $sheet)
    {
        // Title styling
        $sheet->mergeCells('A1:G1');
        $sheet->getStyle('A1')->applyFromArray([
            'font' => ['bold' => true, 'size' => 14],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]
        ]);

        // Summary styling
        $sheet->getStyle('A3:A6')->applyFromArray([
            'font' => ['bold' => true],
        ]);

        // Data headers styling (row 8)
        $dataHeaderRow = 8;
        $sheet->getStyle('A' . $dataHeaderRow . ':G' . $dataHeaderRow)->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '0D2640']
            ],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
            'border' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ]
            ]
        ]);

        // Data rows styling
        $startRow = $dataHeaderRow + 1;
        $endRow = $startRow + $this->laporan->count() - 1;

        if ($endRow >= $startRow) {
            $sheet->getStyle('A' . $startRow . ':G' . $endRow)->applyFromArray([
                'border' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                    ]
                ],
                'alignment' => ['vertical' => Alignment::VERTICAL_CENTER]
            ]);
        }

        return [];
    }
}
