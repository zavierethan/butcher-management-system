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

        $startDate = $this->filters['start_date'];
        $endDate = $this->filters['end_date'];
        $branchId = $this->filters['branch_id'];

        $query = DB::table(DB::raw("generate_series(CAST('$startDate' AS date), CAST('$endDate' AS date), interval '1 day') as d(date)"))
            ->crossJoin('stocks as s')
            ->leftJoin('stock_opnames as so', function ($join) {
                $join->on('so.stock_id', '=', 's.id')
                    ->on(DB::raw('so.date'), '=', DB::raw('d.date'));
            })
            ->leftJoin('products as p', 's.product_id', '=', 'p.id')
            ->leftJoin('product_details as pd', function ($join) {
                $join->on('pd.product_id', '=', 'p.id')
                    ->on('s.branch_id', '=', 'pd.branch_id');
            })
            ->leftJoin('branches as b', 'b.id', '=', 's.branch_id')
            ->select(
                'p.name as "Product Name"',
                'b.name as "Branch Name"',
                DB::raw('DATE(d.date) as "Tanggal"'),

                DB::raw("COALESCE((
                    SELECT SUM(sl.in_quantity) - SUM(sl.out_quantity)
                    FROM stock_logs sl
                    WHERE sl.stock_id = s.id AND sl.date < d.date
                ), 0) AS \"Stock Awal\""),

                DB::raw("COALESCE((
                    SELECT SUM(sl.in_quantity)
                    FROM stock_logs sl
                    WHERE sl.stock_id = s.id AND sl.date::date = d.date AND sl.reference ILIKE '%parting%'
                ), 0) AS \"Parting\""),

                DB::raw("COALESCE((
                    SELECT SUM(sl.in_quantity)
                    FROM stock_logs sl
                    WHERE sl.stock_id = s.id AND sl.date::date = d.date AND sl.reference ILIKE '%mutasi%'
                ), 0) AS \"Masuk\""),

                DB::raw("COALESCE((
                    SELECT SUM(sl.out_quantity)
                    FROM stock_logs sl
                    WHERE sl.stock_id = s.id AND sl.date::date = d.date AND sl.reference ILIKE '%prive%'
                ), 0) AS \"Keluar\""),

                DB::raw("COALESCE((
                    SELECT SUM(sl.out_quantity)
                    FROM stock_logs sl
                    WHERE sl.stock_id = s.id AND sl.date::date = d.date AND sl.reference ILIKE '%penjualan%'
                ), 0) AS \"Terjual\""),

                DB::raw("COALESCE((
                    SELECT SUM(sl.in_quantity) - SUM(sl.out_quantity)
                    FROM stock_logs sl
                    WHERE sl.stock_id = s.id AND sl.date < d.date
                ), 0) +
                COALESCE((
                    SELECT SUM(sl.in_quantity)
                    FROM stock_logs sl
                    WHERE sl.stock_id = s.id AND sl.date::date = d.date AND sl.reference ILIKE '%parting%'
                ), 0) +
                COALESCE((
                    SELECT SUM(sl.in_quantity)
                    FROM stock_logs sl
                    WHERE sl.stock_id = s.id AND sl.date::date = d.date AND sl.reference ILIKE '%mutasi%'
                ), 0) -
                COALESCE((
                    SELECT SUM(sl.out_quantity)
                    FROM stock_logs sl
                    WHERE sl.stock_id = s.id AND sl.date::date = d.date AND sl.reference ILIKE '%prive%'
                ), 0) -
                COALESCE((
                    SELECT SUM(sl.out_quantity)
                    FROM stock_logs sl
                    WHERE sl.stock_id = s.id AND sl.date::date = d.date AND sl.reference ILIKE '%penjualan%'
                ), 0) AS \"Sisa\""),

                DB::raw('so.quantity AS "Hasil SO"'),

                DB::raw("so.quantity - (
                    COALESCE((
                        SELECT SUM(sl.in_quantity) - SUM(sl.out_quantity)
                        FROM stock_logs sl
                        WHERE sl.stock_id = s.id AND sl.date < d.date
                    ), 0) +
                    COALESCE((
                        SELECT SUM(sl.in_quantity)
                        FROM stock_logs sl
                        WHERE sl.stock_id = s.id AND sl.date::date = d.date AND sl.reference ILIKE '%parting%'
                    ), 0) +
                    COALESCE((
                        SELECT SUM(sl.in_quantity)
                        FROM stock_logs sl
                        WHERE sl.stock_id = s.id AND sl.date::date = d.date AND sl.reference ILIKE '%mutasi%'
                    ), 0) -
                    COALESCE((
                        SELECT SUM(sl.out_quantity)
                        FROM stock_logs sl
                        WHERE sl.stock_id = s.id AND sl.date::date = d.date AND sl.reference ILIKE '%prive%'
                    ), 0) -
                    COALESCE((
                        SELECT SUM(sl.out_quantity)
                        FROM stock_logs sl
                        WHERE sl.stock_id = s.id AND sl.date::date = d.date AND sl.reference ILIKE '%penjualan%'
                    ), 0)
                ) AS \"Selisih\""),

                DB::raw("pd.price * 
                    COALESCE((
                        SELECT SUM(sl.out_quantity)
                        FROM stock_logs sl
                        WHERE sl.stock_id = s.id AND sl.date::date = d.date AND sl.reference ILIKE '%penjualan%'
                    ), 0) AS \"Rp Terjual\"")
            )
            ->where('s.branch_id', $branchId)
            ->orderBy('s.product_id')
            ->orderBy('Tanggal');

        return $query->get();
    }


    public function headings(): array {
        return [
            'Tanggal',
            'Cabang',
            'Produk',
            'Stock Awal',
            'Parting',
            'Masuk',
            'Keluar',
            'Terjual',
            'Sisa',
            'Hasil SO',
            'Selisih',
            'Rp Terjual',
        ];
    }

    public function startCell(): string {
        return 'A5';
    }

    public function registerEvents(): array {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;
                $sheet->setCellValue('A1', 'Tanggal');
                $sheet->setCellValue('B1', date("d M Y", strtotime($this->filters['start_date'])).' - '.date("d M Y", strtotime($this->filters['end_date'])));
                $sheet->setCellValue('A2', 'CABANG');
                $sheet->setCellValue('B2', $this->filters['branch_name'].' ('.$this->filters['branch_code'].')');
                $sheet->setCellValue('A3', 'LAPORAN DI-GENERATE PER TANGGAL');
                $sheet->setCellValue('B3', Carbon::now('Asia/Jakarta')->format('d M Y H:i:s'));
                $sheet->getStyle('A1:A3')->applyFromArray(['font' => ['bold' => true]]);
                $sheet->getStyle('A5:L5')->applyFromArray(['font' => ['bold' => true]]);
                
                $rowCount = $sheet->getDelegate()->getHighestRow();
                $tableRange = "A5:L{$rowCount}";
                $sheet->getStyle($tableRange)->applyFromArray([
                    'borders' => [
                        'allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => '000000']],
                    ],
                ]);
                foreach (range('A', 'J') as $column) {
                    $sheet->getColumnDimension($column)->setAutoSize(true);
                }
            }
        ];
    }

    public function title(): string {
        return 'Data Stock';
    }

    public function columnFormats(): array {
        return [];
    }
}
