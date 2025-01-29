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
}
