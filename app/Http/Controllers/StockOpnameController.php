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

        if (!empty($params['date'])) {
            $query->where(DB::raw('DATE(stock_opnames.date)'), $params['date']);
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
        $branchId = Auth::user()->branch_id;
        $startDate = now()->startOfDay();
        $endDate   = now()->endOfDay();

        $logsToday = DB::table('stock_logs')
            ->select(
                'stock_logs.stock_id',

                DB::raw("
                    DATE(stock_logs.date)
                    as tanggal_logs_transaksi
                "),

                DB::raw("
                    SUM(stock_logs.in_quantity)
                    as stok_masuk
                "),

                DB::raw("
                    SUM(stock_logs.out_quantity)
                    as stok_keluar
                ")
            )

            ->whereBetween('stock_logs.date', [
                $startDate,
                $endDate
            ])

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
                WHERE date < '{$startDate}'
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
                WHERE date BETWEEN '{$startDate}'
                AND '{$endDate}'
                ORDER BY stock_id, date DESC
            ) as today_opname
        "));

        $stocks = DB::table('stocks')

            ->leftJoin(
                'products',
                'products.id',
                '=',
                'stocks.product_id'
            )

            ->leftJoinSub($logsToday, 'logs_today', function ($join) {

                $join->on(
                    'stocks.id',
                    '=',
                    'logs_today.stock_id'
                );
            })

            ->leftJoinSub($latestOpname, 'latest_opname', function ($join) {

                $join->on(
                    'stocks.id',
                    '=',
                    'latest_opname.stock_id'
                );
            })

            ->leftJoinSub($todayOpname, 'today_opname', function ($join) {

                $join->on(
                    'stocks.id',
                    '=',
                    'today_opname.stock_id'
                );
            })

            ->where('stocks.branch_id', $branchId)

            ->whereNotIn('products.code', [
                'DLV',
                'RW'
            ])

            ->select(
                'stocks.id',
                'products.code as product_code',
                'products.name as product_name',
                DB::raw("
                    COALESCE(
                        logs_today.tanggal_logs_transaksi,
                        DATE('{$startDate}')
                    ) as tanggal_logs_transaksi
                "),
                DB::raw("
                    TO_CHAR(
                        latest_opname.date,
                        'DD/MM/YYYY'
                    ) as tanggal_stock_awal
                "),
                DB::raw("
                    TO_CHAR(
                        today_opname.date,
                        'DD/MM/YYYY'
                    ) as tanggal_stock_opname
                "),
                DB::raw("
                    COALESCE(
                        latest_opname.quantity,
                        0
                    ) as stock_awal
                "),
                DB::raw("
                    COALESCE(
                        logs_today.stok_masuk,
                        0
                    ) as stok_masuk
                "),
                DB::raw("
                    COALESCE(
                        logs_today.stok_keluar,
                        0
                    ) as stok_keluar
                "),
                DB::raw("
                    (
                        COALESCE(latest_opname.quantity, 0)
                        + COALESCE(logs_today.stok_masuk, 0)
                        - COALESCE(logs_today.stok_keluar, 0)
                    ) as stock_akhir
                "),
                DB::raw("
                    COALESCE(
                        today_opname.quantity,
                        0
                    ) as hasil_stock_opname
                "),
                DB::raw("
                    (
                        (
                            COALESCE(latest_opname.quantity, 0)
                            + COALESCE(logs_today.stok_masuk, 0)
                            - COALESCE(logs_today.stok_keluar, 0)
                        )
                        - COALESCE(today_opname.quantity, 0)
                    ) as selisih
                ")
            )
            ->orderBy('products.sort_order', 'asc')->get();

        return view('modules.inventory.stock-opname.create', compact('branch', 'stocks'));
    }

    public function save(Request $request) {
        $products = $request->input('products');

        DB::beginTransaction();

        try {
            foreach ($products as $productData) {
                $stockId = $productData['stock_id'];
                $opnameQuantity = $productData['quantity'] ?? 0;
                $date = $productData['date'] ?? now();

                // Insert into stock_opnames
                DB::table('stock_opnames')->insert([
                    "stock_id" => $stockId,
                    "quantity" => $opnameQuantity,
                    "date" => $date,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                DB::table('stocks')->where('id', $stockId)->update([
                    "current_stock" => $opnameQuantity,
                    "updated_at"    => now(),
                ]);
            }

            DB::commit();

            return response()->json(["message" => "Products updated successfully"]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["error" => "An error occurred while processing stock opnames."], 500);
        }
    }

}
