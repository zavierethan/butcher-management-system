<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Log;
use Illuminate\Database\QueryException;

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

        try {
            DB::table('stocks')->insertGetId([
                "product_id" => $request->product_id,
                "branch_id" => $request->branch_id,
                "quantity" => $request->quantity,
                "date" => $request->calendar_event_date
        ]);
        } catch (QueryException $e) {
            if ($e->getCode() == 23505) {
                return back()->withErrors('Entry tersebut sudah ada. 
                Cek data stocks yang sudah ada atau status active nya di data master products.');
            }
            // Handle other errors
            return back()->withErrors('Something went wrong.');
        }

        return redirect()->route('stocks.index');
    }

    public function updateOpname(Request $request) {
        $baseUrl = config('app.url');
        $id = $request->id;

        \Log::debug("MASUK OPNAME DENGAN ID: {$id}");

        $opname = DB::table('stocks')
            ->where('id', $request->id)
            ->update([
                'opname_quantity' => $request->opname_quantity,
            ]);

        if ($opname) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false], 500);
        }
    }
}
