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

class TransactionExport implements FromCollection, WithHeadings, WithCustomStartCell, WithEvents, WithTitle, WithColumnFormatting
{
    protected $filters;

    public function __construct(array $filters)
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = DB::table('transactions')
            ->select(
                'transactions.code as transaction_code',
                DB::raw("TO_CHAR(transactions.transaction_date, 'DD/MM/YYYY') as transaction_date"),
                'products.code',
                'products.name',
                'transaction_items.quantity',
                'transaction_items.base_price', // Use raw numeric value
                'transaction_items.discount',
                'transaction_items.unit_price', // Use raw numeric value
                DB::raw("
                    CASE
                        WHEN transactions.payment_method = '1' THEN 'TUNAI'
                        WHEN transactions.payment_method = '2' THEN 'PIUTANG'
                        WHEN transactions.payment_method = '3' THEN 'COD'
                        ELSE 'TRANSFER'
                    END AS payment_method
                "),
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

        if (Auth::user()->group_id != 1) {
            $query->where('transactions.branch_id', Auth::user()->branch_id);
        }

        if (!empty($this->filters['start_date']) && !empty($this->filters['end_date'])) {
            $query->whereDate('transactions.transaction_date', '>=', $this->filters['start_date'])
                ->whereDate('transactions.transaction_date', '<=', $this->filters['end_date']);
        }

        if (!empty($this->filters['customer'])) {
            $query->where('transactions.customer_id', $this->filters['customer']);
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

        return $query->get();
    }

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
        return 'A5'; // Data starts at A5
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

                // Header row styling
                $sheet->getStyle('A5:L5')->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 11],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => '366092']
                    ],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER, 'wrapText' => true],
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
                    $sheet->getStyle('A' . $row . ':L' . $row)->applyFromArray([
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => Border::BORDER_THIN,
                                'color' => ['rgb' => 'CCCCCC'],
                            ],
                        ],
                    ]);

                    // Format numbers (right align)
                    $sheet->getStyle('E' . $row . ':H' . $row)->applyFromArray([
                        'alignment' => ['horizontal' => Alignment::HORIZONTAL_RIGHT],
                        'numberFormat' => ['formatCode' => '#,##0.00'],
                    ]);
                }

                // Column widths
                $sheet->getColumnDimension('A')->setWidth(16);
                $sheet->getColumnDimension('B')->setWidth(16);
                $sheet->getColumnDimension('C')->setWidth(12);
                $sheet->getColumnDimension('D')->setWidth(20);
                $sheet->getColumnDimension('E')->setWidth(12);
                $sheet->getColumnDimension('F')->setWidth(14);
                $sheet->getColumnDimension('G')->setWidth(12);
                $sheet->getColumnDimension('H')->setWidth(14);
                $sheet->getColumnDimension('I')->setWidth(16);
                $sheet->getColumnDimension('J')->setWidth(16);
                $sheet->getColumnDimension('K')->setWidth(20);
                $sheet->getColumnDimension('L')->setWidth(16);

                // Freeze panes
                $sheet->freezePane('A6');
            },
        ];
    }

    public function columnFormats(): array
    {
        return [
            'E' => '#,##0.00',
            'G' => '#,##0',
            'F' => '#,##0',
            'H' => '#,##0',
        ];
    }

    public function title(): string
    {
        return 'Data Penjualan';
    }
}
