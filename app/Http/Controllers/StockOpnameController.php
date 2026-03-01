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
        $stocks = DB::table('stocks')
            ->leftJoin('products', 'stocks.product_id', '=', 'products.id')
            ->leftJoin('branches', 'stocks.branch_id', '=', 'branches.id')
            ->leftJoin('stock_logs as sl', 'stocks.id', '=', 'sl.stock_id')
            ->select(
                'stocks.id as stock_id',
                'products.id as product_id',
                'products.name as product_name',
                'branches.name as branch_name',
                DB::raw("SUM(CASE WHEN sl.mutation_type = 'IN' THEN sl.quantity ELSE 0 END) - SUM(CASE WHEN sl.mutation_type IN ('OUT', 'PRIVE') THEN sl.quantity ELSE 0 END) as current_stock")
            )
            ->where('stocks.branch_id', Auth::user()->branch_id)
            ->groupBy('stocks.id', 'products.id', 'products.name', 'branches.name')
            ->get();

        return view('modules.inventory.stock-opname.create', compact('branch', 'branches', 'stocks'));
    }

}
