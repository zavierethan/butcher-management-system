<?php

namespace App\Http\Controllers\Retails;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Exports\DailyReportExport;
use Maatwebsite\Excel\Facades\Excel;

use DB;
use Auth;

class DailyReportController extends Controller
{
    public function index() {
        $branches = DB::table('branches')->get();
        return view('modules.retails.daily-report.index', compact('branches'));
    }

    public function getDataSummary(Request $request)
    {
        $branchId = Auth::user()->branch_id;
        $params = $request->all();

        // Fetch all totals in one query
        $totalsQuery = DB::table('transactions')
            ->selectRaw("
                SUM(CASE WHEN payment_method = '1' THEN total_amount ELSE 0 END) AS total_cash,
                SUM(CASE WHEN payment_method = '2' THEN total_amount ELSE 0 END) AS total_receivable,
                SUM(CASE WHEN payment_method = '3' THEN total_amount ELSE 0 END) AS total_transfer,
                SUM(total_amount) AS total_revenue,
                SUM(discount) AS total_discount"
            )
            ->where('branch_id', $branchId);

        if (!empty($params['date'])) {
            $totalsQuery->where(DB::raw('DATE(transactions.transaction_date)'), $params['date']);
        }

        $totals = $totalsQuery->first();

        $totalExpenses = DB::table('daily_expenses')
            ->selectRaw("
                COALESCE(SUM(CASE WHEN payment_method = '1' THEN amount ELSE 0 END), 0) AS total_cash,
                COALESCE(SUM(CASE WHEN payment_method = '2' THEN amount ELSE 0 END), 0) AS total_transfer
            ")
            ->where('branch_id', $branchId);

        if (!empty($params['date'])) {
            $totalExpenses->where(DB::raw('DATE(daily_expenses.date)'), $params['date']);
        }

        $totalExpenses = $totalExpenses->first();

        $totalCashInCasheer = DB::table('cash_movements as cm')
            ->join('pos_sessions as ps', 'cm.pos_session_id', '=', 'ps.id')
            ->where('ps.branch_id', $branchId)
            ->where(DB::raw('DATE(cm.created_at)'), '=', $params['date'])
            ->selectRaw("
                COALESCE(SUM(
                    CASE
                        WHEN cm.direction = 'IN' THEN cm.amount
                        ELSE -cm.amount
                    END
                ), 0) as total_cash
            ")
            ->value('total_cash');

        $totalTransactionsQuery = DB::table('transactions')->where('branch_id', $branchId)->where(DB::raw('DATE(transactions.transaction_date)'), $params['date']);

        $totalTransactions = $totalTransactionsQuery->count();

        // Format numbers
        $formattedTotals = [
            'total_transactions'      => $totalTransactions ?? 0,
            'total_revenue'           => $totals->total_revenue ?? 0,
            'total_cash'              => $totals->total_cash ?? 0,
            'total_discount'          => $totals->total_discount ?? 0,
            'total_transfer'          => $totals->total_transfer ?? 0,
            'total_cash_in_casheer'   => $totalCashInCasheer ?? 0,
            'total_cash_expanse'      => $totalExpenses->total_cash ?? 0,
            'total_transfer_expanse'  => $totalExpenses->total_transfer ?? 0,
            'total_cash_receive'      => 0
        ];

        return response()->json($formattedTotals);
    }

    public function getIncomeComposition(Request $request)
    {

        $branchId = Auth::user()->branch_id;
        $params = $request->all();

        // Fetch all totals in one query
        $totalsQuery = DB::table('transactions')
            ->selectRaw("
                SUM(CASE WHEN payment_method = '1' THEN total_amount ELSE 0 END) AS total_cash,
                SUM(CASE WHEN payment_method = '2' THEN total_amount ELSE 0 END) AS total_receivable,
                SUM(CASE WHEN payment_method = '3' THEN total_amount ELSE 0 END) AS total_transfer,
                SUM(total_amount) AS total_revenue,
                SUM(discount) AS total_discount"
            )
            ->where('branch_id', $branchId);

        if (!empty($params['date'])) {
            $totalsQuery->where(DB::raw('DATE(transactions.transaction_date)'), $params['date']);
        }

        $totals = $totalsQuery->first();

        $totalExpenses = DB::table('daily_expenses')
            ->selectRaw("
                COALESCE(SUM(CASE WHEN payment_method = '1' THEN amount ELSE 0 END), 0) AS total_cash,
                COALESCE(SUM(CASE WHEN payment_method = '2' THEN amount ELSE 0 END), 0) AS total_transfer
            ")
            ->where('branch_id', $branchId);

        if (!empty($params['date'])) {
            $totalExpenses->where(DB::raw('DATE(daily_expenses.date)'), $params['date']);
        }

        $totalExpenses = $totalExpenses->first();

        $formattedTotals = [
            'total_cash'                          => $totals->total_cash ?? 0,
            'total_transfer'                      => $totals->total_transfer ?? 0,
            'total_receivable'                    => $totals->total_receivable ?? 0,
            'total_cash_expanse'                  => $totalExpenses->total_cash ?? 0,
            'total_transfer_expanse'              => $totalExpenses->total_transfer ?? 0,
            'total_cash_payment_of_receivable'    => 0,
            'total_transfer_payment_of_receivable'=> 0,
        ];

        return response()->json($formattedTotals);

    }

    public function export(Request $request) {
        $filters = [
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'branch_id' => $request->branch_id,
        ];

        // Fetch branch details
        $branch = DB::table('branches')->where('id', $request->branch_id)->first();

        $filters['branch_name'] = $branch->name ?? null;
        $filters['branch_code'] = $branch->code ?? null;

        // Format the dates using PHP's date() function
        $startDate = date('d M Y', strtotime($request->start_date));
        $endDate = date('d M Y', strtotime($request->end_date));
        $filename = "Daily Report Tanggal {$startDate} - {$endDate}.xlsx";

        // Generate Excel data
        $export = new DailyReportExport($filters);
        $excelData = Excel::raw($export, \Maatwebsite\Excel\Excel::XLSX);

        // Return response with dynamic filename
        return response($excelData, 200, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            "Content-Disposition" => "attachment; filename=\"{$filename}\"",
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0',
        ]);
    }

    public function getDailyExpenses(Request $request) {
        $params = $request->all();
        $query = DB::table('daily_expenses')
            ->select(
                'daily_expenses.id',
                DB::raw("TO_CHAR(daily_expenses.date, 'DD/MM/YYYY') as date"),
                'daily_expenses.description',
                'daily_expenses.reference',
                DB::raw("TO_CHAR(daily_expenses.price, 'FM999,999,999') as price"),
                'daily_expenses.quantity',
                'daily_expenses.unit',
                DB::raw("TO_CHAR(daily_expenses.amount, 'FM999,999,999') as amount"),
                'daily_expenses.status',
                'daily_expenses.payment_method'
            )
            ->where('daily_expenses.branch_id', Auth::user()->branch_id);

        if (!empty($params['date'])) {
            $query->where('daily_expenses.date', $params['date']);
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
