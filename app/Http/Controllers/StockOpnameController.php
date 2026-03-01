<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;

class StockOpnameController extends Controller
{
    public function index()
    {
        return view('modules.inventory.stock-opname.index');
    }

    public function getLists(Request $request)
    {
        $params = $request->all();

        $query = DB::table('stock_opnames')
            ->leftJoin('stocks', 'stock_opnames.stock_id', '=', 'stocks.id')
            ->leftJoin('products', 'stocks.product_id', '=', 'products.id')
            ->select(
                DB::raw("TO_CHAR(stock_opnames.date, 'dd/mm/YYYY') as date"),
                'products.name as product_name',
                'stock_opnames.quantity',
            )
            ->where('stocks.branch_id', Auth::user()->branch_id);

        if (!empty($params['start_date']) && !empty($params['end_date'])) {
            $query->whereBetween(DB::raw('DATE(stock_opnames.date)'), [
                $params['start_date'],
                $params['end_date']
            ]);
        }

        $start = $request->input('start', 0);
        $length = $request->input('length', 10);

        // Count total and filtered records
        $totalRecords = $query->count();
        $filteredRecords = $query->count();

        $data = $query
            ->orderBy('stock_opnames.date', 'desc')
            ->orderBy('products.sort_order', 'asc')
            ->skip($start)
            ->take($length)
            ->get();

        $response = [
            'draw' => $request->input('draw'),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $data
        ];

        return response()->json($response);
    }

    public function create()
    {
        $branch = DB::table('branches')->where('id', Auth::user()->branch_id)->first();

        // Subquery: logs_today
        $logsToday = DB::table('stock_logs')
            ->select(
                'stock_logs.stock_id',
                DB::raw('DATE(stock_logs.date) AS tanggal_logs_transaksi'),
                DB::raw('SUM(stock_logs.in_quantity) AS stok_masuk'),
                DB::raw('SUM(stock_logs.out_quantity) AS stok_keluar')
            )
            ->whereRaw('DATE(stock_logs.date) = CURRENT_DATE')
            ->groupBy('stock_logs.stock_id', DB::raw('DATE(stock_logs.date)'));

        // Subquery: latest_opname (before today)
        $latestOpname = DB::table('stock_opnames')
            ->select('stock_opnames.stock_id', 'stock_opnames.quantity', 'stock_opnames.date')
            ->whereRaw('DATE(stock_opnames.date) < CURRENT_DATE')
            ->orderBy('stock_opnames.stock_id')
            ->orderByDesc('stock_opnames.date');

        // Wrap it in a distinct-on simulation using window function (Postgres only)
        $latestOpnameSub = DB::table(DB::raw("(
            SELECT DISTINCT ON (stock_id) stock_id, quantity, date
            FROM stock_opnames
            WHERE DATE(date) < CURRENT_DATE
            ORDER BY stock_id, date DESC
            ) AS latest_opname"));

        // Subquery: today_opname
        $todayOpname = DB::table(DB::raw("(
            SELECT DISTINCT ON (stock_id) stock_id, quantity, date
            FROM stock_opnames
            WHERE DATE(date) = CURRENT_DATE
            ORDER BY stock_id, date DESC
            ) AS today_opname"));

        $stocks = DB::table('stocks')
            ->leftJoin('products', 'products.id', '=', 'stocks.product_id')
            ->leftJoinSub($logsToday, 'logs_today', function ($join) {
                $join->on('stocks.id', '=', 'logs_today.stock_id');
            })
            ->leftJoinSub($latestOpnameSub, 'latest_opname', function ($join) {
                $join->on('stocks.id', '=', 'latest_opname.stock_id');
            })
            ->leftJoinSub($todayOpname, 'today_opname', function ($join) {
                $join->on('stocks.id', '=', 'today_opname.stock_id');
            })
            ->where('stocks.branch_id', Auth::user()->branch_id)
            ->orderBy('products.sort_order', 'asc')
            ->select(
                'stocks.id',
                'products.code as product_code',
                'products.name as product_name',
                DB::raw('COALESCE(logs_today.tanggal_logs_transaksi, CURRENT_DATE) AS tanggal_logs_transaksi'),
                DB::raw("TO_CHAR(latest_opname.date, 'dd/mm/YYYY') as tanggal_stock_awal"),
                'today_opname.date AS tanggal_stock_opname',
                DB::raw('COALESCE(latest_opname.quantity, 0) AS stock_awal'),
                DB::raw('COALESCE(logs_today.stok_masuk, 0) AS stok_masuk'),
                DB::raw('COALESCE(logs_today.stok_keluar, 0) AS stok_keluar'),
                DB::raw('COALESCE(latest_opname.quantity, 0) + COALESCE(logs_today.stok_masuk, 0) - COALESCE(logs_today.stok_keluar, 0) AS stock_akhir'),
                DB::raw('COALESCE(today_opname.quantity, 0) AS hasil_stock_opname'),
                DB::raw('COALESCE(today_opname.quantity, 0) - (COALESCE(latest_opname.quantity, 0) + COALESCE(logs_today.stok_masuk, 0) - COALESCE(logs_today.stok_keluar, 0)) AS selisih')
            )
            ->get();

        return view('modules.inventory.stock-opname.create', compact('branch', 'stocks'));
    }

}
