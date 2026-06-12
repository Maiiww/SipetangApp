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

        // Group by jenisIkan / jenis_ikan (normalized to Title Case)
        $groupedLaporan = $this->laporan->groupBy(function ($item) {
            return ucwords(strtolower(trim($item->jenisIkan ?? $item->jenis_ikan)));
        })->map(function ($items, $jenisIkan) {
            return (object) [
                'jenisIkan' => $jenisIkan,
                'beratTotal' => $items->sum(function ($i) { return $i->beratTotal ?? $i->berat; }),
                'harga_jual' => $items->sum('harga_jual'),
            ];
        });

        // Add summary section
        $rows[] = ['LAPORAN DATA MARITIM SIPETANG'];
        $rows[] = [];
        $rows[] = ['Tipe Laporan:', ucfirst(str_replace('_', ' ', $this->validated['laporan_type']))];
        $rows[] = ['Tanggal Generate:', now()->format('d/m/Y H:i:s')];
        $rows[] = ['Total Record (Jenis Ikan):', $groupedLaporan->count()];
        $rows[] = ['Total Berat (kg):', number_format($groupedLaporan->sum('beratTotal'), 2, ',', '.')];
        $rows[] = [];

        // Add data headers
        $rows[] = [
            'Jenis Ikan',
            'Berat Total (kg)',
            'Harga Jual'
        ];

        // Add data rows
        foreach ($groupedLaporan as $item) {
            $rows[] = [
                $item->jenisIkan,
                number_format($item->beratTotal, 2, ',', '.'),
                'Rp ' . number_format($item->harga_jual, 0, ',', '.'),
            ];
        }

        // Add TOTAL row at the bottom
        $rows[] = [
            'TOTAL:',
            number_format($groupedLaporan->sum('beratTotal'), 2, ',', '.') . ' kg',
            'Rp ' . number_format($groupedLaporan->sum('harga_jual'), 0, ',', '.'),
        ];

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
        $sheet->mergeCells('A1:C1');
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
        $sheet->getStyle('A' . $dataHeaderRow . ':C' . $dataHeaderRow)->applyFromArray([
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
        // The count of data rows is groupedLaporan count. Since we can't call groupedLaporan directly here, 
        // we can group the collection again.
        $groupedCount = $this->laporan->groupBy(function ($item) {
            return ucwords(strtolower(trim($item->jenisIkan ?? $item->jenis_ikan)));
        })->count();
        
        $endRow = $startRow + $groupedCount - 1;

        if ($endRow >= $startRow) {
            $sheet->getStyle('A' . $startRow . ':C' . ($endRow + 1))->applyFromArray([
                'border' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                    ]
                ],
                'alignment' => ['vertical' => Alignment::VERTICAL_CENTER]
            ]);
            // Make the TOTAL row bold
            $sheet->getStyle('A' . ($endRow + 1) . ':C' . ($endRow + 1))->getFont()->setBold(true);
        }

        return [];
    }
}
