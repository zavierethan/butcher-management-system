<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class OpnameController extends Controller
{
    public function index() {
        return view('modules.inventory.opname.index');
    }

    public function getLists(Request $request) {

        $params = $request->all();

        $query = DB::table('stocks as s')
            ->join('branches as b', 'b.id', '=', 's.branch_id')
            ->select('s.date', 's.branch_id', 'b.code as branch_code', 'b.name as branch_name')
            ->groupBy('s.date', 's.branch_id', 'b.code', 'b.name');
            // ->orderByDesc('s.date')
            // ->orderBy('s.branch_id')

        $start = $request->input('start', 0);
        $length = $request->input('length', 10);

        $totalRecords = $query->count();
        $filteredRecords = $query->count();
        // $data = $query->orderBy('id', 'desc')->skip($start)->take($length)->get();
        $data = $query->orderByDesc('date')->orderBy('branch_id')->skip($start)->take($length)->get();

        $response = [
            'draw' => $request->input('draw'),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $data
        ];

        return response()->json($response);
    }

    public function opnameDetails($date, $branchId) {
        return view('modules.inventory.opname.detail', ['date' => $date, 'branchId' => $branchId]);
    }

    public function getDetails(Request $request, $date, $branchId) {

        $params = $request->all();
        \Log::info("Date: $date, Branch ID: $branchId");

        $query = DB::table('stocks')
            ->leftJoin('products', 'stocks.product_id', '=', 'products.id')
            ->leftJoin('branches', 'stocks.branch_id', '=', 'branches.id')
            ->select(
                'stocks.*',
                'products.code as product_code',
                'products.name as product_name',
                'branches.code as branch_code',
                'branches.name as branch_name'
            )
            ->where('stocks.date', '=', $date)
            ->where('stocks.branch_id', '=', $branchId);

        $start = $request->input('start', 0);
        $length = $request->input('length', 10);

        $totalRecords = $query->count();
        $filteredRecords = $query->count();
        // $data = $query->orderBy('id', 'desc')->skip($start)->take($length)->get();
        $data = $query->orderByDesc('date')->orderBy('branch_id')->skip($start)->take($length)->get();

        $response = [
            'draw' => $request->input('draw'),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $data
        ];

        return response()->json($response);
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
