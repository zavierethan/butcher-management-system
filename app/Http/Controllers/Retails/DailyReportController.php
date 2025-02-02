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

public function getStockReport(Request $request) {
    $start_date = $request->input('start_date');
    $end_date = $request->input('end_date');
    $stock_status = $request->input('stock_status');
    $category_id = $request->input('category_id'); // Get selected category ID

    $query = DB::table('stocks as s')
        ->join('products as p', 's.product_id', '=', 'p.id')
        ->join('product_categories as pc', 'p.category_id', '=', 'pc.id')
        ->leftJoin('product_details as pd', function ($join) {
            $join->on('s.product_id', '=', 'pd.product_id')
                ->on('s.branch_id', '=', 'pd.branch_id');
        })
        ->leftJoin('branches as b', 's.branch_id', '=', 'b.id')
        ->select(
            'p.name as product_name',
            'p.code',
            'pc.name as category_name',
            's.date',
            'pd.price',
            'b.name as branch_name',
            's.quantity',
            DB::raw("CASE WHEN s.quantity > 0 THEN 'In Stock' WHEN s.quantity <= 0 THEN 'Out Of Stock' ELSE 'Low Stock' END AS stock_status")
        );

    if ($start_date && $end_date) {
        $query->whereBetween('s.date', [$start_date, $end_date]);
    }

    if ($stock_status && $stock_status != 'Show All') {
        if ($stock_status == 'In Stock') {
            $query->where('s.quantity', '>', 0);
        } elseif ($stock_status == 'Out of Stock') {
            $query->where('s.quantity', '<=', 0);
        } elseif ($stock_status == 'Low Stock') {
            $query->whereBetween('s.quantity', [1, 5]); // Adjust as needed for low stock range
        }
    }

    // Apply category filter if provided
    if ($category_id && $category_id != 'Show All') {
        $query->where('p.category_id', '=', $category_id);
    }

    $totalRecords = DB::table('stocks')->count(); // Total records without filters
    $filteredRecords = $query->count(); // Total records after filters
    $data = $query->orderBy('s.id', 'desc')->skip($request->input('start', 0))->take($request->input('length', 10))->get(); // Paginated data

    return response()->json([
        'draw' => $request->input('draw'),
        'recordsTotal' => $totalRecords,
        'recordsFiltered' => $filteredRecords,
        'data' => $data,
    ]);
}


}
