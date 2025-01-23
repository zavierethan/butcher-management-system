<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Events\AfterSheet;

use DB;
use Auth;

class TransactionExport implements FromCollection, WithHeadings, WithCustomStartCell, WithEvents
{
    protected $filters;

    public function __construct(array $filters)
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        // Fetching data from the database
        $query = DB::table('transactions')
            ->select(
                'transactions.code as transaction_code',
                DB::raw("TO_CHAR(transactions.transaction_date, 'DD/MM/YYYY') as transaction_date"),
                'products.code',
                'products.name',
                'transaction_items.quantity',
                DB::raw("TO_CHAR(transaction_items.base_price, 'FM999,999,999') as base_price"),
                'transaction_items.discount',
                DB::raw("TO_CHAR(transaction_items.unit_price, 'FM999,999,999') as sell_price"),
                DB::raw("
                    CASE
                        WHEN transactions.payment_method = '1' THEN 'TUNAI'
                        WHEN transactions.payment_method = '2' THEN 'PIUTANG'
                        WHEN transactions.payment_method = '3' THEN 'COD'
                        ELSE 'TRANSFER'
                    END AS payment_method
                "),
                'transactions.status',
                DB::raw("
                    CASE
                        WHEN transactions.status = 1 THEN 'LUNAS'
                        WHEN transactions.status = 2 THEN 'PENDING'
                        ELSE 'BATAL'
                    END AS status
                "),
                'customers.name as customer_name',
                'users.name as cashier',
            )
            ->leftJoin('transaction_items', 'transaction_items.transaction_id', '=', 'transactions.id')
            ->leftJoin('products', 'products.id', '=', 'transaction_items.product_id')
            ->leftJoin('customers', 'customers.id', '=', 'transactions.customer_id')
            ->leftJoin('users', 'users.id', '=', 'transactions.created_by');

        if(Auth::user()->group_id != 1 || Auth::user()->branch_id != 1) {
            $query->where('transactions.branch_id', Auth::user()->branch_id);
        }

        if (!empty($this->filters['start_date']) && !empty($this->filters['end_date'])) {
            $query->whereBetween('transactions.transaction_date', [
                $this->filters['start_date'],
                $this->filters['end_date']
            ]);
        }

        if (!empty($this->filters['payment_method'])) {
            $query->where('transactions.payment_method', $this->filters['payment_method']);
        }

        if (!empty($this->filters['status'])) {
            $query->where('transactions.status', $this->filters['status']);
        }

        if (!empty($this->filters['branch_id'])) {
            $query->where('transactions.branch_id', $this->filters['branch_id']);
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
            'KODE TRANSAKSI',
            'TANGGAL TRANSAKSI',
            'CODE',
            'ITEM',
            'BERAT (KG)',
            'HARGA / KG',
            'DISKON',
            'TOTAL',
            'JENIS PEMBAYARAN',
            'STATUS PEMBAYARAN',
            'CUSTOMER',
            'KASIR',
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
