<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithTitle;

use DB;
use Auth;

class SummaryExport implements FromCollection, WithHeadings, WithCustomStartCell, WithEvents, WithTitle
{
    protected $filters;

    public function __construct(array $filters)
    {
        $this->filters = $filters;
    }

    public function collection() {
        // Define possible payment methods (categories)
        $paymentMethods = [
            1 => 'TUNAI',
            2 => 'PIUTANG',
            3 => 'TRANSFER'
        ];

        // Initialize an array to store the results
        $results = [];
        $totalRevenue = 0;  // Variable to accumulate total revenue

        // Loop through each payment method (category 1, 2, 3)
        foreach ($paymentMethods as $paymentMethod => $paymentMethodName) {
            // Query for transactions with specific payment_method
            $query = DB::table('transactions')
                ->selectRaw("
                    '$paymentMethodName' AS payment_method_name,
                    TO_CHAR(COALESCE(SUM(total_amount), 0), 'FM999,999,999') AS total_amount
                ")
                ->where('branch_id', $this->filters['branch_id'])
                ->where('payment_method', $paymentMethod);

            if (!empty($params['start_date']) && !empty($params['end_date'])) {
                $query->whereBetween(DB::raw('DATE(transaction_date)'), [
                    $params['start_date'],
                    $params['end_date']
                ]);
            }

            if (!empty($this->filters['start_date']) && !empty($this->filters['end_date'])) {
                $query->whereDate('transactions.transaction_date', '>=', $this->filters['start_date'])
                    ->whereDate('transactions.transaction_date', '<=', $this->filters['end_date']);
            }

            // Get the result and store it
            $result = $query->first();

            // If no result, set total_amount to '0'
            if (!$result) {
                $result = (object) [
                    'payment_method_name' => $paymentMethodName,
                    'total_amount' => '0'
                ];
            }

            // Add to results array and accumulate total revenue
            $results[] = $result;
            $totalRevenue += (float)str_replace(',', '', $result->total_amount);  // Remove commas and accumulate
        }

        // Query for daily expenses
        $query2 = DB::table('daily_expenses')
            ->selectRaw("'PENGELUARAN TUNAI' AS payment_method_name, TO_CHAR(COALESCE(SUM(amount), 0), 'FM999,999,999') AS total_amount")
            ->where('branch_id', $this->filters['branch_id']);

        if (!empty($this->filters['start_date']) && !empty($this->filters['end_date'])) {
            $query2->whereBetween('date', [
                $this->filters['start_date'],
                $this->filters['end_date']
            ]);
        }

        // Get the result and add to the results array
        $dailyExpense = $query2->first();
        if ($dailyExpense) {
            $results[] = $dailyExpense;
        }

        // Add a row for Total Revenue
        $results[] = (object) [
            'payment_method_name' => 'TOTAL OMSET',
            'total_amount' => number_format($totalRevenue, 0, '.', ',') // Format the total revenue
        ];

        return collect($results);
    }

    public function headings(): array
    {
        return [
            'JENIS PEMASUKAN',
            'NOMINAL',
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

                $lastRow = $sheet->getHighestRow();

                // Add additional information above the table
                $sheet->setCellValue('A1', 'TANGGAL');
                $sheet->setCellValue('B1', date("d M Y", strtotime($this->filters['start_date'])).' - '.date("d M Y", strtotime($this->filters['end_date'])));
                $sheet->setCellValue('A2', 'CABANG');
                $sheet->setCellValue('B2', $this->filters['branch_name'].' ('.$this->filters['branch_code'].')');

                // Apply bold styling to the labels
                $sheet->getStyle('A1:A2')->applyFromArray([
                    'font' => ['bold' => true],
                ]);

                $sheet->getStyle('A5:B5')->applyFromArray([
                    'font' => ['bold' => true],
                ]);

                $sheet->getStyle("B2:B{$lastRow}")->applyFromArray([
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
                    ],
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

    public function title(): string
    {
        return 'Summary';
    }
}
