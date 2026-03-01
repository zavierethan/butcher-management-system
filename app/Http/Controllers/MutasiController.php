<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;

class MutasiController extends Controller
{
    public function index()
    {
        return view('modules.inventory.mutasi.index');
    }

    public function getLists(Request $request)
    {
        $params = $request->all();

        $query = DB::table('stock_mutations')
            ->leftJoin('stocks', 'stock_mutations.stock_id', '=', 'stocks.id')
            ->select(
                DB::raw("TO_CHAR(stock_mutations.mutation_date, 'dd/mm/YYYY') as date"),
                DB::raw("SUM(CASE WHEN stock_mutations.mutation_type = 'IN' THEN stock_mutations.quantity ELSE 0 END) as total_in"),
                DB::raw("SUM(CASE WHEN stock_mutations.mutation_type = 'OUT' THEN stock_mutations.quantity ELSE 0 END) as total_out"),
                DB::raw("SUM(CASE WHEN stock_mutations.mutation_type = 'PRIVE' THEN stock_mutations.quantity ELSE 0 END) as total_prive")
            )
            ->where('stocks.branch_id', Auth::user()->branch_id)
            ->groupBy(DB::raw("TO_CHAR(stock_mutations.mutation_date, 'dd/mm/YYYY')"));

        $start = $request->input('start', 0);
        $length = $request->input('length', 10);

        // Count total and filtered records
        $totalRecords = $query->count();
        $filteredRecords = $query->count();

        $data = $query->orderBy('date', 'desc')->skip($start)->take($length)->get();

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
        $branches = DB::table('branches')->whereNotIn('id', [$branch->id])->get();
        $stocks = DB::table('stocks')
            ->leftJoin('products', 'stocks.product_id', '=', 'products.id')
            ->leftJoin('branches', 'stocks.branch_id', '=', 'branches.id')
            ->leftJoin('stock_logs as sl', 'stocks.id', '=', 'sl.stock_id')
            ->select(
                'stocks.id as stock_id',
                'products.id as product_id',
                'products.code as product_code',
                'products.name as product_name',
            )
            ->where('stocks.branch_id', Auth::user()->branch_id)
            ->groupBy(
                'stocks.id',
                'products.id',
                'products.code',
                'products.name',
                'products.sort_order'
            )->orderBy('products.sort_order', 'asc')->get();

        return view('modules.inventory.mutasi.create', compact('stocks', 'branch', 'branches'));
    }
}
