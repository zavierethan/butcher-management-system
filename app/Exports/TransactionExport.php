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
    protected $startDate;
    protected $endDate;
    protected $branchId;
    protected $branchName;
    protected $branchCode;

    public function __construct($startDate, $endDate, $branchId, $branchName, $branchCode)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->branchId = $branchId;
        $this->branchName = $branchName;
        $this->branchCode = $branchCode;
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
                'transaction_items.base_price',
                'transaction_items.unit_price as sell_price',
                'transaction_items.discount',
                DB::raw('transaction_items.unit_price - transaction_items.discount AS total'),
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
            ->leftJoin('users', 'users.id', '=', 'transactions.created_by')
            ->where('transactions.branch_id', $this->branchId)
            ->whereBetween('transactions.transaction_date', [$this->startDate, $this->endDate]);

        if(Auth::user()->group_id != 1 || Auth::user()->branch_id != 1) {
            $query->where('transactions.branch_id', Auth::user()->branch_id);
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
            'HARGA JUAL',
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
                $sheet->setCellValue('B1', $this->startDate.' - '.$this->endDate);
                $sheet->setCellValue('A2', 'CABANG');
                $sheet->setCellValue('B2', $this->branchName.' ('.$this->branchCode.')');

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
