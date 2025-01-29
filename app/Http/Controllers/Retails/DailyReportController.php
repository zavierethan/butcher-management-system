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
        return view('modules.retails.daily-report.index');
    }

    public function getDataSummary(Request $request)
    {
        $branchId = $request->input('branch_id');
        $params = $request->all();

        // Fetch all totals in one query
        $totalsQuery = DB::table('transactions')
            ->selectRaw("
                SUM(CASE WHEN payment_method = '1' THEN total_amount ELSE 0 END) AS total_cash,
                SUM(CASE WHEN payment_method = '2' THEN total_amount ELSE 0 END) AS total_receivable,
                SUM(CASE WHEN payment_method = '3' THEN total_amount ELSE 0 END) AS total_transfer,
                SUM(total_amount) AS total_revenue")
            ->where('branch_id', $branchId);

        if (!empty($params['start_date']) && !empty($params['end_date'])) {
            $totalsQuery->whereBetween('transactions.transaction_date', [
                $params['start_date'],
                $params['end_date']
            ]);
        }

        $totals = $totalsQuery->first();

        $expensesQuery = DB::table('daily_expenses')
            ->where('branch_id', $branchId);

        if (!empty($params['start_date']) && !empty($params['end_date'])) {
            $expensesQuery->whereBetween('daily_expenses.date', [
                $params['start_date'],
                $params['end_date']
            ]);
        }

        $totalExpenses = $expensesQuery->sum('amount');

        // Format numbers
        $formattedTotals = [
            'total_cash' => number_format($totals->total_cash, 0, ',', ','),
            'total_receivable' => number_format($totals->total_receivable, 0, ',', ','),
            'total_transfer' => number_format($totals->total_transfer, 0, ',', ','),
            'total_revenue' => number_format($totals->total_revenue, 0, ',', ','),
            'total_expense' => number_format($totalExpenses, 0, ',', ',')
        ];

        return response()->json($formattedTotals);
    }

    public function export(Request $request) {
        $filters = [
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'branch_id' => $request->branch_id,
        ];

        // Generate raw Excel data
        $branch = DB::table('branches')->where('id', $request->branch_id)->first();

        $filters['branch_name'] = $branch->name ?? null;
        $filters['branch_code'] = $branch->code ?? null;

        // Use MultiSheetExport for multiple sheets
        $export = new DailyReportExport($filters);

        $excelData = Excel::raw($export, \Maatwebsite\Excel\Excel::XLSX);

        // Return the file as a response
        return response($excelData, 200, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="transaction-reports.xlsx"',
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0',
        ]);
    }
}
