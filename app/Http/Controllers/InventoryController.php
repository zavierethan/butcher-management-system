<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class InventoryController extends Controller
{
    public function index() {
        return view('modules.master.inventory.index');
    }

    public function getLists(Request $request) {

        $params = $request->all();

        $query = DB::table('inventories');

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
        return view('modules.master.inventory.create');
    }

    public function save(Request $request) {
        $baseUrl = config('app.url');

        DB::transaction(function () use ($request) {
            // Insert new inventory and retrieve its ID
            $inventoryId = DB::table('inventories')->insertGetId([
                "code" => $request->code,
                "name" => $request->name,
                "unit" => $request->unit,
                "is_active" => $request->is_active
            ]);

            // Retrieve all branches
            $branches = DB::table('branches')->get();

            // Prepare inventory_details entries
            $inventoryDetails = $branches->map(function ($branch) use ($inventoryId) {
                return [
                    'inventory_id' => $inventoryId,
                    'branch_id' => $branch->id,
                ];
            })->toArray();

            // Insert into inventory_details
            DB::table('inventory_details')->insert($inventoryDetails);
        });

        return redirect()->route('inventories.index');
    }

    public function edit($id) {
        $inventory = DB::table('inventories')->where('id', $id)->first();

        if (!$inventory) {
            return redirect()->route('inventories.index')->with('error', 'Inventory not found.');
        }

        return view('modules.master.inventory.edit', compact('inventory'));
    }

    public function update(Request $request) {

        // Initialize update data
        $updateData = [
            'code' => $request->code,
            'name' => $request->name,
            'unit' => $request->unit,
            'is_active' => $request->is_active
        ];

        DB::table('inventories')
            ->where('id', $request->id)
            ->update($updateData);

        return redirect()->route('inventories.index');
    }

    public function getListInventories(Request $request) {
        $params = $request->q;
        $branchId = $request->branch_id;

        $query = DB::table('inventories')
            ->leftJoin('inventory_details', 'inventories.id', '=', 'inventory_details.inventory_id')
            ->select(
                'inventories.*',
                'inventory_details.quantity',
                'inventory_details.reference',
                )
            ->where('inventory_details.branch_id', $branchId)
            ->where('inventories.is_active', '=', 1);

        if($params != null) {
            $query->where('inventories.name', 'like', '%'.strtoupper($params).'%');
        }

        $totalRecords = $query->count();
        $filteredRecords = $query->count();

        $data = $query->orderBy('inventories.name', 'asc')->get();

        $response = [
            'draw' => $request->input('draw'),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $data
        ];

        return response()->json($response);
    }
}
