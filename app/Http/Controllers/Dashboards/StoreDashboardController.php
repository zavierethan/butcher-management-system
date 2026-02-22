<?php

namespace App\Http\Controllers\Dashboards;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;

class StoreDashboardController extends Controller
{
    public function getTransactionSummary(Request $request) {

        $results = DB::table('transactions')
            ->selectRaw("
                CASE
                    WHEN payment_method = '1' THEN 'Tunai'
                    WHEN payment_method = '2' THEN 'Piutang'
                    WHEN payment_method = '3' THEN 'Transfer'
                    ELSE 'Unknown'
                END AS payment_method_name,
                TO_CHAR(SUM(total_amount), 'FM999,999,999') AS total_amount
            ")
            ->where('branch_id', $request['branch_id'])
            ->whereDate('transaction_date', today())
            ->groupBy('payment_method')
            ->orderByRaw('payment_method_name')
            ->get();

        // Query to get the total amount of all transactions
        $totalAmount = DB::table('transactions')->where('branch_id', $request['branch_id'])->whereDate('transaction_date', today())->sum('total_amount');

        $totalExpenses = DB::table('daily_expenses')->where('branch_id', $request['branch_id'])->whereDate('date', today())->sum('amount');

        $formattedTotalAmount = number_format($totalAmount, 0, ',', ',');
        $formattedTotalExpenses = number_format($totalExpenses, 0, ',', ',');

        // Convert results to an array and append total_amount key
        return response()->json([
            'total_amount_by_category' => $results,
            'total_revenue' => $formattedTotalAmount,
            'total_expense' => $formattedTotalExpenses
        ]);
    }

    public function getProcessingOrderLists(Request $request) {
        $params = $request->all();

        $query = DB::table('transactions')
                ->select(
                    'transactions.id',
                    'transactions.code',
                    DB::raw("TO_CHAR(transactions.transaction_date, 'dd/mm/YYYY HH24:MI:SS') as transaction_date"),
                    'transactions.payment_method',
                    DB::raw("TO_CHAR(transactions.total_amount, 'FM999,999,999') as total_amount"),
                    'transactions.status',
                    'customers.name as customer_name',
                    'users.name as created_by'
                )
                ->leftJoin('customers', 'customers.id', '=', 'transactions.customer_id')
                ->leftJoin('users', 'users.id', '=', 'transactions.created_by')
                ->leftJoin('branches', 'branches.id', '=', 'users.branch_id')
                ->where('transactions.branch_id', Auth::user()->branch_id)
                ->where('transactions.working_method', 2);

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
}
