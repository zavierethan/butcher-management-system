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

class StockLogExport implements FromCollection, WithHeadings, 
    WithCustomStartCell, WithEvents, WithTitle, WithColumnFormatting {

    protected $filters;

    public function __construct(array $filters) {
        $this->filters = $filters;
    }
            
    public function collection() {
        $query = DB::table('stocks')
            ->select(
                'products.code as product_code',
                'products.name as product_name',
                'stocks.quantity as starting_quantity',
                DB::raw('COALESCE(SUM(sl.in_quantity), 0) - COALESCE(SUM(sl.out_quantity), 0) as realtime_quantity'),
                'stocks.opname_quantity'
            )
            ->leftJoin('products', 'stocks.product_id', '=', 'products.id')
            ->leftJoin('stock_logs as sl', 'stocks.id', '=', 'sl.stock_id')
            ->where('stocks.id', $this->filters['stock_id'])
            ->groupBy('stocks.id', 'products.id', 'products.code', 'products.name');
        
        return $query->get();
    }

    public function headings(): array {
        return [
            'KODE',
            'PRODUK',
            'KUANTITAS AWAL',
            'KUANTITAS REALTIME',
            'KUANTITAS OPNAME'
        ];
    }

    public function startCell(): string {
        return 'A6';
    }

    public function registerEvents(): array {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;
                
                // Add general information
                $sheet->setCellValue('A1', 'CABANG');
                $sheet->setCellValue('B1', $this->filters['branch_name']);
                $sheet->setCellValue('A2', 'LAPORAN DI-GENERATE PER TANGGAL');
                $sheet->setCellValue('B2', Carbon::now('Asia/Jakarta')->format('d M Y'));
                $sheet->setCellValue("A5", 'STOCK HEADER');

                $sheet->getStyle('A1:A3')->applyFromArray(['font' => ['bold' => true]]);
                $sheet->getStyle('A5')->applyFromArray(['font' => ['bold' => true]]);
                $sheet->getStyle('A6:E6')->applyFromArray(['font' => ['bold' => true]]);

                // Apply borders for the first table
                $rowCount = $sheet->getDelegate()->getHighestRow();
                $tableRange = "A6:E{$rowCount}";
                $sheet->getStyle($tableRange)->applyFromArray([
                    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
                ]);

                // Insert the second dataset
                $stockLogs = DB::table('stock_logs')
                    ->select('reference', 'in_quantity', 'out_quantity', 'date')
                    ->where('stock_id', '=', $this->filters['stock_id'])
                    ->get();

                $startRow = $rowCount + 3; // Leave some space
                $sheet->setCellValue("A{$startRow}", 'STOCK LOGS');
                $sheet->setCellValue("A" . ($startRow + 1), 'REFERENSI');
                $sheet->setCellValue("B" . ($startRow + 1), 'KUANTITAS MASUK');
                $sheet->setCellValue("C" . ($startRow + 1), 'KUANTITAS KELUAR');
                $sheet->setCellValue("D" . ($startRow + 1), 'TANGGAL & JAM');

                $logRow = $startRow + 2;
                foreach ($stockLogs as $log) {
                    $formattedDate = Carbon::parse($log->date)->format('Y-m-d H:i:s'); // Format date

                    $sheet->setCellValue("A{$logRow}", $log->reference);
                    $sheet->setCellValue("B{$logRow}", $log->in_quantity);
                    $sheet->setCellValue("C{$logRow}", $log->out_quantity);
                    $sheet->setCellValue("D{$logRow}", $formattedDate); // Use formatted date
                    $logRow++;
                }

                // Apply bold styling
                $sheet->getStyle("A{$startRow}")->applyFromArray(['font' => ['bold' => true]]);
                $sheet->getStyle("A" . ($startRow + 1) . ":" . "D" . ($startRow + 1))->applyFromArray(['font' => ['bold' => true]]);

                // Apply border to the stock logs table
                $logEndRow = $logRow - 1; // Last row of data
                $logTableRange = "A" . ($startRow + 1) . ":D{$logEndRow}";
                $sheet->getStyle($logTableRange)->applyFromArray([
                    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
                ]);

                // Auto-fit column width
                foreach (range('A', 'D') as $column) {
                    $sheet->getColumnDimension($column)->setAutoSize(true);
                }
            }
        ];
    }

    public function title(): string {
        return 'Data Stock Log';
    }

    public function columnFormats(): array {
        return [
            
        ];
    }
}