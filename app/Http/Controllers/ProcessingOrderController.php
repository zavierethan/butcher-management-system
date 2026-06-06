<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;

class ProcessingOrderController extends Controller
{
    public function index() {
        return view('modules.transactions.processing-order.index');
    }

    public function getLists(Request $request){
        $params = $request->all();

        $query = DB::table('transaction_staging')
                ->leftJoin('customers', 'customers.id', '=', 'transaction_staging.customer_id')
                ->leftJoin('users', 'users.id', '=', 'transaction_staging.created_by')
                ->select(
                    'transaction_staging.id',
                    'transaction_staging.code',
                    DB::raw("TO_CHAR(transaction_staging.date, 'dd/mm/YYYY HH24:MI:SS') as date"),
                    'transaction_staging.status',
                    'customers.name as customer_name',
                    'users.name as created_by'
                );

        if (!empty($params['start_date']) && !empty($params['end_date'])) {
            $query->whereBetween(DB::raw('DATE(transaction_staging.date)'), [
                $params['start_date'],
                $params['end_date']
            ]);
        }

        // Apply global search if provided
        $searchValue = $request->input('search.value'); // This is where DataTables sends the search input
        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('transaction_staging.code', 'like', '%' . strtoupper($searchValue) . '%');
            });
        }

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

    public function create() {
        return view('modules.transactions.processing-order.create');
    }

    public function edit($id) {
        $detailTransaction = DB::table('transaction_staging')
                    ->select(
                        'transaction_staging.id',
                        'transaction_staging.code',
                        DB::raw("TO_CHAR(transaction_staging.transaction_date, 'DD/MM/YYYY') as transaction_date"),
                        'transaction_staging.payment_method',
                        'transaction_staging.transfer_ref',
                        'transaction_staging.transfer_attch',
                        'transaction_staging.discount',
                        'transaction_staging.shipping_cost',
                        'transaction_staging.total_amount',
                        'transaction_staging.status',
                        'customers.name as customer_name',
                        'transaction_staging.butcher_name',
                        'users.name as created_by',
                        'transaction_staging.ordering_method',
                        'transaction_staging.working_method',
                    )
                    ->leftJoin('customers', 'customers.id', '=', 'transaction_staging.customer_id')
                    ->leftJoin('users', 'users.id', '=', 'transaction_staging.created_by')
                    ->where('transaction_staging.id', $id)->first();

        $detailItems = DB::table('transaction_items')
                    ->select(
                        'products.id',
                        'products.code',
                        'products.name',
                        'butcherees.name as butcher_name',
                        'products.url_path',
                        'transaction_items.quantity',
                        'transaction_items.base_price',
                        'transaction_items.unit_price as sell_price',
                        'transaction_items.discount'
                    )
                    ->leftJoin('products', 'products.id', '=', 'transaction_items.product_id')
                    ->leftJoin('butcherees', 'butcherees.id', '=', 'transaction_items.butcherees_id')
                    ->where('transaction_id', $detailTransaction->id)->get();

        $customerComplaints = DB::table('customer_complaints')
                    ->where('transaction_id', $detailTransaction->id)
                    ->first();

        return view('modules.transactions.order.edit', compact('detailTransaction', 'detailItems', 'customerComplaints'));
    }

    public function update(Request $request) {

        DB::table('transactions')->where('id', $request->transaction_id)->update([
            "payment_method" => $request->payment_method,
            "status" => $request->status
        ]);

        return response()->json([
            'message' => 'Transaction successfully updated',
        ], 200);
    }
}
