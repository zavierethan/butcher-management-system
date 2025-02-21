<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Log;

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

        return view('modules.inventory.stock.parting.parting-index', compact('branches', 'products'));
    }


    public function saveParting(Request $request) {
        DB::beginTransaction();

        try {
            // Log::info('Received parting request', ['request' => $request->all()]);

            // Insert into 'partings' table
            $partingId = DB::table('partings')->insertGetId([
                'branch_id' => $request->branch_id,
                'date' => $request->parting_date,
                'butcher_id' => $request->butcher_id,
                'total_live_chickens_number' => $request->total_live_chickens,
                'total_live_chickens_weight' => $request->total_live_chickens_weight,
                'total_weight_live_to_rancung' => $request->total_weight_live_to_rancung,
                'total_weight_rancung_to_parting' => $request->total_weight_rancung_to_parting
            ]);

            // Log::info('Inserted into partings', ['partingId' => $partingId]);

            if ($partingId) {
                // Insert into 'fresh_chicken_cut_results'
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
                    // Log::info('Inserted into fresh_chicken_cut_results', ['data' => $freshChickenCutResults]);
                }

                // Insert into 'parting_cut_results'
                $partingData = $request->parting_data;
                $partingCutResults = [];

                foreach ($partingData as $data) {
                    $partingCutResults[] = [
                        'parting_id' => $partingId,
                        'product_id' => $data['product_id'],
                        'quantity' => $data['quantity']
                    ];

                    $stockId = DB::table('stocks')
                        ->where('product_id', $data['product_id'])
                        ->where('branch_id', $request->branch_id)
                        ->whereDate('date', $request->parting_date)
                        ->value('id');

                    $partingCutResultsForStockLogs[] = [
                        'stock_id' => $stockId,
                        'in_quantity' => $data['quantity'],
                        'reference' => 'Hasil Parting'
                    ];
                }

                if (!empty($partingCutResults)) {
                    DB::table('parting_cut_results')->insert($partingCutResults);
                    // Log::info('Inserted into parting_products', ['data' => $partingCutResults]);
                }

                if (!empty($partingCutResultsForStockLogs)) {
                    DB::table('stock_logs')->insert($partingCutResultsForStockLogs);
                    // Log::info('Inserted into stock_logs', ['data' => $partingCutResultsForStockLogs]);
                }
            }

            DB::commit();
            // Log::info('Transaction committed successfully');

            return response()->json(['message' => 'Success']);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Error in saveParting', ['error' => $th->getMessage(), 'trace' => $th->getTraceAsString()]);

            return response()->json(['error' => 'An error occurred while processing the request.'], 500);
        }
    }

    public function create(Request $request) {
        $stockId = $request->query('stockId');
        return view('modules.inventory.stock.stock-log.create', compact('stockId'));
    }

}
