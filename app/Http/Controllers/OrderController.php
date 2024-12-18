<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\TransactionExport;
use Maatwebsite\Excel\Facades\Excel;
use DB;
use PDF;

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
                    'customers.name as customer_name',
                    'users.name as created_by'
                )
                ->leftJoin('customers', 'customers.id', '=', 'transactions.customer_id')
                ->leftJoin('users', 'users.id', '=', 'transactions.created_by');

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
                        'transactions.payment_method',
                        'transactions.total_amount',
                        'transactions.status',
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

    public function printReceipt($id) {
        $detailTransaction = DB::table('transactions')
                    ->select(
                        'transactions.id',
                        'transactions.code',
                        DB::raw("TO_CHAR(transactions.transaction_date, 'DD FMMonth YYYY, HH24:MI:SS') as transaction_date"),
                        DB::raw("
                            CASE
                                WHEN transactions.payment_method = '1' THEN 'TUNAI'
                                WHEN transactions.payment_method = '2' THEN 'PIUTANG'
                                WHEN transactions.payment_method = '3' THEN 'COD'
                                WHEN transactions.payment_method = '4' THEN 'TRANSFER'
                            ELSE
                                '-'
                            END AS payment_method
                        "),
                        'transactions.total_amount',
                        'transactions.status',
                        'customers.name as customer_name',
                        'users.name as created_by',
                        'branches.name as branhces'
                    )
                    ->leftJoin('customers', 'customers.id', '=', 'transactions.customer_id')
                    ->leftJoin('users', 'users.id', '=', 'transactions.created_by')
                    ->leftJoin('branches', 'branches.id', '=', 'users.branch_id')
                    ->where('transactions.id', $id)->first();

        $detailItems = DB::table('transaction_items')
                    ->select(
                        'products.id',
                        'products.code',
                        'products.name',
                        'transaction_items.quantity',
                        'transaction_items.base_price',
                        'transaction_items.unit_price as sell_price')
                    ->leftJoin('products', 'products.id', '=', 'transaction_items.product_id')
                    ->where('transaction_id', $detailTransaction->id)->get()->map(function ($item) {
                        // Format the prices using number_format
                        $item->base_price = number_format($item->base_price, 0, '.', ','); // Format for money
                        $item->sell_price = number_format($item->sell_price, 0, '.', ','); // Format for money
                        return $item;
                    });

        $pdf = PDF::loadView('modules.transactions.order.receipt', [
            "info" => $detailTransaction,
            "items" => $detailItems
        ])->setPaper([0, 0, 330, 700]);

        return $pdf->stream('receipt.pdf'); // To display
    }
}
