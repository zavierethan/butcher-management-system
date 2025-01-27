<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Events\AfterSheet;

use DB;
use Auth;

class StockExport implements FromCollection, WithHeadings, WithCustomStartCell, WithEvents
{
    protected $filters;

    public function __construct(array $filters)
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        // Fetching data from the database
    $query = DB::table('stocks')
        ->join('branches', 'stocks.branch_id', '=', 'branches.id')
        ->join('products', 'products.id', '=', 'stocks.product_id')
        ->select(
            'products.code as product_code',
            'products.name as product_name',
            'branches.code as branch_code',
            'branches.name as branch_name',
            'stocks.quantity as quantity',
            'stocks.opname_quantity as opname_quantity',
            'stocks.date as date'
        );

    if (!empty($this->filters['start_date']) && !empty($this->filters['end_date'])) {
        $query->whereBetween('stocks.date', [$this->filters['start_date'], $this->filters['end_date']]);
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
            'product_code',
            'product_name',
            'branch_code',
            'branch_name',
            'quantity',
            'opname_quantity',
            'date',
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

                // Add additional information above the table
                $sheet->setCellValue('A1', 'TANGGAL');
                $sheet->setCellValue('B1', $this->filters['start_date'].' - '.$this->filters['end_date']);
                $sheet->setCellValue('A2', 'CABANG');
                $sheet->setCellValue('B2', $this->filters['branch_name'].' ('.$this->filters['branch_code'].')');

                // Apply bold styling to the labels
                $sheet->getStyle('A1:A2')->applyFromArray([
                    'font' => ['bold' => true],
                ]);

                $sheet->getStyle('A5:M5')->applyFromArray([
                    'font' => ['bold' => true],
                ]);

                // Get the range of the table
                $rowCount = $sheet->getDelegate()->getHighestRow(); // Get last row with data
                $columnCount = $sheet->getDelegate()->getHighestColumn(); // Get last column with data

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

                // Auto-fit the content in all columns
                foreach (range('A', $columnCount) as $column) {
                    $sheet->getColumnDimension($column)->setAutoSize(true);
                }
            },
        ];
    }
}
