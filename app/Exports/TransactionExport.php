<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;

class TransactionExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // Fetching data from the database
        return DB::table('transactions')
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
            ->get();
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
