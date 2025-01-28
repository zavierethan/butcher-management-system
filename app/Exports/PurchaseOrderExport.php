<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Events\AfterSheet;

use DB;
use Auth;

class PurchaseOrderExport implements FromCollection, WithHeadings, WithCustomStartCell, WithEvents
{
    protected $filters;

    public function __construct(array $filters)
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        // Fetching data from the database
        $query = DB::table('purchase_orders')
                ->select(
                    DB::raw("ROW_NUMBER() OVER (ORDER BY purchase_orders.id) AS numbering"),
                    DB::raw("TO_CHAR(purchase_orders.order_date, 'DD/MM/YYYY') AS order_date"),
                    'branches.name as alocation',
                    'purchase_orders.purchase_order_number',
                    'products.code',
                    'products.name',
                    DB::raw("TO_CHAR(purchase_order_items.price, 'FM999,999,999') AS unit_price"),
                    'purchase_order_items.quantity',
                    DB::raw("TO_CHAR(purchase_order_items.price * purchase_order_items.quantity, 'FM999,999,999') AS total_price"),
                    DB::raw("TO_CHAR(purchase_order_items.received_price, 'FM999,999,999') AS received_price"),
                    'purchase_order_items.received_quantity',
                    DB::raw("TO_CHAR(purchase_order_items.received_price * purchase_order_items.received_quantity, 'FM999,999,999') AS actual_total_price"),
                    DB::raw("TO_CHAR((purchase_order_items.received_price * purchase_order_items.received_quantity) - (purchase_order_items.price * purchase_order_items.quantity), 'FM999,999,999') AS price_gap"),
                    DB::raw("
                                CASE
                                    WHEN purchase_order_items.realisation = 1 THEN 'TEREALISASI'
                                    ELSE 'TIDAK TEREALISASI'
                                END AS realisation_status
                            "),
                    'purchase_order_items.remarks'
                )
                ->leftJoin('purchase_order_items', 'purchase_order_items.purchase_order_id', '=', 'purchase_orders.id')
                ->leftJoin('purchase_request_items', 'purchase_request_items.id', '=', 'purchase_order_items.purchase_request_item_id')
                ->leftJoin('purchase_requests', 'purchase_requests.id', '=', 'purchase_request_items.purchase_request_id')
                ->leftJoin('products', 'products.id', '=', 'purchase_order_items.item_id')
                ->leftJoin('branches', 'branches.id', '=', 'purchase_requests.alocation');

            if (!empty($this->filters['start_date']) && !empty($this->filters['end_date'])) {
                $query->whereBetween('purchase_orders.order_date', [
                    $this->filters['start_date'],
                    $this->filters['end_date']
                ]);
            }

            if (!empty($this->filters['category'])) {
                $query->where('purchase_orders.category', $this->filters['category']);
            }

            if (!empty($this->filters['status'])) {
                $query->where('purchase_orders.status', $this->filters['status']);
            }

            if (!empty($this->filters['supplier'])) {
                $query->where('purchase_orders.supplier', $this->filters['supplier']);
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
            'NO.',
            'TANGGAL',
            'ALOKASI',
            'NOMOR PO',
            'KODE',
            'ITEM',
            'HARGA SATUAN',
            'QTY',
            'TOTAL HARGA',
            'HARGA SATUAN (AKTUAL)',
            'QTY (AKTUAL)',
            'TOTAL HARGA (AKTUAL)',
            'SELISIH',
            'REALISASI',
            'KETERANGAN',
        ];
    }

    public function startCell(): string
    {
        return 'A1';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;

                $sheet->getStyle('A1:O1')->applyFromArray([
                    'font' => ['bold' => true],
                ]);

                // Get the range of the table
                $rowCount = $sheet->getDelegate()->getHighestRow(); // Get last row with data
                $columnCount = $sheet->getDelegate()->getHighestColumn(); // Get last column with data

                $tableRange = "A1:{$columnCount}{$rowCount}";

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
