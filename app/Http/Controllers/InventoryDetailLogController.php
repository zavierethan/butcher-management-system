<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class InventoryDetailLogController extends Controller
{
    public function index($id) {
        return view('modules.inventory.inventory-detail.inventory-detail-log.index', ['inventoryDetailId' => $id]);
    }

    public function getLists(Request $request, $inventoryDetailId) {

        $params = $request->all();

        $query = DB::table('inventory_detail_logs')
            ->select(
                'inventory_detail_logs.*',
            )
            ->where('inventory_detail_logs.inventory_detail_id', '=', $inventoryDetailId);

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

    public function create($inventoryDetailId) {
        return view('modules.inventory.inventory-detail.inventory-detail-log.create', ['inventoryDetailId' => $inventoryDetailId]);
    }

    // save row di inventory_detail_logs dan update quantity di table inventory_details
    public function save(Request $request) {
        $validated = $request->validate([
            'inventory_detail_id' => 'required|integer',
            'in_quantity' => 'nullable|integer',
            'out_quantity' => 'nullable|integer',
            'reference' => 'nullable|string',
            'date' => 'nullable|string',
        ]);

        // Start transaction to ensure both operations (inventory_detail log insertion and inventory_detail update) succeed or fail together
        DB::beginTransaction();

        try {
            // Insert a new row into inventory_detail_logs table
            $inventoryDetailLog = DB::table('inventory_detail_logs')->insertGetId([
                'inventory_detail_id' => $validated['inventory_detail_id'],
                'in_quantity' => $validated['in_quantity'] ?? 0,
                'out_quantity' => $validated['out_quantity'] ?? 0,
                'reference' => $validated['reference'] ?? null,
                'date' => $validated['date'] ?? null,
            ]);

            // Calculate the quantity change
            $quantityChange = ($validated['in_quantity'] ?? 0) - ($validated['out_quantity'] ?? 0);

            // Update the quantity in the stocks table
            DB::table('inventory_details')
                ->where('id', $validated['inventory_detail_id'])
                ->increment('quantity', $quantityChange);

            // Commit the transaction
            DB::commit();

            if ($request->has('create_out_flag')) {
                return redirect()->route('inventory-detail-logs.index', ['inventoryDetailId' => $validated['inventory_detail_id']]);
            } else {
                return response()->json(['message' => 'Inventory Detail log created and Inventory Detail quantity updated successfully.']);
            }
        } catch (\Exception $e) {
            // Rollback the transaction if something goes wrong
            DB::rollBack();

            return response()->json(['error' => 'An error occurred while processing the request.'], 500);
        }
    }
}
