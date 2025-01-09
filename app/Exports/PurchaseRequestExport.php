<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Events\AfterSheet;

use DB;
use Auth;

class PurchaseRequestExport implements FromCollection, WithHeadings, WithCustomStartCell, WithEvents
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        // Fetching data from the database
        $query = DB::table('purchase_requests')
            ->select(
                'purchase_requests.request_number',
                DB::raw("TO_CHAR(purchase_requests.request_date, 'DD/MM/YYYY') as request_date"),
                'branches.name as alocation',
                'purchase_requests.pic',
                'purchase_request_items.category',
                'products.name',
                DB::raw("TO_CHAR(purchase_request_items.price, 'FM999,999,999') as price"),
                'purchase_request_items.quantity',
                DB::raw(" ' ' AS satuan"),
                DB::raw("TO_CHAR(purchase_request_items.quantity * purchase_request_items.price, 'FM999,999,999') as total_price"),
                DB::raw("
                    CASE
                        WHEN purchase_request_items.approval_status = 1 THEN 'APPROVE' ELSE 'DECLINE'
                    END as approval_status
                "),
                'purchase_request_items.realisation'
            )
            ->leftJoin('purchase_request_items', 'purchase_request_items.purchase_request_id', '=', 'purchase_requests.id')
            ->leftJoin('products', 'products.id', '=', 'purchase_request_items.item_id')
            ->leftJoin('branches', 'branches.id', '=', 'purchase_requests.alocation')
            ->whereBetween('purchase_requests.request_date', [$this->startDate, $this->endDate]);

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
            'NOMOR REQUEST',
            'TANGGAL',
            'ALOKASI',
            'PIC',
            'KATEGORI',
            'ITEM',
            'HARGA SATUAN',
            'QTY',
            'SATUAN',
            'HARGA (Rp)',
            'STATUS APPROVAL',
            'REALISASI',
            'HARGA AKTUAL',
            'SELISIH',
            'KETERANGAN',
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
