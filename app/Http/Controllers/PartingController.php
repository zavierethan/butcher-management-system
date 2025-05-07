<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use Log;

class PartingController extends Controller
{
    public function index() {
        return view('modules.inventory.parting.index');
    }

    public function getLists(Request $request) {

        $params = $request->all();

        $query = DB::table('partings')
            ->leftJoin('branches', 'branches.id', '=', 'partings.branch_id')
            ->select(
                'partings.id',
                DB::raw("TO_CHAR(partings.date, 'dd/mm/YYYY') as date"),
                'partings.total_live_chickens_number',
                'partings.total_live_chickens_weight',
                'partings.total_weight_live_to_rancung',
                'partings.total_weight_rancung_to_parting',
                'branches.name as branch_name')
            ->where('partings.branch_id', Auth::user()->branch_id);

        $start = $request->input('start', 0);
        $length = $request->input('length', 10);

        // Count total and filtered records
        $totalRecords = DB::table('partings')->count();
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

    public function create() {
        $branches = DB::table('branches')->orderBy('name', 'asc')->get();
        $products = DB::table('products')->orderBy('name', 'asc')->get();
        $butcherees = DB::table('butcherees')->orderBy('name', 'asc')->get();

        $requestNumber = DB::table('purchase_order_items')
                    ->select(
                        'purchase_requests.request_number',
                        'purchase_requests.id as request_id'
                    )
                    ->leftJoin('products', 'products.id', '=', 'purchase_order_items.item_id')
                    ->join('purchase_request_items', 'purchase_request_items.id', '=', 'purchase_order_items.purchase_request_item_id')
                    ->join('purchase_requests', 'purchase_requests.id', '=', 'purchase_request_items.purchase_request_id')
                    ->join('branches', 'branches.id', '=', 'purchase_requests.alocation')
                    ->where('purchase_requests.alocation', Auth::user()->branch_id)
                    ->where('purchase_order_items.status', 1)
                    ->get();

        return view('modules.inventory.parting.create', compact('branches', 'products', 'butcherees', 'requestNumber'));
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
            // Insert parting record
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

                // Insert into `parting_cut_results` first to get its ID
                $partingCutResultId = DB::table('parting_cut_results')->insertGetId([
                    'parting_id' => $partingId
                ]);

                // Prepare parting cut result details & sum stock logs per product
                $rawPartingData = $request->parting_data;
                $partingCutResultDetails = [];
                $stockLogs = [];
                $stockSummed = [];

                foreach ($rawPartingData as $data) {
                    $productId = $data['product_id'];
                    $quantity = $data['quantity'];

                    // Insert into parting_cut_result_details (keeping individual rows)
                    $partingCutResultDetails[] = [
                        'parting_cut_result_id' => $partingCutResultId,
                        'product_id' => $productId,
                        'quantity' => $quantity
                    ];

                    // Sum up stock logs per product
                    if (!isset($stockSummed[$productId])) {
                        $stockSummed[$productId] = 0;
                    }
                    $stockSummed[$productId] += $quantity;
                }

                // Insert parting_cut_result_details
                if (!empty($partingCutResultDetails)) {
                    DB::table('parting_cut_result_details')->insert($partingCutResultDetails);
                }

                // Insert stock logs (one per product)
                foreach ($stockSummed as $productId => $totalQuantity) {
                    // Check if stock already exists
                    $existingStock = DB::table('stocks')
                        ->where('branch_id', $request->branch_id)
                        ->where('product_id', $productId)
                        ->first();

                    if ($existingStock) {
                        // Use existing stock ID
                        $stockId = $existingStock->id;

                        // Insert stock log entry with parting_id
                        $stockLogs[] = [
                            'stock_id' => $stockId,
                            'in_quantity' => $totalQuantity,
                            'reference' => 'Hasil Parting',
                            'parting_id' => $partingId // 🔹 Add parting_id here
                        ];
                    }
                }

                if (!empty($stockLogs)) {
                    DB::table('stock_logs')->insert($stockLogs);
                }

                // Update goods status
                DB::table('purchase_order_items')->where('id', $request->purchase_order_item_id)->update(['status' => 2]);
            }

            DB::commit();
            return response()->json(['message' => 'Success']);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Error in saveParting', ['error' => $th->getMessage()]);

            return response()->json(['error' => 'An error occurred while processing the request.'], 500);
        }
    }

    // public function edit($id) {
    //     $branches = DB::table('branches')->orderBy('name', 'asc')->get();
    //     $products = DB::table('products')->orderBy('name', 'asc')->get();
    //     $butcherees = DB::table('butcherees')->orderBy('name', 'asc')->get();

    //     $partingHeader = DB::table('partings')
    //         ->where('partings.id', '=', $id)
    //         ->first();

    //     $rancungHeader = DB::table('fresh_chicken_cut_results')
    //         ->where('fresh_chicken_cut_results.parting_id', '=', $id)
    //         ->get();

    //     $partingCutResultsHeader = DB::table('parting_cut_results')
    //         ->where('parting_cut_results.parting_id', '=', $id)
    //         ->get();

    //     return view('modules.inventory.parting.edit', compact('branches', 'products', 'butcherees', 'partingHeader',
    //         'rancungHeader', 'partingCutResultsHeader'));
    // }

    public function edit($id) {
        $branches = DB::table('branches')->orderBy('name', 'asc')->get();
        $products = DB::table('products')->orderBy('name', 'asc')->get();
        $butcherees = DB::table('butcherees')->orderBy('name', 'asc')->get();

        // Get the parting record
        $partingHeader = DB::table('partings')->where('id', $id)->first();

        // Get the fresh chicken cut results
        $rancungHeader = DB::table('fresh_chicken_cut_results')
            ->where('parting_id', $id)
            ->get();

        // Get parting cut results details by joining tables
        $partingCutResultsHeader = DB::table('parting_cut_results as pcr')
            ->leftJoin('parting_cut_result_details as pcrd', 'pcr.id', '=', 'pcrd.parting_cut_result_id')
            ->leftJoin('products as p', 'pcrd.product_id', '=', 'p.id')
            ->where('pcr.parting_id', $id)
            ->select('pcr.id as parting_cut_result_id', 'pcr.parting_id', 'pcrd.product_id', 'p.name as product_name', 'pcrd.quantity')
            ->get();

        return view('modules.inventory.parting.edit', compact(
            'branches', 'products', 'butcherees',
            'partingHeader', 'rancungHeader', 'partingCutResultsHeader'
        ));
    }


    public function update(Request $request) {
        if (!$request->parting_id || !is_array($request->rancung_data) || empty($request->rancung_data) ||
            !is_array($request->parting_data) || empty($request->parting_data)) {
            return response()->json([
                'error' => 'Parting ID, Rancung data & Parting data are required.'
            ], 400);
        }

        DB::beginTransaction();

        try {
            $partingId = $request->parting_id;

            // Check if parting record exists
            $existingParting = DB::table('partings')->where('id', $partingId)->first();
            if (!$existingParting) {
                return response()->json(['error' => 'Parting record not found.'], 404);
            }

            // Update parting record
            DB::table('partings')->where('id', $partingId)->update([
                'branch_id' => $request->branch_id,
                'date' => $request->parting_date,
                'butcher_id' => $request->butcher_id,
                'total_live_chickens_number' => $request->total_live_chickens,
                'total_live_chickens_weight' => $request->total_live_chickens_weight,
                'total_weight_live_to_rancung' => $request->total_weight_live_to_rancung,
                'total_weight_rancung_to_parting' => $request->total_weight_rancung_to_parting
            ]);

            // Delete old related data in the correct order
            DB::table('fresh_chicken_cut_results')->where('parting_id', $partingId)->delete();

            // Find parting_cut_results ID first
            $partingCutResult = DB::table('parting_cut_results')->where('parting_id', $partingId)->first();
            if ($partingCutResult) {
                // Delete related parting_cut_result_details
                DB::table('parting_cut_result_details')->where('parting_cut_result_id', $partingCutResult->id)->delete();

                // Now delete parting_cut_results
                DB::table('parting_cut_results')->where('id', $partingCutResult->id)->delete();
            }

            // Delete stock logs only for this parting process
            DB::table('stock_logs')->where('parting_id', $partingId)->delete();

            // Insert updated fresh chicken cut results
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

            // Insert a new parting_cut_results entry
            $partingCutResultId = DB::table('parting_cut_results')->insertGetId([
                'parting_id' => $partingId
            ]);

            // Process parting data and insert into stock_logs (if stock exists)
            $rawPartingData = $request->parting_data;
            $partingCutResultDetails = [];
            $stockLogs = [];
            $stockSummed = [];

            foreach ($rawPartingData as $data) {
                $productId = $data['product_id'];
                $quantity = $data['quantity'];

                // Insert into parting_cut_result_details
                $partingCutResultDetails[] = [
                    'parting_cut_result_id' => $partingCutResultId,
                    'product_id' => $productId,
                    'quantity' => $quantity
                ];

                // Sum stock logs per product
                if (!isset($stockSummed[$productId])) {
                    $stockSummed[$productId] = 0;
                }
                $stockSummed[$productId] += $quantity;
            }

            // Insert parting_cut_result_details
            if (!empty($partingCutResultDetails)) {
                DB::table('parting_cut_result_details')->insert($partingCutResultDetails);
            }

            // Insert stock logs (one per product)
            foreach ($stockSummed as $productId => $totalQuantity) {
                // Check if stock already exists
                $existingStock = DB::table('stocks')
                    ->where('branch_id', $request->branch_id)
                    ->where('product_id', $productId)
                    ->first();

                if ($existingStock) {
                    // Use existing stock ID
                    $stockId = $existingStock->id;

                    // Insert stock log entry
                    $stockLogs[] = [
                        'stock_id' => $stockId,
                        'in_quantity' => $totalQuantity,
                        'parting_id' => $partingId,
                        'reference' => 'Hasil Parting'
                    ];
                }
            }

            if (!empty($stockLogs)) {
                DB::table('stock_logs')->insert($stockLogs);
            }

            DB::commit();
            return response()->json(['message' => 'Update successful']);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Error in updateParting', ['error' => $th->getMessage()]);

            return response()->json(['error' => 'An error occurred while updating the record.'], 500);
        }
    }

}
