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
            ->where('branch_id', $branchId)
            ->where('status', '!=', 3);

        if (!empty($params['start_date']) && !empty($params['end_date'])) {
            $totalsQuery->whereBetween(DB::raw('DATE(transactions.transaction_date)'), [
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

        $totalTransactionsQuery = DB::table('transactions')->where('branch_id', $branchId);

        if (!empty($params['start_date']) && !empty($params['end_date'])) {
            $totalTransactionsQuery->whereBetween(DB::raw('DATE(transactions.transaction_date)'), [
                $params['start_date'],
                $params['end_date']
            ]);
        }

        $totalTransactions = $totalTransactionsQuery->count();

        // Format numbers
        $formattedTotals = [
            'total_transaction' => $totalTransactions,
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


    // public function getStockReport(Request $request) {
    //     $start_date = $request->input('start_date');
    //     $end_date = $request->input('end_date');
    //     $stock_status = $request->input('stock_status');
    //     $category_id = $request->input('category_id');

    //     $query = DB::table('stock_logs as sl')
    //         ->join('stocks as s', 'sl.stock_id', '=', 's.id')
    //         ->join('products as p', 's.product_id', '=', 'p.id')
    //         ->join('product_categories as pc', 'p.category_id', '=', 'pc.id')
    //         ->leftJoin('branches as b', 's.branch_id', '=', 'b.id')
    //         ->select([
    //             'p.code',
    //             'p.name as product_name',
    //             'pc.name as category_name',
    //             DB::raw("DATE(sl.date) as stock_logs_date"),
    //             'b.name as branch_name',
    //             DB::raw("SUM(sl.in_quantity) - SUM(sl.out_quantity) as quantity"),
    //             DB::raw("CASE 
    //                         WHEN SUM(sl.in_quantity) - SUM(sl.out_quantity) = 0 THEN 'Out of Stock' 
    //                         WHEN SUM(sl.in_quantity) - SUM(sl.out_quantity) < 50 THEN 'Low on Stock' 
    //                         ELSE 'In Stock' 
    //                     END as stock_status")
    //         ])
    //         ->whereBetween(DB::raw("DATE(sl.date)"), [$start_date, $end_date])
    //         ->groupBy('p.name', 'p.code', 'pc.name', DB::raw("DATE(sl.date)"), 'b.name')
    //         ->orderBy(DB::raw("DATE(sl.date)"), 'asc')
    //         ->orderBy('p.name', 'asc');

    //     // Apply category filter
    //     if ($category_id && $category_id != 'Show All') {
    //         $query->where('p.category_id', '=', $category_id);
    //     }

    //     // Apply stock_status filter using HAVING clause
    //     if ($stock_status && $stock_status != 'Show All') {
    //         if ($stock_status == 'In Stock') {
    //             $query->havingRaw("SUM(sl.in_quantity) - SUM(sl.out_quantity) >= 50");
    //         } elseif ($stock_status == 'Out of Stock') {
    //             $query->havingRaw("SUM(sl.in_quantity) - SUM(sl.out_quantity) = 0");
    //         } elseif ($stock_status == 'Low Stock') {
    //             $query->havingRaw("SUM(sl.in_quantity) - SUM(sl.out_quantity) BETWEEN 1 AND 49");
    //         }
    //     }

    //     // Clone query for pagination
    //     $paginatedQuery = clone $query;

    //     // Fetch total records
    //     $totalRecords = DB::table('stocks')->count();

    //     // Fetch filtered record count
    //     $filteredRecords = DB::table(DB::raw("({$query->toSql()}) as filtered"))
    //         ->mergeBindings($query)
    //         ->count();

    //     // Apply pagination
    //     $data = $paginatedQuery->skip($request->input('start', 0))
    //         ->take($request->input('length', 10))
    //         ->get();

    //     return response()->json([
    //         'draw' => $request->input('draw'),
    //         'recordsTotal' => $totalRecords,
    //         'recordsFiltered' => $filteredRecords,
    //         'data' => $data,
    //     ]);
    // }

    public function getStockReport(Request $request)
{
    $start_date = $request->input('start_date');
    $end_date = $request->input('end_date');
    $stock_status = $request->input('stock_status');
    $category_id = $request->input('category_id');
    $branch_id = $request->input('branch_id', 4);
    $start = (int) $request->input('start', 0);
    $length = (int) $request->input('length', 10);
    $draw = (int) $request->input('draw', 1);

    $bindings = [
        $start_date,
        $end_date,
        $branch_id,
    ];

    $sql = "
        WITH date_series AS (
            SELECT generate_series(?::date, ?::date, '1 day') AS log_date
        )
        SELECT 
            s.id, 
            p.code, 
            p.name AS product_name, 
            pc.name AS category_name,
            ds.log_date::date AS stock_logs_date,
            COALESCE((
                SELECT SUM(sl2.in_quantity) - SUM(sl2.out_quantity)
                FROM stock_logs sl2
                WHERE sl2.stock_id = s.id AND DATE(sl2.date) <= ds.log_date
            ), 0) AS quantity_per_date,
            CASE 
                WHEN COALESCE((
                    SELECT SUM(sl2.in_quantity) - SUM(sl2.out_quantity)
                    FROM stock_logs sl2
                    WHERE sl2.stock_id = s.id AND DATE(sl2.date) <= ds.log_date
                ), 0) <= 0 THEN 'Out of Stock'
                WHEN COALESCE((
                    SELECT SUM(sl2.in_quantity) - SUM(sl2.out_quantity)
                    FROM stock_logs sl2
                    WHERE sl2.stock_id = s.id AND DATE(sl2.date) <= ds.log_date
                ), 0) < 50 THEN 'Low on Stock'
                ELSE 'In Stock'
            END AS stock_status
        FROM date_series ds
        LEFT JOIN stocks s ON s.branch_id = ?
        LEFT JOIN products p ON p.id = s.product_id
        LEFT JOIN product_categories pc ON p.category_id = pc.id
    ";

    // Apply category filter
    if (is_numeric($category_id)) {
        $sql .= " WHERE p.category_id = ? ";
        $bindings[] = (int) $category_id;
    }

    $sql .= " ORDER BY ds.log_date, s.id ";

    $results = DB::select($sql, $bindings);
    $totalRecords = count($results);

    // Manual pagination
    $paginatedResults = array_slice($results, $start, $length);

    return response()->json([
        'draw' => $draw,
        'recordsTotal' => $totalRecords,
        'recordsFiltered' => $totalRecords,
        'data' => $paginatedResults,
    ]);
}


}
