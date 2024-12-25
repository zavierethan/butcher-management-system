<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;
use Auth;

class TransactionExport implements FromCollection, WithHeadings
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
        $query = DB::table('transactions')
            ->select(
                'transactions.code as transaction_code',
                DB::raw("TO_CHAR(transactions.transaction_date, 'DD/MM/YYYY') as transaction_date"),
                'products.code',
                'products.name',
                'transaction_items.quantity',
                'transaction_items.base_price',
                'transaction_items.unit_price as sell_price',
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
            )
            ->leftJoin('transaction_items', 'transaction_items.transaction_id', '=', 'transactions.id')
            ->leftJoin('products', 'products.id', '=', 'transaction_items.product_id')
            ->leftJoin('customers', 'customers.id', '=', 'transactions.customer_id')
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
            'TOTAL (Rp)',
            'JENIS PEMBAYARAN',
            'STATUS PEMBAYARAN',
            'CUSTOMER',
        ];
    }
}
