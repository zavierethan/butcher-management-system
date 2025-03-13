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


    public function getStockReport(Request $request) {
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $stock_status = $request->input('stock_status');
        $category_id = $request->input('category_id');

        // Subquery to calculate stock quantity
        $quantitySubquery = "(SELECT COALESCE(SUM(COALESCE(sl.in_quantity, 0) - COALESCE(sl.out_quantity, 0)), 0)
                            FROM stock_logs AS sl
                            WHERE sl.stock_id = s.id)";

        $query = DB::table('stocks as s')
            ->join('products as p', 's.product_id', '=', 'p.id')
            ->join('product_categories as pc', 'p.category_id', '=', 'pc.id')
            ->leftJoin('product_details as pd', function ($join) {
                $join->on('s.product_id', '=', 'pd.product_id')
                    ->on('s.branch_id', '=', 'pd.branch_id');
            })
            ->leftJoin('branches as b', 's.branch_id', '=', 'b.id')
            ->select([
                'p.name as product_name',
                'p.code',
                'pc.name as category_name',
                's.date',
                's.sale_price',
                'b.name as branch_name',
                DB::raw("$quantitySubquery AS quantity"),
                DB::raw("CASE
                            WHEN $quantitySubquery > 0
                            THEN 'In Stock'
                            ELSE 'Out Of Stock'
                        END AS stock_status")
            ])
            ->groupBy(
                'p.name', 'p.code', 'pc.name', 's.date', 's.sale_price', 'b.name', 's.id'
            ); // All selected columns must be in GROUP BY

        // Apply filters
        if ($start_date && $end_date) {
            $query->whereBetween('s.date', [$start_date, $end_date]);
        }

        if ($category_id && $category_id != 'Show All') {
            $query->where('p.category_id', '=', $category_id);
        }

        // Apply stock_status filter using HAVING clause
        if ($stock_status && $stock_status != 'Show All') {
            if ($stock_status == 'In Stock') {
                $query->havingRaw("$quantitySubquery > 0");
            } elseif ($stock_status == 'Out of Stock') {
                $query->havingRaw("$quantitySubquery <= 0");
            } elseif ($stock_status == 'Low Stock') {
                $query->havingRaw("$quantitySubquery BETWEEN 1 AND 5");
            }
        }

        // Clone query for pagination
        $paginatedQuery = clone $query;

        // Fetch total records
        $totalRecords = DB::table('stocks')->count();

        // Fetch filtered record count
        $filteredRecords = DB::table(DB::raw("({$query->toSql()}) as filtered"))
            ->mergeBindings($query)
            ->count();

        // Apply pagination
        $data = $paginatedQuery->orderBy('s.id', 'desc')
            ->skip($request->input('start', 0))
            ->take($request->input('length', 10))
            ->get();

        return response()->json([
            'draw' => $request->input('draw'),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $data,
        ]);
    }

}
