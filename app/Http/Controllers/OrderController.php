<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\TransactionExport;
use Maatwebsite\Excel\Facades\Excel;
use DB;

class OrderController extends Controller
{
    public function index() {
        return view('modules.transactions.order.index');
    }

    public function getLists(Request $request){
        $params = $request->all();

        $query = DB::table('transactions')
                ->select(
                    'transactions.id',
                    'transactions.code',
                    'transactions.transaction_date',
                    DB::raw("TO_CHAR(transactions.transaction_date, 'DD/MM/YYYY') as transaction_date"),
                    'transactions.payment_method',
                    'transactions.total_amount',
                    'transactions.status',
                    'customers.name as customer_name')
                ->leftJoin('customers', 'customers.id', '=', 'transactions.customer_id');

        $start = $request->input('start', 0);
        $length = $request->input('length', 10);

        $totalRecords = $query->count();
        $filteredRecords = $query->count();
        $data = $query->orderBy('id', 'desc')->skip($start)->take($length)->get();

        return response()->json([
            'draw' => $request->input('draw'),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $data
        ]);
    }

    public function edit($id) {
        $detailTransaction = DB::table('transactions')
                    ->select(
                        'transactions.id',
                        'transactions.code',
                        DB::raw("TO_CHAR(transactions.transaction_date, 'DD/MM/YYYY') as transaction_date"),
                        DB::raw("
                            CASE
                                WHEN transactions.payment_method = '1' THEN 'TUNAI'
                                WHEN transactions.payment_method = '2' THEN 'PIUTANG'
                                WHEN transactions.payment_method = '3' THEN 'COD'
                                ELSE 'TRANSFER'
                            END AS payment_method
                        "),
                        'transactions.total_amount',
                        DB::raw("
                            CASE
                                WHEN transactions.status = 1 THEN 'LUNAS'
                                WHEN transactions.status = 2 THEN 'PENDING'
                                ELSE 'BATAL'
                            END AS status
                        "),
                        'customers.name as customer_name',
                    )
                    ->leftJoin('customers', 'customers.id', '=', 'transactions.customer_id')
                    ->where('transactions.id', $id)->first();

        $detailItems = DB::table('transaction_items')
                    ->select(
                        'products.id',
                        'products.code',
                        'products.name',
                        'products.url_path',
                        'transaction_items.quantity',
                        'transaction_items.base_price',
                        'transaction_items.unit_price as sell_price')
                    ->leftJoin('products', 'products.id', '=', 'transaction_items.product_id')
                    ->where('transaction_id', $detailTransaction->id)->get();

        return view('modules.transactions.order.edit', compact('detailTransaction', 'detailItems'));
    }

    public function export() {
        return Excel::download(new TransactionExport, 'siswa.xlsx');
    }
}
