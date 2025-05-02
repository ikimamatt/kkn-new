<?php

namespace App\Exports;

use App\Models\Finance;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class FinanceExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    public function collection()
    {
        return Finance::with('user')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Tanggal',
            'Tipe',
            'Kategori',
            'Nama Barang',
            'Jumlah',
            'Harga Satuan',
            'Total',
            'Deskripsi',
            'Dibuat Oleh',
            'Dibuat Pada',
            'Diperbarui Pada',
        ];
    }

    public function map($finance): array
    {
        return [
            $finance->id,
            $finance->date,
            ucfirst($finance->type),
            $finance->category,
            $finance->item_name,
            $finance->quantity,
            number_format($finance->unit_price, 0, ',', '.'),
            number_format($finance->total, 0, ',', '.'),
            $finance->description,
            optional($finance->user)->name ?? 'N/A',
            $finance->created_at->format('Y-m-d H:i'),
            $finance->updated_at->format('Y-m-d H:i'),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $rowCount = $sheet->getHighestRow();
        $colCount = $sheet->getHighestColumn();

        // All Sells
        $sheet->getStyle('A1:' . $colCount . $rowCount)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ]);

        // Header
        $sheet->getStyle('A1:' . $colCount . '1')->applyFromArray([
            'font' => [
                'bold' => true,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => 'FFD9D9D9',
                ],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Kolom yang diratakan ke tengah
        $centeredColumns = ['A', 'B', 'C', 'E', 'F', 'G', 'H', 'J', 'K', 'L'];

        foreach ($centeredColumns as $col) {
            $sheet->getStyle($col . '2:' . $col . $rowCount)->getAlignment()
                ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                ->setVertical(Alignment::VERTICAL_CENTER);
        }

        $sheet->getStyle('A2:A' . $rowCount)->applyFromArray([
            'font' => [
                'bold' => true,
            ],
        ]);

        return [];
    }

}

