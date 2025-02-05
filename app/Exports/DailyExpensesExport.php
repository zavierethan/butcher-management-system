<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Border;

use DB;
use Auth;

class DailyExpensesExport implements FromCollection, WithHeadings, WithCustomStartCell, WithEvents, WithTitle, WithColumnFormatting
{
    protected $filters;

    public function __construct(array $filters)
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = DB::table('daily_expenses')
            ->select(
                DB::raw("TO_CHAR(date, 'DD/MM/YYYY') as transaction_date"),
                'description',
                'reference',
                DB::raw("
                    CASE
                        WHEN payment_method = 1 THEN 'TUNAI' ELSE 'TRANSFER'
                    END AS payment_method
                "),
                'amount',
            );

        if (Auth::user()->group_id != 1) {
            $query->where('branch_id', Auth::user()->branch_id);
        }

        if (!empty($this->filters['start_date']) && !empty($this->filters['end_date'])) {
            $query->whereBetween('date', [
                $this->filters['start_date'],
                $this->filters['end_date']
            ]);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'TANGGAL',
            'DESKRIPSI',
            'REFERENSI',
            'JENIS PEMBAYARAN',
            'TOTAL NOMINAL',
        ];
    }

    public function startCell(): string
    {
        return 'A5'; // Data starts at A5
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;

                // Add additional information above the table
                $sheet->setCellValue('A1', 'TANGGAL');
                $sheet->setCellValue('B1', date("d M Y", strtotime($this->filters['start_date'])).' - '.date("d M Y", strtotime($this->filters['end_date'])));
                $sheet->setCellValue('A2', 'CABANG');
                $sheet->setCellValue('B2', $this->filters['branch_name'].' ('.$this->filters['branch_code'].')');

                // Apply bold styling to the labels
                $sheet->getStyle('A1:A2')->applyFromArray([
                    'font' => ['bold' => true],
                ]);

                $sheet->getStyle('A5:E5')->applyFromArray([
                    'font' => ['bold' => true],
                ]);

                // Apply borders to the table
                $rowCount = $sheet->getDelegate()->getHighestRow(); // Get last row with data
                $columnCount = $sheet->getDelegate()->getHighestColumn(); // Get last column with data

                $tableRange = "A5:{$columnCount}{$rowCount}";

                $sheet->getStyle($tableRange)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => '000000'], // Black color
                        ],
                    ],
                ]);

                // Auto-fit the content in all columns
                foreach (range('A', $columnCount) as $column) {
                    $sheet->getColumnDimension($column)->setAutoSize(true);
                }
            },
        ];
    }

    public function columnFormats(): array
    {
        return [
            'E' => '#,##0'
        ];
    }

    public function title(): string
    {
        return 'Data Pengeluaran';
    }
}
