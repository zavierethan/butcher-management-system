<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Log;

class PartingController extends Controller
{
    public function index() {
        $branches = DB::table('branches')->orderBy('name', 'asc')->get();
        $products = DB::table('products')->orderBy('name', 'asc')->get();
        $butcherees = DB::table('butcherees')->orderBy('name', 'asc')->get();

        return view('modules.inventory.parting.index', compact('branches', 'products', 'butcherees'));
    }

    public function save(Request $request) {
        // Validate required arrays before processing
        if (!is_array($request->rancung_data) || empty($request->rancung_data) ||
            !is_array($request->parting_data) || empty($request->parting_data)) {
            return response()->json([
                'error' => 'Rancung data & parting data are required.'
            ], 400);
        }

        DB::beginTransaction();

        try {
            $partingId = DB::table('partings')->insertGetId([
                'branch_id' => $request->branch_id,
                'date' => $request->parting_date,
                'butcher_id' => $request->butcher_id,
                'total_live_chickens_number' => $request->total_live_chickens,
                'total_live_chickens_weight' => $request->total_live_chickens_weight,
                'total_weight_live_to_rancung' => $request->total_weight_live_to_rancung,
                'total_weight_rancung_to_parting' => $request->total_weight_rancung_to_parting
            ]);

            if ($partingId) {
                // Insert fresh chicken cut results
                $rancungData = $request->rancung_data;
                $freshChickenCutResults = [];

                foreach ($rancungData as $data) {
                    $freshChickenCutResults[] = [
                        'parting_id' => $partingId,
                        'total_chickens' => $data['total_chickens'],
                        'weight' => $data['weight'],
                        'container_weight' => $data['container_weight'],
                        'net_weight' => $data['net_weight']
                    ];
                }

                if (!empty($freshChickenCutResults)) {
                    DB::table('fresh_chicken_cut_results')->insert($freshChickenCutResults);
                }

                // Process parting data and insert into stock_logs (if stock exists)
                $rawPartingData = $request->parting_data;
                $partingCutResults = [];
                $stockLogs = [];

                $groupedPartingData = [];
                foreach ($rawPartingData as $data) {
                    $productId = $data['product_id'];
                    Log::info('Product id: ', [$productId]);
                    $quantity = $data['quantity'];

                    if (!isset($groupedPartingData[$productId])) {
                        $groupedPartingData[$productId] = [
                            'product_id' => $productId,
                            'quantity' => 0
                        ];
                    }
                    $groupedPartingData[$productId]['quantity'] += $quantity;
                }

                foreach ($groupedPartingData as $data) {
                    $productId = $data['product_id'];
                    $quantity = $data['quantity'];

                    // Check if stock already exists
                    $existingStock = DB::table('stocks')
                        ->where('branch_id', $request->branch_id)
                        ->where('product_id', $productId)
                        ->first();

                    if ($existingStock) {
                        // Use existing stock ID
                        $stockId = $existingStock->id;
                    }

                    // Insert into stock_logs
                    $stockLogs[] = [
                        'stock_id' => $stockId,
                        'in_quantity' => $quantity,
                        'reference' => 'Hasil Parting'
                    ];

                    // Insert into parting_cut_results
                    $partingCutResults[] = [
                        'parting_id' => $partingId,
                        'product_id' => $productId,
                        'quantity' => $quantity
                    ];
                }

                if (!empty($partingCutResults)) {
                    DB::table('parting_cut_results')->insert($partingCutResults);
                }

                if (!empty($stockLogs)) {
                    DB::table('stock_logs')->insert($stockLogs);
                }
            }

            DB::commit();
            return response()->json(['message' => 'Success']);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Error in saveParting', ['error' => $th->getMessage()]);

            return response()->json(['error' => 'An error occurred while processing the request.'], 500);
        }
    }
}
