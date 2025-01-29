<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\TransactionExport;
use Maatwebsite\Excel\Facades\Excel;
use DB;
use PDF;
use Auth;

class OrderController extends Controller
{
    public function index() {
        $branches =  DB::table('branches')->where('is_active', 1)->get();
        $customers =  DB::table('customers')->orderBy('name', 'asc')->get();
        return view('modules.transactions.order.index', compact('branches', 'customers'));
    }

    public function getLists(Request $request){
        $params = $request->all();

        $query = DB::table('transactions')
                ->select(
                    'transactions.id',
                    'transactions.code',
                    DB::raw("TO_CHAR(transactions.transaction_date, 'DD/MM/YYYY') as transaction_date"),
                    'transactions.payment_method',
                    DB::raw("TO_CHAR(transactions.total_amount, 'FM999,999,999') as total_amount"),
                    'transactions.status',
                    'customers.name as customer_name',
                    'users.name as created_by'
                )
                ->leftJoin('customers', 'customers.id', '=', 'transactions.customer_id')
                ->leftJoin('users', 'users.id', '=', 'transactions.created_by')
                ->leftJoin('branches', 'branches.id', '=', 'users.branch_id');

        if(Auth::user()->group_id != 1) {
            $query->where('transactions.branch_id', Auth::user()->branch_id);
        }

        if (!empty($params['start_date']) && !empty($params['end_date'])) {
            $query->whereBetween('transactions.transaction_date', [
                $params['start_date'],
                $params['end_date']
            ]);
        }

        if (!empty($params['customer'])) {
            $query->where('transactions.customer_id', $params['customer']);
        }

        if (!empty($params['payment_method'])) {
            $query->where('transactions.payment_method', $params['payment_method']);
        }

        if (!empty($params['status'])) {
            $query->where('transactions.status', $params['status']);
        }

        if (!empty($params['branch_id'])) {
            $query->where('transactions.branch_id', $params['branch_id']);
        }

        // Apply global search if provided
        $searchValue = $request->input('search.value'); // This is where DataTables sends the search input
        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('transactions.code', 'like', '%' . strtoupper($searchValue) . '%');
            });
        }

        // Apply sorting
        if ($request->has('order') && $request->order) {
            $columnIndex = $request->order[0]['column']; // Column index from the DataTable
            $sortDirection = $request->order[0]['dir']; // 'asc' or 'desc'
            $columnName = $request->columns[$columnIndex]['data']; // Column name

            $query->orderBy($columnName, $sortDirection);
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

    public function edit($id) {
        $detailTransaction = DB::table('transactions')
                    ->select(
                        'transactions.id',
                        'transactions.code',
                        DB::raw("TO_CHAR(transactions.transaction_date, 'DD/MM/YYYY') as transaction_date"),
                        'transactions.payment_method',
                        'transactions.discount',
                        'transactions.shipping_cost',
                        'transactions.total_amount',
                        'transactions.status',
                        'customers.name as customer_name',
                        'transactions.butcher_name',
                        'users.name as created_by'
                    )
                    ->leftJoin('customers', 'customers.id', '=', 'transactions.customer_id')
                    ->leftJoin('users', 'users.id', '=', 'transactions.created_by')
                    ->where('transactions.id', $id)->first();

        $detailItems = DB::table('transaction_items')
                    ->select(
                        'products.id',
                        'products.code',
                        'products.name',
                        'products.url_path',
                        'transaction_items.quantity',
                        'transaction_items.base_price',
                        'transaction_items.unit_price as sell_price',
                        'transaction_items.discount'
                    )
                    ->leftJoin('products', 'products.id', '=', 'transaction_items.product_id')
                    ->where('transaction_id', $detailTransaction->id)->get();

        return view('modules.transactions.order.edit', compact('detailTransaction', 'detailItems'));
    }

    public function update(Request $request) {

        DB::table('transactions')->where('id', $request->transaction_id)->update([
            "status" => $request->status
        ]);

        return response()->json([
            'message' => 'Transaction successfully updated',
        ], 200);
    }

    public function export(Request $request) {

        $filters = [
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'branch_id' => $request->branch_id,
            'payment_method' => $request->payment_method,
            'status' => $request->status,
        ];

        // Generate raw Excel data
        $branch = DB::table('branches')->where('id', $request->branch_id)->first();

        $filters['branch_name'] = $branch->name ?? null;
        $filters['branch_code'] = $branch->code ?? null;

        $export = new TransactionExport($filters);
        $excelData = Excel::raw($export, \Maatwebsite\Excel\Excel::XLSX);

        // Return the data as a proper response
        return response($excelData, 200, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="transaction-reports.xlsx"',
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0',
        ]);
    }

    public function printReceipt($id) {
        $detailTransaction = DB::table('transactions')
                    ->select(
                        'transactions.id',
                        'transactions.code',
                        DB::raw("TO_CHAR(transactions.transaction_date, 'dd/mm/YYYY') as transaction_date"),
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
                        'transactions.discount',
                        'transactions.shipping_cost',
                        'transactions.total_amount',
                        'transactions.status',
                        'customers.name as customer_name',
                        'users.name as created_by',
                        'branches.name as branhces',
                        'branches.address',
                        'branches.phone_number'
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
                        'transaction_items.discount',
                        'transaction_items.unit_price as sell_price'
                    )
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

    public function printThermal($id) {
        $info = DB::table('transactions')
                    ->select(
                        'transactions.id',
                        'transactions.code',
                        DB::raw("TO_CHAR(transactions.transaction_date, 'dd/mm/YYYY') as transaction_date"),
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
                        'transactions.discount',
                        'transactions.shipping_cost',
                        'transactions.total_amount',
                        'transactions.status',
                        'customers.name as customer_name',
                        'users.name as created_by',
                        'branches.name as branhces',
                        'branches.address',
                        'branches.phone_number'
                    )
                    ->leftJoin('customers', 'customers.id', '=', 'transactions.customer_id')
                    ->leftJoin('users', 'users.id', '=', 'transactions.created_by')
                    ->leftJoin('branches', 'branches.id', '=', 'users.branch_id')
                    ->where('transactions.id', $id)->first();

        $items = DB::table('transaction_items')
                    ->select(
                        'products.id',
                        'products.code',
                        'products.name',
                        'transaction_items.quantity',
                        'transaction_items.base_price',
                        'transaction_items.discount',
                        'transaction_items.unit_price as sell_price'
                    )
                    ->leftJoin('products', 'products.id', '=', 'transaction_items.product_id')
                    ->where('transaction_id', $info->id)->get()->map(function ($item) {
                        // Format the prices using number_format
                        $item->base_price = number_format($item->base_price, 0, '.', ','); // Format for money
                        $item->sell_price = number_format($item->sell_price, 0, '.', ','); // Format for money
                        return $item;
                    });


        return view('modules.transactions.order.thermal-print', compact('info', 'items'));
    }
}
