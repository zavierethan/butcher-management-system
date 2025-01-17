<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Database\QueryException;

class InventoryDetailController extends Controller
{
    public function index() {
        return view('modules.inventory.inventory-detail.index');
    }

    public function getLists(Request $request) {

        $params = $request->all();

        $query = DB::table('inventory_details')
            ->leftJoin('inventories', 'inventory_details.inventory_id', '=', 'inventories.id')
            ->leftJoin('branches', 'inventory_details.branch_id', '=', 'branches.id')
            ->select(
                'inventory_details.*',
                'inventories.code as inventory_code',
                'inventories.name as inventory_name',
                'inventories.unit as unit',
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
        $inventories = DB::table('inventories')->orderBy('name', 'asc')->get();

        return view('modules.inventory.inventory-detail.create', compact('branches', 'inventories'));
    }

    // public function save(Request $request) {
    //     $baseUrl = config('app.url');

    //     DB::table('inventory_details')->insertGetId([
    //         "inventory_id" => $request->inventory_id,
    //         "branch_id" => $request->branch_id,
    //         "quantity" => $request->quantity
    //     ]);

    //     return redirect()->route('inventory-details.index');
    // }

    public function save(Request $request) {
        $baseUrl = config('app.url');
        
        try {
            DB::table('inventory_details')->insertGetId([
                "inventory_id" => $request->inventory_id,
                "branch_id" => $request->branch_id,
                "quantity" => $request->quantity
            ]);
        } catch (QueryException $e) {
            if ($e->getCode() == 23505) {
                return back()->withErrors('Entry item inventori di cabang tersebut sudah ada. 
                Cek inventory details yang sudah ada atau status active nya di data master inventori.');
            }
            // Handle other errors
            return back()->withErrors('Something went wrong.');
        }

        return redirect()->route('inventory-details.index');
    }
}
