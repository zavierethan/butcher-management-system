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
        $query = DB::table('stocks')
            ->leftJoin('products', 'stocks.product_id', '=', 'products.id')
            ->leftJoin('branches', 'stocks.branch_id', '=', 'branches.id')
            ->leftJoin('stock_logs as sl', 'stocks.id', '=', 'sl.stock_id')
            ->select(
                'products.code as product_code',
                'products.name as product_name',
                DB::raw('COALESCE(SUM(sl.in_quantity), 0) - COALESCE(SUM(sl.out_quantity), 0) AS quantity'),
            )
            ->groupBy(
                'products.code',
                'products.name',
            )
            ->orderBy('products.name');

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
            'KUANTITAS',
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
            $sheet->setCellValue('A1', 'Cabang');
            $sheet->setCellValue('B1', $this->filters['branch_code'] . ' - ' . $this->filters['branch_name']);

            $sheet->setCellValue('A2', 'Tanggal Cetak Laporan');
            $sheet->setCellValue('B2', $printDateTime);

            // Apply bold styling only to A1 (Rentang Tanggal)
            $sheet->getStyle('A1:A2')->applyFromArray([
                'font' => ['bold' => true],
            ]);

            // Apply bold styling to the headings
            $sheet->getStyle('A5:C5')->applyFromArray([
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
