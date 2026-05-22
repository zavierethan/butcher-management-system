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

    public function getStockOpnameReport(Request $request) {
        $branchId = $request->branch_id;
        $dateStr = $request->date ?? now()->format('Y-m-d');

        $logsToday = DB::table('stock_logs')
            ->select(
                'stock_logs.stock_id',
                DB::raw("DATE(stock_logs.date) as tanggal_logs_transaksi"),
                DB::raw("SUM(CASE WHEN ref_type = 'PARTING' THEN in_quantity ELSE 0 END) as stok_parting"),
                DB::raw("SUM(CASE WHEN ref_type = 'IN'      THEN in_quantity ELSE 0 END) as stok_in"),
                DB::raw("SUM(CASE WHEN ref_type = 'OUT'     THEN out_quantity ELSE 0 END) as stok_out"),
                DB::raw("SUM(CASE WHEN ref_type = 'SALES'   THEN out_quantity ELSE 0 END) as stok_sales"),
                DB::raw("SUM(in_quantity)  as stok_masuk"),
                DB::raw("SUM(out_quantity) as stok_keluar")
            )
            ->where(DB::raw("DATE(stock_logs.date)"), $dateStr)
            ->groupBy(
                'stock_logs.stock_id',
                DB::raw('DATE(stock_logs.date)')
            );

        $latestOpname = DB::table(DB::raw("
            (
                SELECT DISTINCT ON (stock_id)
                    stock_id,
                    quantity,
                    date
                FROM stock_opnames
                WHERE DATE(date) < '{$dateStr}'
                ORDER BY stock_id, date DESC
            ) as latest_opname
        "));

        $todayOpname = DB::table(DB::raw("
            (
                SELECT DISTINCT ON (stock_id)
                    stock_id,
                    quantity,
                    date
                FROM stock_opnames
                WHERE DATE(date) = '{$dateStr}'
                ORDER BY stock_id, date DESC
            ) as today_opname
        "));

        $query = DB::table('stocks')
            ->leftJoin('products', 'products.id', '=', 'stocks.product_id')
            ->leftJoinSub($logsToday, 'logs_today', function ($join) {
                $join->on('stocks.id', '=', 'logs_today.stock_id');
            })
            ->leftJoinSub($latestOpname, 'latest_opname', function ($join) {
                $join->on('stocks.id', '=', 'latest_opname.stock_id');
            })
            ->leftJoinSub($todayOpname, 'today_opname', function ($join) {
                $join->on('stocks.id', '=', 'today_opname.stock_id');
            })
            ->where('stocks.branch_id', $branchId)
            ->whereNotIn('products.code', ['DLV', 'RW'])
            ->select(
                'stocks.id',
                'products.code',
                'products.name',

                // Tanggal
                DB::raw("COALESCE(logs_today.tanggal_logs_transaksi, '{$dateStr}'::date) as tanggal_logs_transaksi"),
                DB::raw("TO_CHAR(latest_opname.date, 'DD/MM/YYYY') as tanggal_stock_awal"),
                DB::raw("TO_CHAR(today_opname.date,  'DD/MM/YYYY') as tanggal_stock_opname"),

                // Stock Awal (dari opname terakhir sebelum hari ini)
                DB::raw("COALESCE(latest_opname.quantity, 0) as stock_awal"),

                // Stock Masuk dan Keluar
                DB::raw("COALESCE(logs_today.stok_masuk,   0) as stok_masuk"),
                DB::raw("COALESCE(logs_today.stok_keluar,  0) as stok_keluar"),

                // Breakdown per ref_type
                DB::raw("COALESCE(logs_today.stok_parting, 0) as stok_parting"),
                DB::raw("COALESCE(logs_today.stok_in,      0) as stok_in"),
                DB::raw("COALESCE(logs_today.stok_out,     0) as stok_out"),
                DB::raw("COALESCE(logs_today.stok_sales,   0) as stok_sales"),

                // Stock Akhir = awal + in - out
                DB::raw("
                    (
                        COALESCE(latest_opname.quantity,    0)
                        + COALESCE(logs_today.stok_in,   0)
                        - COALESCE(logs_today.stok_out,  0)
                    ) as stock_akhir
                "),

                // Hasil Stock Opname hari ini
                DB::raw("COALESCE(today_opname.quantity, 0) as hasil_stock_opname"),

                // Selisih = stock_akhir - hasil_so
                DB::raw("
                    (
                        (
                            COALESCE(latest_opname.quantity,   0)
                            + COALESCE(logs_today.stok_in,  0)
                            - COALESCE(logs_today.stok_out, 0)
                        )
                        - COALESCE(today_opname.quantity, 0)
                    ) as selisih
                ")
            )
            ->orderBy('products.sort_order', 'asc');

        // Search
        if ($request->filled('searchTerm')) {
            $search = $request->searchTerm;
            $query->where(function ($q) use ($search) {
                $q->where('products.name', 'ILIKE', "%{$search}%")
                ->orWhere('products.code', 'ILIKE', "%{$search}%");
            });
        }

        // Sorting
        $sortableColumns = [
            'code' => 'products.code',
            'name' => 'products.name',
        ];

        if ($request->has('order')) {
            $columnIndex = $request->order[0]['column'];
            $direction   = $request->order[0]['dir'];
            $columnName  = $request->columns[$columnIndex]['data'];
            if (isset($sortableColumns[$columnName])) {
                $query->orderBy($sortableColumns[$columnName], $direction);
            }
        }

        $start          = (int) $request->input('start', 0);
        $length         = (int) $request->input('length', 10);
        $filteredRecords = (clone $query)->count();
        $data           = $query->skip($start)->take($length)->get();

        return response()->json([
            'draw'            => $request->input('draw'),
            'recordsTotal'    => $filteredRecords,
            'recordsFiltered' => $filteredRecords,
            'data'            => $data,
        ]);
    }
}
