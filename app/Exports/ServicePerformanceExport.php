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
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

use DB;
use Auth;

class ServicePerformanceExport implements FromCollection, WithHeadings, WithCustomStartCell, WithEvents, WithTitle
{
    protected $filters;

    public function __construct(array $filters)
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $branchId = $this->filters['branch_id'];
        $startDate = $this->filters['start_date'];
        $endDate = $this->filters['end_date'];

        // Get all products with their quantities per butcher
        $products = DB::table('product_details')
            ->join('products', 'products.id', '=', 'product_details.product_id')
            ->where('branch_id', $branchId)
            ->orderBy('products.sort_order')
            ->get(['product_details.id', 'products.name']);

        // Get all butchers
        $butchers = DB::table('butcherees')
            ->where('branch_id', $branchId)
            ->orderBy('name')
            ->get(['id', 'name']);

        // Build the data array
        $results = [];

        foreach ($products as $product) {
            $row = ['PRODUK' => $product->name];

            foreach ($butchers as $butcher) {
                // Get quantity for this product and butcher
                $quantity = DB::table('transaction_items as ti')
                    ->join('products as p', 'p.id', '=', 'ti.product_id')
                    ->join('transactions as t', 't.id', '=', 'ti.transaction_id')
                    ->where('t.branch_id', $branchId)
                    ->where('p.id', $product->id)
                    ->where('ti.butcherees_id', $butcher->id)
                    ->whereDate('t.transaction_date', '>=', $startDate)
                    ->whereDate('t.transaction_date', '<=', $endDate)
                    ->sum('ti.quantity');

                $row[$butcher->name] = $quantity ?? 0;
            }

            $results[] = (object)$row;
        }

        return collect($results);
    }

    public function headings(): array
    {
        // Get all butchers to create dynamic headings
        $butchers = DB::table('butcherees')
            ->where('branch_id', $this->filters['branch_id'])
            ->orderBy('name')
            ->pluck('name')
            ->toArray();

        return array_merge(['PRODUK'], $butchers);
    }

    public function startCell(): string
    {
        return 'A5';
    }

    public function title(): string
    {
        return 'Service Performance';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Add header information
                $sheet->setCellValue('A1', 'TANGGAL');
                $sheet->setCellValue('B1', date("d M Y", strtotime($this->filters['start_date'])).' - '.date("d M Y", strtotime($this->filters['end_date'])));
                $sheet->setCellValue('A2', 'CABANG');
                $sheet->setCellValue('B2', $this->filters['branch_name'].' ('.$this->filters['branch_code'].')');

                // Apply bold styling to labels
                $sheet->getStyle('A1:A2')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 11],
                ]);

                // Get the actual highest column
                $highestColumn = $sheet->getHighestColumn();

                // Header row styling
                $sheet->getStyle('A5:' . $highestColumn . '5')->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 11],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => '366092']
                    ],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'],
                        ],
                    ],
                ]);

                // Get last row with data
                $rowCount = $sheet->getHighestRow();

                // Data row styling
                for ($row = 6; $row <= $rowCount; $row++) {
                    $sheet->getStyle('A' . $row . ':' . $highestColumn . $row)->applyFromArray([
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => Border::BORDER_THIN,
                                'color' => ['rgb' => 'CCCCCC'],
                            ],
                        ],
                    ]);

                    // Format numbers (right align and thousands separator)
                    for ($col = 'B'; ord($col) <= ord($highestColumn); $col++) {
                        $cellValue = $sheet->getCell($col . $row)->getValue();
                        if (is_numeric($cellValue)) {
                            $sheet->getStyle($col . $row)->applyFromArray([
                                'alignment' => ['horizontal' => Alignment::HORIZONTAL_RIGHT],
                                'numberFormat' => ['formatCode' => '#,##0'],
                            ]);
                        }
                    }
                }

                // Column widths
                $sheet->getColumnDimension('A')->setWidth(25);
                for ($col = 'B'; ord($col) <= ord($highestColumn); $col++) {
                    $sheet->getColumnDimension($col)->setWidth(15);
                }

                // Freeze panes
                $sheet->freezePane('A6');
            }
        ];
    }
}
