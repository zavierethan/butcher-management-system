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
        $query = DB::table('stocks as s')
            ->leftJoin('products as p', 's.product_id', '=', 'p.id')
            ->leftJoin('branches as b', 's.branch_id', '=', 'b.id')
            ->leftJoin('stock_logs as sl', 'sl.stock_id', '=', 's.id')
            ->select([
                's.date as tanggal',
                'b.name as branch',
                'p.name as produk',
                's.quantity as stock_awal',
                DB::raw("COALESCE((SELECT SUM(pcr.quantity) 
                            FROM parting_cut_results pcr 
                            JOIN partings pt ON pcr.parting_id = pt.id
                            WHERE pcr.product_id = s.product_id 
                            AND pt.date = s.date
                            AND pt.branch_id = s.branch_id), 0) AS parting"),
                DB::raw("COALESCE(SUM(CASE 
                            WHEN sl.reference NOT IN ('Stock opname', 'Hasil Parting') 
                            THEN sl.in_quantity ELSE 0 END), 0) AS masuk"),
                DB::raw("COALESCE(SUM(sl.out_quantity), 0) AS keluar"),
                DB::raw("(s.quantity + 
                          COALESCE((SELECT SUM(pcr.quantity) 
                                    FROM parting_cut_results pcr 
                                    JOIN partings pt ON pcr.parting_id = pt.id
                                    WHERE pcr.product_id = s.product_id 
                                    AND pt.date = s.date
                                    AND pt.branch_id = s.branch_id), 0) + 
                          COALESCE(SUM(CASE 
                                    WHEN sl.reference NOT IN ('Stock opname', 'Hasil Parting') 
                                    THEN sl.in_quantity ELSE 0 END), 0) -
                          COALESCE(SUM(sl.out_quantity), 0)) AS sisa"),
                DB::raw("COALESCE(s.opname_quantity, 0) AS hasil_so"),
                DB::raw("((s.quantity + 
                          COALESCE((SELECT SUM(pcr.quantity) 
                                    FROM parting_cut_results pcr 
                                    JOIN partings pt ON pcr.parting_id = pt.id
                                    WHERE pcr.product_id = s.product_id 
                                    AND pt.date = s.date
                                    AND pt.branch_id = s.branch_id), 0) + 
                          COALESCE(SUM(CASE 
                                    WHEN sl.reference NOT IN ('Stock opname', 'Hasil Parting') 
                                    THEN sl.in_quantity ELSE 0 END), 0) -
                          COALESCE(SUM(sl.out_quantity), 0)) - 
                          COALESCE(s.opname_quantity, 0)) AS selisih"),
                DB::raw("COALESCE(SUM(sl.out_quantity), 0) * COALESCE(s.sale_price, 0) AS rp_terjual")
            ])
            ->whereBetween('s.date', [
                $this->filters['start_date'],
                $this->filters['end_date']
            ])
            ->groupBy('b.name', 'p.name', 's.quantity', 's.product_id', 's.opname_quantity', 's.sale_price', 's.date', 's.branch_id')
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
                $sheet->getStyle('A5:J5')->applyFromArray(['font' => ['bold' => true]]);
                
                $rowCount = $sheet->getDelegate()->getHighestRow();
                $tableRange = "A5:J{$rowCount}";
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
