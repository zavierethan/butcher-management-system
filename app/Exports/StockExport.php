<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Events\AfterSheet;

use DB;
use Illuminate\Support\Carbon;

class StockExport implements FromCollection, WithHeadings, WithCustomStartCell, WithEvents
{
    protected $filters;

    public function __construct(array $filters)
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $branchId = $this->filters['branch_id'];

        // Fetching data from the database
        $logsToday = DB::table('stock_logs')
            ->select(
                'stock_logs.stock_id',
                DB::raw('DATE(stock_logs.date) AS tanggal_logs_transaksi'),
                DB::raw('SUM(stock_logs.in_quantity) AS stok_masuk'),
                DB::raw('SUM(stock_logs.out_quantity) AS stok_keluar')
            )
            ->whereRaw('DATE(stock_logs.date) = CURRENT_DATE')
            ->groupBy('stock_logs.stock_id', DB::raw('DATE(stock_logs.date)'));

        // Subquery: latest_opname (before today)
        $latestOpname = DB::table('stock_opnames')
            ->select('stock_opnames.stock_id', 'stock_opnames.quantity', 'stock_opnames.date')
            ->whereRaw('DATE(stock_opnames.date) < CURRENT_DATE')
            ->orderBy('stock_opnames.stock_id')
            ->orderByDesc('stock_opnames.date');

        // Wrap it in a distinct-on simulation using window function (Postgres only)
        $latestOpnameSub = DB::table(DB::raw("(
            SELECT DISTINCT ON (stock_id) stock_id, quantity, date
            FROM stock_opnames
            WHERE DATE(date) < CURRENT_DATE
            ORDER BY stock_id, date DESC
            ) AS latest_opname"));

        // Subquery: today_opname
        $todayOpname = DB::table(DB::raw("(
            SELECT DISTINCT ON (stock_id) stock_id, quantity, date
            FROM stock_opnames
            WHERE DATE(date) = CURRENT_DATE
            ORDER BY stock_id, date DESC
            ) AS today_opname"));

        $query = DB::table('stocks')
            ->leftJoin('products', 'products.id', '=', 'stocks.product_id')
            ->leftJoinSub($logsToday, 'logs_today', function ($join) {
                $join->on('stocks.id', '=', 'logs_today.stock_id');
            })
            ->leftJoinSub($latestOpnameSub, 'latest_opname', function ($join) {
                $join->on('stocks.id', '=', 'latest_opname.stock_id');
            })
            ->leftJoinSub($todayOpname, 'today_opname', function ($join) {
                $join->on('stocks.id', '=', 'today_opname.stock_id');
            })
            ->orderBy('products.sort_order', 'asc')
            ->select(
                'products.code',
                'products.name',
                'today_opname.date AS tanggal_stock_opname',
                DB::raw('COALESCE(latest_opname.quantity, 0) AS stock_awal'),
                DB::raw('COALESCE(logs_today.stok_masuk, 0) AS stok_masuk'),
                DB::raw('COALESCE(logs_today.stok_keluar, 0) AS stok_keluar'),
                DB::raw('COALESCE(latest_opname.quantity, 0) + COALESCE(logs_today.stok_masuk, 0) - COALESCE(logs_today.stok_keluar, 0) AS stock_akhir'),
                DB::raw('COALESCE(today_opname.quantity, 0) AS hasil_stock_opname'),
                DB::raw('(COALESCE(latest_opname.quantity, 0) + COALESCE(logs_today.stok_masuk, 0) - COALESCE(logs_today.stok_keluar, 0)) - COALESCE(today_opname.quantity, 0) AS selisih')
            );

        $query->where('stocks.branch_id', $branchId);

        $data = $query->get();

        return $data;
    }

    /**
    * Set headings for the table.
    *
    * @return array
    */
    public function headings(): array
    {
        return [
            'KODE PRODUK',
            'NAMA PRODUK',
            'TANGGAL STOCK OPNAME',
            'STOCK AWAL',
            'STOCK MASUK',
            'STOCK KELUAR',
            'STOCK AKHIR',
            'HASIL STOCK OPNAME',
            'SELISIH',
        ];
    }

    public function startCell(): string
    {
        return 'A5'; // Data starts at A5 (after the additional info rows)
    }

    public function registerEvents(): array
{
    return [
        AfterSheet::class => function (AfterSheet $event) {
            $sheet = $event->sheet;

            $printDateTime = $this->filters['print_date_time'];

            // Set content for A1 and B1
            $sheet->setCellValue('A1', 'CABANG (STORE)');
            $sheet->setCellValue('B1', $this->filters['branch_code'] . ' - ' . $this->filters['branch_name']);

            $sheet->setCellValue('A2', 'TANGGAL CETAK');
            $sheet->setCellValue('B2', $printDateTime);

            // Apply bold styling only to A1 (Rentang Tanggal)
            $sheet->getStyle('A1:A2')->applyFromArray([
                'font' => ['bold' => true],
            ]);

            // Apply bold styling to the headings
            $sheet->getStyle('A5:I5')->applyFromArray([
                'font' => ['bold' => true],
            ]);

            // Get the range of the table
            $rowCount = $sheet->getDelegate()->getHighestRow(); // Get last row with data
            $columnCount = $sheet->getDelegate()->getHighestColumn(); // Get last column with data

            // Set table range for borders
            $tableRange = "A5:{$columnCount}{$rowCount}";

            // Apply borders to the table
            $sheet->getStyle($tableRange)->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => '000000'],
                    ],
                ],
            ]);

            // Adjust the width of columns
            foreach (range('A', $columnCount) as $column) {
                $sheet->getColumnDimension($column)->setAutoSize(true);
            }
        },
    ];
}


}
