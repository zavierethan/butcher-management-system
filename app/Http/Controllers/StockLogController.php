<?php

namespace App\Http\Controllers;

use App\Exports\StockLogExport;
use Illuminate\Http\Request;
use DB;
use Log;
use Maatwebsite\Excel\Facades\Excel;

class StockLogController extends Controller
{
    public function index($id) {
        $stockHeader = $stock = DB::table('stocks')
            ->select(
                'stocks.*',
                'products.id as product_id',
                'products.code as product_code',
                'products.name as product_name',
                'branches.id as branch_id',
                'branches.code as branch_code',
                'branches.name as branch_name',
                DB::raw('COALESCE(SUM(sl.in_quantity), 0) - COALESCE(SUM(sl.out_quantity), 0) as total_quantity')
            )
            ->leftJoin('products', 'stocks.product_id', '=', 'products.id')
            ->leftJoin('branches', 'stocks.branch_id', '=', 'branches.id')
            ->leftJoin('stock_logs as sl', 'stocks.id', '=', 'sl.stock_id')
            ->where('stocks.id', $id)
            ->groupBy('stocks.id', 'products.id', 'products.code', 'products.name', 'branches.id', 'branches.code', 'branches.name')
            ->first();

        return view('modules.inventory.stock.stock-log.index', ['stockId' => $id], compact('stockHeader'));
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
            'in_quantity' => 'nullable|numeric|regex:/^\d+(\.\d{1,2})?$/',
            'out_quantity' => 'nullable|numeric|regex:/^\d+(\.\d{1,2})?$/',
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

            // Commit the transaction
            DB::commit();

            return redirect()->route('stock-logs.index', ['stockId' => $validated['stock_id']]);
        } catch (\Exception $e) {
            // Rollback the transaction if something goes wrong
            DB::rollBack();

            return response()->json(['error' => 'An error occurred while processing the request.'], 500);
        }
    }

    public function getStockHeader(Request $request, $stockId) {
        $params = $request->all();

        $query = DB::table('stocks')
            ->join('products', 'products.id', '=', 'stocks.product_id')
            ->join('branches', 'branches.id', '=', 'stocks.branch_id')
            ->select('stocks.*', 'products.name as product_name', 'branches.name as branch_name')
            ->where('stocks.id', '=', $stockId);

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

    public function partingIndex() {
        $branches = DB::table('branches')->orderBy('name', 'asc')->get();
        $products = DB::table('products')->orderBy('name', 'asc')->get();
        $butcherees = DB::table('butcherees')->orderBy('name', 'asc')->get();

        return view('modules.inventory.stock.parting.parting-index', compact('branches', 'products', 'butcherees'));
    }

public function saveParting(Request $request) {
    // Validate required arrays before processing
    if (!is_array($request->rancung_data) || empty($request->rancung_data) ||
        !is_array($request->parting_data) || empty($request->parting_data) ||
        !is_array($request->price_data) || empty($request->price_data)) {
        return response()->json([
            'error' => 'Rancung data, parting data, and price data are required and cannot be empty.'
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

            // Process parting data and insert into stocks
            $rawPartingData = $request->parting_data;
            $priceData = collect($request->price_data);
            $partingCutResults = [];
            $stockLogs = [];

            $groupedPartingData = [];
            foreach ($rawPartingData as $data) {
                $productId = $data['product_id'];
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

                // Find base_price and sale_price for this product
                $price = $priceData->firstWhere('product_id', $productId);
                $basePrice = $price ? $price['base_price'] : null;
                $salePrice = $price ? $price['sale_price'] : null;

                // Insert into stocks
                $stockId = DB::table('stocks')->insertGetId([
                    'branch_id' => $request->branch_id,
                    'product_id' => $productId,
                    'date' => $request->parting_date,
                    'base_price' => $basePrice,
                    'sale_price' => $salePrice
                ]);

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



    // public function saveParting(Request $request) {
    //     DB::beginTransaction();

    //     try {
    //         // Log::info('Received parting request', ['request' => $request->all()]);

    //         // Insert into 'partings' table
    //         $partingId = DB::table('partings')->insertGetId([
    //             'branch_id' => $request->branch_id,
    //             'date' => $request->parting_date,
    //             'butcher_id' => $request->butcher_id,
    //             'total_live_chickens_number' => $request->total_live_chickens,
    //             'total_live_chickens_weight' => $request->total_live_chickens_weight,
    //             'total_weight_live_to_rancung' => $request->total_weight_live_to_rancung,
    //             'total_weight_rancung_to_parting' => $request->total_weight_rancung_to_parting
    //         ]);

    //         // Log::info('Inserted into partings', ['partingId' => $partingId]);

    //         if ($partingId) {
    //             // Insert into 'fresh_chicken_cut_results'
    //             $rancungData = $request->rancung_data;
    //             $freshChickenCutResults = [];

    //             foreach ($rancungData as $data) {
    //                 $freshChickenCutResults[] = [
    //                     'parting_id' => $partingId,
    //                     'total_chickens' => $data['total_chickens'],
    //                     'weight' => $data['weight'],
    //                     'container_weight' => $data['container_weight'],
    //                     'net_weight' => $data['net_weight']
    //                 ];
    //             }

    //             if (!empty($freshChickenCutResults)) {
    //                 DB::table('fresh_chicken_cut_results')->insert($freshChickenCutResults);
    //                 // Log::info('Inserted into fresh_chicken_cut_results', ['data' => $freshChickenCutResults]);
    //             }

    //             // Insert into 'parting_cut_results'
    //             $partingData = $request->parting_data;
    //             $partingCutResults = [];

    //             foreach ($partingData as $data) {
    //                 $partingCutResults[] = [
    //                     'parting_id' => $partingId,
    //                     'product_id' => $data['product_id'],
    //                     'quantity' => $data['quantity']
    //                 ];

    //                 $stockId = DB::table('stocks')
    //                     ->where('product_id', $data['product_id'])
    //                     ->where('branch_id', $request->branch_id)
    //                     ->whereDate('date', $request->parting_date)
    //                     ->value('id');

    //                 $partingCutResultsForStockLogs[] = [
    //                     'stock_id' => $stockId,
    //                     'in_quantity' => $data['quantity'],
    //                     'reference' => 'Hasil Parting'
    //                 ];
    //             }

    //             if (!empty($partingCutResults)) {
    //                 DB::table('parting_cut_results')->insert($partingCutResults);
    //                 // Log::info('Inserted into parting_products', ['data' => $partingCutResults]);
    //             }

    //             if (!empty($partingCutResultsForStockLogs)) {
    //                 DB::table('stock_logs')->insert($partingCutResultsForStockLogs);
    //                 // Log::info('Inserted into stock_logs', ['data' => $partingCutResultsForStockLogs]);
    //             }
    //         }

    //         DB::commit();
    //         // Log::info('Transaction committed successfully');

    //         return response()->json(['message' => 'Success']);
    //     } catch (\Throwable $th) {
    //         DB::rollBack();
    //         Log::error('Error in saveParting', ['error' => $th->getMessage(), 'trace' => $th->getTraceAsString()]);

    //         return response()->json(['error' => 'An error occurred while processing the request.'], 500);
    //     }
    // }

    public function create(Request $request) {
        $stockId = $request->query('stockId');
        return view('modules.inventory.stock.stock-log.create', compact('stockId'));
    }

    public function export(Request $request) {
        $filters = [
            'stock_id' => $request->stock_id,
            'branch_name' => $request->branch_name,
            'branch_code' => $request->branch_code
        ];

        $filename = "Stock Log.xlsx";

        // Generate Excel data
        $export = new StockLogExport($filters);
        $excelData = Excel::raw($export, \Maatwebsite\Excel\Excel::XLSX);

        // Return response with dynamic filename
        return response($excelData, 200, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            "Content-Disposition" => "attachment; filename=\"{$filename}\"",
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0',
        ]);
    }

}
