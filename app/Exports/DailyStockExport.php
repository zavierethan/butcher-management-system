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
use Carbon\Carbon;

use DB;
use Auth;

class DailyStockExport implements FromCollection, WithHeadings, 
    WithCustomStartCell, WithEvents, WithTitle, WithColumnFormatting {

    protected $filters;

    public function __construct(array $filters) {
        $this->filters = $filters;
    }

    public function collection() {
        // Subquery to calculate stock quantity
        $quantitySubquery = "(SELECT COALESCE(SUM(COALESCE(sl.in_quantity, 0) - COALESCE(sl.out_quantity, 0)), 0)
                            FROM stock_logs AS sl
                            WHERE sl.stock_id = s.id)";

        $query = DB::table('stocks as s')
            ->join('products as p', 's.product_id', '=', 'p.id')
            ->join('product_categories as pc', 'p.category_id', '=', 'pc.id')
            ->leftJoin('product_details as pd', function ($join) {
                $join->on('s.product_id', '=', 'pd.product_id')
                    ->on('s.branch_id', '=', 'pd.branch_id');
            })
            ->leftJoin('branches as b', 's.branch_id', '=', 'b.id')
            ->select([
                's.date',
                'p.code',
                'p.name as product_name',
                'pc.name as category_name',
                'pd.price',
                DB::raw("$quantitySubquery AS quantity"),
                DB::raw("CASE
                            WHEN $quantitySubquery > 0
                            THEN 'In Stock'
                            ELSE 'Out Of Stock'
                        END AS stock_status")
            ])
            ->groupBy(
                'p.name', 'p.code', 'pc.name', 's.date', 'pd.price', 'b.name', 's.id'
            )
            ->orderBy('s.date');

        if (Auth::user()->group_id != 1) {
            $query->where('s.branch_id', Auth::user()->branch_id);
        }

        if (!empty($this->filters['start_date']) && !empty($this->filters['end_date'])) {
            $query->whereBetween('date', [
                $this->filters['start_date'],
                $this->filters['end_date']
            ]);
        }

        return $query->get();
    }

    public function headings(): array {
        return [
            'TANGGAL',
            'KODE',
            'PRODUK',
            'KATEGORI',
            'HARGA',
            'JUMLAH',
            'STATUS',
        ];
    }

    public function startCell(): string {
        return 'A5';
    }

    public function registerEvents(): array {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;
                
                // Add additional information above the table
                $sheet->setCellValue('A1', 'TANGGAL');
                $sheet->setCellValue('B1', date("d M Y", strtotime($this->filters['start_date'])).' - '.date("d M Y", strtotime($this->filters['end_date'])));
                $sheet->setCellValue('A2', 'CABANG');
                $sheet->setCellValue('B2', $this->filters['branch_name'].' ('.$this->filters['branch_code'].')');
                $sheet->setCellValue('A3', 'LAPORAN DI-GENERATE PER TANGGAL');
                $sheet->setCellValue('B3', Carbon::now('Asia/Jakarta')->format('d M Y'));

                // Apply bold styling to the labels
                $sheet->getStyle('A1:A3')->applyFromArray([
                    'font' => ['bold' => true],
                ]);

                $sheet->getStyle('A5:G5')->applyFromArray([
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
            }
        ];
    }

    public function title(): string {
        return 'Data Stock';
    }

    public function columnFormats(): array {
        return [
            
        ];
    }
}