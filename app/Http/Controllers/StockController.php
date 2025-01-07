<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class StockController extends Controller
{
    public function index() {
        return view('modules.inventory.stock.index');
    }

    public function getLists(Request $request) {

        $params = $request->all();

        $query = DB::table('stocks')
            ->leftJoin('products', 'stocks.product_id', '=', 'products.id')
            ->leftJoin('branches', 'stocks.branch_id', '=', 'branches.id')
            ->select(
                'stocks.*',
                'products.code as product_code',
                'products.name as product_name',
                'branches.code as branch_code',
                'branches.name as branch_name'
            );

        $start = $request->input('start', 0);
        $length = $request->input('length', 10);

        $totalRecords = $query->count();
        $filteredRecords = $query->count();
        $data = $query->orderBy('id', 'desc')->skip($start)->take($length)->get();

        $response = [
            'draw' => $request->input('draw'),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $data
        ];

        return response()->json($response);
    }

    public function create() {
        $branches = DB::table('branches')->orderBy('name', 'asc')->get();
        $products = DB::table('products')->orderBy('name', 'asc')->get();

        return view('modules.inventory.stock.create', compact('branches', 'products'));
    }

    public function save(Request $request) {
        $baseUrl = config('app.url');

        DB::table('stocks')->insertGetId([
            "product_id" => $request->product_id,
            "branch_id" => $request->branch_id,
            "quantity" => $request->quantity,
            "date" => $request->calendar_event_date
        ]);

        return redirect()->route('stocks.index');
    }
}
