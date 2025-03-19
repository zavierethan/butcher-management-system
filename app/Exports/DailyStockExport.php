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
        // $query = DB::table('stock_logs as sl')
        //     ->join('stocks as s', 'sl.stock_id', '=', 's.id')
        //     ->join('products as p', 's.product_id', '=', 'p.id')
        //     ->join('product_categories as pc', 'p.category_id', '=', 'pc.id')
        //     ->leftJoin('branches as b', 's.branch_id', '=', 'b.id')
        //     ->leftJoin('product_details as pd', function ($join) {
        //         $join->on('pd.product_id', '=', 'p.id')
        //             ->on('pd.branch_id', '=', 'b.id');
        //     })
        //     ->leftJoin(DB::raw('(SELECT stock_id, DATE("date") AS opname_date, SUM(quantity) AS opname_quantity 
        //                         FROM stock_opnames 
        //                         GROUP BY stock_id, DATE("date")) as so'), function ($join) {
        //         $join->on('so.stock_id', '=', 's.id')
        //             ->on('so.opname_date', '=', DB::raw('DATE(sl.date)'));
        //     })
        //     ->select([
        //         DB::raw('DATE(sl.date) AS tanggal'),
        //         'b.name as branch_name',
        //         'p.name as product_name',
        //         DB::raw("COALESCE(SUM(CASE WHEN sl.reference IN ('Stock Opname') THEN sl.in_quantity ELSE 0 END), 0) AS stock_awal"),
        //         DB::raw("COALESCE(SUM(CASE WHEN sl.reference IN ('Hasil Parting') THEN sl.in_quantity ELSE 0 END), 0) AS parting_quantity"),
        //         DB::raw("COALESCE(SUM(CASE WHEN sl.reference NOT IN ('Stock Opname', 'Hasil Parting') THEN sl.in_quantity ELSE 0 END), 0) AS masuk"),
        //         DB::raw("COALESCE(SUM(CASE WHEN sl.reference != 'Stock Opname' THEN sl.out_quantity ELSE 0 END), 0) AS keluar"),
        //         DB::raw("SUM(sl.in_quantity - CASE WHEN sl.reference != 'Stock Opname' THEN sl.out_quantity ELSE 0 END) AS sisa"),
        //         DB::raw("COALESCE(so.opname_quantity, 0) AS opname_quantity"),
        //         DB::raw("SUM(sl.in_quantity - sl.out_quantity) - COALESCE(so.opname_quantity, 0) AS selisih"),
        //         DB::raw("COALESCE(SUM(CASE WHEN sl.reference NOT IN ('rusak') THEN sl.out_quantity * pd.price ELSE 0 END), 0) AS rp_terjual")
        //     ])
        //     ->whereBetween(DB::raw('DATE(sl.date)'), [
        //         $this->filters['start_date'],
        //         $this->filters['end_date']
        //     ])
        //     ->groupBy('p.name', 'pc.name', DB::raw('DATE(sl.date)'), 'b.name', 'so.opname_quantity')
        //     ->orderBy('b.name')
        //     ->orderBy('p.name');

        $query = DB::table('stock_logs as sl')
            ->join('stocks as s', 'sl.stock_id', '=', 's.id')
            ->join('products as p', 's.product_id', '=', 'p.id')
            ->join('product_categories as pc', 'p.category_id', '=', 'pc.id')
            ->leftJoin('branches as b', 's.branch_id', '=', 'b.id')
            ->leftJoin('product_details as pd', function ($join) {
                $join->on('pd.product_id', '=', 'p.id')
                    ->on('pd.branch_id', '=', 'b.id');
            })
            ->leftJoin(DB::raw('(SELECT stock_id, DATE("date") AS opname_date, SUM(quantity) AS opname_quantity 
                                FROM stock_opnames 
                                GROUP BY stock_id, DATE("date")) as so'), function ($join) {
                $join->on('so.stock_id', '=', 's.id')
                    ->on('so.opname_date', '=', DB::raw('DATE(sl.date)'));
            })
            ->leftJoin(DB::raw('(SELECT stock_id, DATE(date) AS prev_date, SUM(in_quantity) AS prev_stock_awal 
                                FROM stock_logs 
                                GROUP BY stock_id, DATE(date)) as prev_stock'), function ($join) {
                $join->on('prev_stock.stock_id', '=', 's.id')
                    ->on(DB::raw('prev_stock.prev_date'), '=', DB::raw("DATE(sl.date) - INTERVAL '1 day'"));
            })
            ->select([
                DB::raw('DATE(sl.date) AS tanggal'),
                'b.name as branch_name',
                'p.name as product_name',
                DB::raw("COALESCE(prev_stock.prev_stock_awal, 0) AS stock_awal"),
                DB::raw("COALESCE(SUM(CASE WHEN sl.reference IN ('Hasil Parting') THEN sl.in_quantity ELSE 0 END), 0) AS parting_quantity"),
                DB::raw("COALESCE(SUM(CASE WHEN sl.reference NOT IN ('Stock Opname', 'Hasil Parting') THEN sl.in_quantity ELSE 0 END), 0) AS masuk"),
                DB::raw("COALESCE(SUM(CASE WHEN sl.reference != 'Stock Opname' THEN sl.out_quantity ELSE 0 END), 0) AS keluar"),
                DB::raw("(COALESCE(prev_stock.prev_stock_awal, 0) + 
                    COALESCE(SUM(CASE WHEN sl.reference IN ('Hasil Parting') THEN sl.in_quantity ELSE 0 END), 0) + 
                    COALESCE(SUM(CASE WHEN sl.reference NOT IN ('Stock Opname', 'Hasil Parting') THEN sl.in_quantity ELSE 0 END), 0) - 
                    COALESCE(SUM(CASE WHEN sl.reference != 'Stock Opname' THEN sl.out_quantity ELSE 0 END), 0)) AS sisa"),
                DB::raw("COALESCE(so.opname_quantity, 0) AS opname_quantity"),
                DB::raw("((COALESCE(prev_stock.prev_stock_awal, 0) + 
                    COALESCE(SUM(CASE WHEN sl.reference IN ('Hasil Parting') THEN sl.in_quantity ELSE 0 END), 0) + 
                    COALESCE(SUM(CASE WHEN sl.reference NOT IN ('Stock Opname', 'Hasil Parting') THEN sl.in_quantity ELSE 0 END), 0) - 
                    COALESCE(SUM(CASE WHEN sl.reference != 'Stock Opname' THEN sl.out_quantity ELSE 0 END), 0)) 
                    - COALESCE(so.opname_quantity, 0)) AS selisih"),
                DB::raw("COALESCE(SUM(CASE WHEN sl.reference NOT IN ('rusak', 'mutasi', 'Stock Opname') THEN sl.out_quantity * pd.price ELSE 0 END), 0) AS rp_terjual")
            ])
            ->whereBetween(DB::raw('DATE(sl.date)'), [
                $this->filters['start_date'],
                $this->filters['end_date']
            ])
            ->groupBy('p.name', 'pc.name', DB::raw('DATE(sl.date)'), 'b.name', 'so.opname_quantity', 'prev_stock.prev_stock_awal')
            ->orderBy('b.name')
            ->orderBy('p.name');



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
                $sheet->getStyle('A5:K5')->applyFromArray(['font' => ['bold' => true]]);
                
                $rowCount = $sheet->getDelegate()->getHighestRow();
                $tableRange = "A5:K{$rowCount}";
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
