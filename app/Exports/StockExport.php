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

        $startDate = !empty($this->filters['start_date']) ? $this->filters['start_date'] : Carbon::now('Asia/Jakarta')->toDateString();
        $endDate = !empty($this->filters['end_date']) ? $this->filters['end_date'] : Carbon::now('Asia/Jakarta')->toDateString();

        // Fetching data from the database
        $query = DB::table('stocks')
            ->leftJoin('products', 'stocks.product_id', '=', 'products.id')
            ->leftJoin('branches', 'stocks.branch_id', '=', 'branches.id')
            ->leftJoin('stock_logs as sl', 'stocks.id', '=', 'sl.stock_id')
            ->select(
                'products.code as product_code',
                'products.name as product_name',
                'branches.code as branch_code',
                'branches.name as branch_name',
                'stocks.quantity',
                DB::raw('COALESCE(SUM(sl.in_quantity), 0) - COALESCE(SUM(sl.out_quantity), 0) as realtime_quantity'),
                'stocks.opname_quantity',
                'stocks.date'
            )
            ->groupBy(
                'stocks.id',
                'products.code',
                'products.name',
                'branches.code',
                'branches.name'
            );

        $query->whereBetween('stocks.date', [$startDate, $endDate]);

        $searchValue = $this->filters['search_term'];
        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('products.name', 'ilike', '%' . $searchValue . '%');
            });
        }

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
            'KODE CABANG',
            'NAMA CABANG',
            'KUANTITAS AWAL',
            'KUANTITAS REALTIME',
            'KUANTITAS OPNAME',
            'TANGGAL',
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

            // Get today's date if start_date or end_date is null or empty
            $startDate = !empty($this->filters['start_date']) ? $this->filters['start_date'] : Carbon::now('Asia/Jakarta')->toDateString();
            $endDate = !empty($this->filters['end_date']) ? $this->filters['end_date'] : Carbon::now('Asia/Jakarta')->toDateString();

            // Set content for A1 and B1
            $sheet->setCellValue('A1', 'Rentang Tanggal');
            $sheet->setCellValue('B1', $startDate . ' - ' . $endDate);

            // Apply bold styling only to A1 (Rentang Tanggal)
            $sheet->getStyle('A1')->applyFromArray([
                'font' => ['bold' => true],
            ]);

            // Apply bold styling to the headings
            $sheet->getStyle('A5:H5')->applyFromArray([
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
