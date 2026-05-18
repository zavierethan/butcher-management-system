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
            ->where('branch_id', $params['branch_id']);

        if (!empty($params['date'])) {
            $totalsQuery->where(DB::raw('DATE(transactions.transaction_date)'), $params['date']);
        }

        $totals = $totalsQuery->first();

        $totalExpenses = DB::table('daily_expenses')
            ->selectRaw("
                COALESCE(SUM(CASE WHEN payment_method = '1' THEN amount ELSE 0 END), 0) AS total_cash,
                COALESCE(SUM(CASE WHEN payment_method = '2' THEN amount ELSE 0 END), 0) AS total_transfer
            ")
            ->where('branch_id', $params['branch_id']);

        if (!empty($params['date'])) {
            $totalExpenses->where(DB::raw('DATE(daily_expenses.date)'), $params['date']);
        }

        $totalExpenses = $totalExpenses->first();

        $totalCash = DB::table('cash_movements as cm')
            ->join('pos_sessions as ps', 'cm.pos_session_id', '=', 'ps.id')
            ->where('ps.branch_id', $params['branch_id'])
            ->where(DB::raw('DATE(cm.created_at)'), '=', $params['date'])
            ->groupBy('ps.id', 'ps.closing_cash')
            ->selectRaw("
                ps.closing_cash,
                COALESCE(SUM(
                    CASE
                        WHEN cm.direction = 'IN' THEN cm.amount
                        ELSE -cm.amount
                    END
                ), 0) as total_cash
            ")
            ->first();

        $totalTransactionsQuery = DB::table('transactions')->where('branch_id', $params['branch_id'])->where(DB::raw('DATE(transactions.transaction_date)'), $params['date']);

        $totalTransactions = $totalTransactionsQuery->count();

        $totalReceivable = DB::table('receivable_payments')
            ->selectRaw("
                COALESCE(SUM(CASE WHEN payment_method = '1' THEN amount ELSE 0 END), 0) AS total_cash,
                COALESCE(SUM(CASE WHEN payment_method = '2' THEN amount ELSE 0 END), 0) AS total_transfer
            ")
            ->where('branch_id', $params['branch_id']);

        if (!empty($params['date'])) {
            $totalReceivable->where(DB::raw('DATE(receivable_payments.payment_date)'), $params['date']);
        }

        $totalReceivable = $totalReceivable->first();

        // Format numbers
        $formattedTotals = [
            'total_transactions'      => $totalTransactions ?? 0,
            'total_revenue'           => $totals->total_revenue ?? 0,
            'total_cash'              => $totals->total_cash ?? 0,
            'total_discount'          => $totals->total_discount ?? 0,
            'total_transfer'          => $totals->total_transfer ?? 0,
            'total_cash_in_casheer'   => $totalCash->total_cash ?? 0,
            'actual_cash_in_casheer'  => $totalCash->closing_cash ?? 0,
            'total_cash_expanse'      => $totalExpenses->total_cash ?? 0,
            'total_transfer_expanse'  => $totalExpenses->total_transfer ?? 0,
            'total_cash_payment_of_receivable'      => $totalReceivable->total_cash ?? 0,
            'total_transfer_payment_of_receivable'  => $totalReceivable->total_transfer ?? 0
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
            ->where('branch_id', $params['branch_id']);

        if (!empty($params['date'])) {
            $totalsQuery->where(DB::raw('DATE(transactions.transaction_date)'), $params['date']);
        }

        $totals = $totalsQuery->first();

        $totalExpenses = DB::table('daily_expenses')
            ->selectRaw("
                COALESCE(SUM(CASE WHEN payment_method = '1' THEN amount ELSE 0 END), 0) AS total_cash,
                COALESCE(SUM(CASE WHEN payment_method = '2' THEN amount ELSE 0 END), 0) AS total_transfer
            ")
            ->where('branch_id', $params['branch_id']);

        if (!empty($params['date'])) {
            $totalExpenses->where(DB::raw('DATE(daily_expenses.date)'), $params['date']);
        }

        $totalExpenses = $totalExpenses->first();

        $totalReceivable = DB::table('receivable_payments')
            ->selectRaw("
                COALESCE(SUM(CASE WHEN payment_method = '1' THEN amount ELSE 0 END), 0) AS total_cash,
                COALESCE(SUM(CASE WHEN payment_method = '2' THEN amount ELSE 0 END), 0) AS total_transfer
            ")
            ->where('branch_id', $params['branch_id']);

        if (!empty($params['date'])) {
            $totalReceivable->where(DB::raw('DATE(receivable_payments.payment_date)'), $params['date']);
        }

        $totalReceivable = $totalReceivable->first();

        $formattedTotals = [
            'total_cash'                          => $totals->total_cash ?? 0,
            'total_transfer'                      => $totals->total_transfer ?? 0,
            'total_receivable'                    => $totals->total_receivable ?? 0,
            'total_cash_expanse'                  => $totalExpenses->total_cash ?? 0,
            'total_transfer_expanse'              => $totalExpenses->total_transfer ?? 0,
            'total_cash_payment_of_receivable'    => $totalReceivable->total_cash ?? 0,
            'total_transfer_payment_of_receivable'=> $totalReceivable->total_transfer ?? 0,
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
                DB::raw("TO_CHAR(ROUND(daily_expenses.price::numeric), 'FM999,999,999') as price"),
                'daily_expenses.quantity',
                'daily_expenses.unit',
                DB::raw("TO_CHAR(ROUND(daily_expenses.amount::numeric), 'FM999,999,999') as amount"),
                'daily_expenses.status',
                'daily_expenses.payment_method'
            )
            ->where('daily_expenses.branch_id', $params['branch_id']);

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

    public function getReceivablePayments(Request $request) {
        $params = $request->all();
        $query = DB::table('receivable_payments')
            ->select(
                'receivable_payments.id',
                DB::raw("TO_CHAR(receivable_payments.payment_date, 'DD/MM/YYYY') as date"),
                DB::raw("TO_CHAR(ROUND(receivable_payments.amount::numeric), 'FM999,999,999') as amount"),
                'receivable_payments.payment_method',
                'customers.name as customer_name',
                'invoices.invoice_no as invoice_number'
            )
            ->leftJoin('invoices', 'invoices.id', '=', 'receivable_payments.invoice_id')
            ->leftJoin('customers', 'customers.id', '=', 'invoices.customer_id')
            ->where('receivable_payments.branch_id', $params['branch_id']);

        if (!empty($params['date'])) {
            $query->where(DB::raw('DATE(receivable_payments.payment_date)'), $params['date']);
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

    public function getDataFromPosSessions() {
        $branchId = Auth::user()->branch_id;
        $data = DB::table('pos_sessions as ps')
            ->leftJoin('cash_movements as cm', 'cm.pos_session_id', '=', 'ps.id')
            ->selectRaw("
                TO_CHAR(ROUND(ps.opening_cash::numeric), 'FM999,999,999') as opening_cash,
                TO_CHAR(ROUND(COALESCE(SUM(
                    CASE
                        WHEN cm.direction = 'IN' THEN cm.amount
                        WHEN cm.direction = 'OUT' THEN -cm.amount
                        ELSE 0
                    END
                ), 0)::numeric), 'FM999,999,999') as total_cash_in_cashier
            ")
            ->where('ps.branch_id', $branchId)
            ->where('ps.status', 'OPEN')
            ->where('ps.opened_at', '>=', now()->startOfDay())
            ->where('ps.opened_at', '<', now()->endOfDay())
            ->whereNull('ps.closed_at')
            ->groupBy('ps.id', 'ps.opening_cash')
            ->first();

        if(!$data) {
            return response()->json([
                'message' => 'Tidak ada sesi POS yang sedang terbuka untuk hari ini, Harap lakukan pembukaan sesi POS terlebih dahulu.'
            ] ,404);
        }

        return response()->json($data);
    }

    public function getProductQtyPivotToday(Request $request) {
        $branchId = $request->branch_id;
        $date = $request->date;

        // fallback jika date kosong
        if (empty($date)) {
            $date = now()->format('Y-m-d');
        }

        // 1. Ambil semua butcher master dengan id dan name
        $butchers = DB::table('butcherees')
            ->where('branch_id', $branchId)
            ->orderBy('name')
            ->get(['id', 'name']);

        // 2. Build dynamic pivot columns
        $columns = [];

        foreach ($butchers as $b) {

            // escape alias postgres
            $alias = str_replace('"', '""', $b->name);

            $columns[] = "
                COALESCE(
                    SUM(
                        CASE
                            WHEN ti.butcherees_id = ? THEN ti.quantity
                            ELSE 0
                        END
                    ),
                0) AS \"$alias\"
            ";
        }

        // 3. Main query
        $sql = "
            SELECT
                p.name AS \"PRODUK\",

                " . (
                    count($columns)
                        ? implode(",\n", $columns)
                        : "0 AS \"NO_DATA\""
                ) . "

            FROM products p

            LEFT JOIN (
                transaction_items ti
                INNER JOIN transactions t
                    ON t.id = ti.transaction_id
                    AND t.branch_id = ?
                    AND t.transaction_date >= ?
                    AND t.transaction_date < (?::date + INTERVAL '1 day')
            )
                ON ti.product_id = p.id

            WHERE p.code NOT IN ('DLV', 'RW')

            GROUP BY
                p.id,
                p.name,
                p.sort_order

            ORDER BY
                p.sort_order ASC
        ";

        // 4. Bindings
        $bindings = [];

        // binding butcherees_id untuk CASE WHEN
        foreach ($butchers as $b) {
            $bindings[] = $b->id;
        }

        // branch_id
        $bindings[] = $branchId;

        // start date
        $bindings[] = $date;

        // end date
        $bindings[] = $date;

        // 5. Execute
        $data = DB::select($sql, $bindings);

        return response()->json($data);
    }
}
