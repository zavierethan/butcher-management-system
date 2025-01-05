<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class StockLogController extends Controller
{
    public function index($id) {
        return view('modules.inventory.stock.stock-log.index', ['stockId' => $id]);
    }

    public function getLists(Request $request, $stockId) {

        $params = $request->all();

        $query = DB::table('stock_logs')
            ->select(
                'stock_logs.*',
            )
            ->where('stock_logs.stock_id', '=', $stockId);

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

    // save row di stock_logs dan update quantity di table stocks
    public function save(Request $request) {
        $validated = $request->validate([
            'stock_id' => 'required|integer',
            'in_quantity' => 'nullable|integer',
            'out_quantity' => 'nullable|integer',
            'reference' => 'nullable|string',
        ]);

        // Start transaction to ensure both operations (stock log insertion and stock update) succeed or fail together
        DB::beginTransaction();

        try {
            // Insert a new row into stock_logs table
            $stockLog = DB::table('stock_logs')->insertGetId([
                'stock_id' => $validated['stock_id'],
                'in_quantity' => $validated['in_quantity'] ?? 0,
                'out_quantity' => $validated['out_quantity'] ?? 0,
                'date' => now(),
                'reference' => $validated['reference'] ?? null,
            ]);

            // Calculate the quantity change
            $quantityChange = ($validated['in_quantity'] ?? 0) - ($validated['out_quantity'] ?? 0);

            // Update the quantity in the stocks table
            DB::table('stocks')
                ->where('id', $validated['stock_id'])
                ->increment('quantity', $quantityChange);

            // Commit the transaction
            DB::commit();

            return response()->json(['message' => 'Stock log created and stock quantity updated successfully.']);
        } catch (\Exception $e) {
            // Rollback the transaction if something goes wrong
            DB::rollBack();

            return response()->json(['error' => 'An error occurred while processing the request.'], 500);
        }
    }
}
