<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Log;
use Illuminate\Database\QueryException;
use App\Exports\StockExport;
use Maatwebsite\Excel\Facades\Excel;
use Validator;
use Auth;
use Carbon\Carbon;

class StockController extends Controller
{
    public function __construct() {
        date_default_timezone_set("Asia/Jakarta");
    }

    public function index() {
        return view('modules.inventory.stock.index');
    }

    public function getLists(Request $request) {
        $params = $request->all();

        // Subquery: logs_today
        $logsToday = DB::table('stock_logs')
            ->select(
                'stock_logs.stock_id',
                DB::raw('DATE(stock_logs.date) AS tanggal_logs_transaksi'),
                DB::raw('SUM(stock_logs.in_quantity) AS stok_masuk'),
                DB::raw('SUM(stock_logs.out_quantity) AS stok_keluar')
            )
            ->whereRaw('DATE(stock_logs.date) = CURRENT_DATE')
            ->groupBy('stock_logs.stock_id', DB::raw('DATE(stock_logs.date)'));

        // Subquery: latest_opname (before today)
        $latestOpname = DB::table('stock_opnames')
            ->select('stock_opnames.stock_id', 'stock_opnames.quantity', 'stock_opnames.date')
            ->whereRaw('DATE(stock_opnames.date) < CURRENT_DATE')
            ->orderBy('stock_opnames.stock_id')
            ->orderByDesc('stock_opnames.date');

        // Wrap it in a distinct-on simulation using window function (Postgres only)
        $latestOpnameSub = DB::table(DB::raw("(
            SELECT DISTINCT ON (stock_id) stock_id, quantity, date
            FROM stock_opnames
            WHERE DATE(date) < CURRENT_DATE
            ORDER BY stock_id, date DESC
            ) AS latest_opname"));

        // Subquery: today_opname
        $todayOpname = DB::table(DB::raw("(
            SELECT DISTINCT ON (stock_id) stock_id, quantity, date
            FROM stock_opnames
            WHERE DATE(date) = CURRENT_DATE
            ORDER BY stock_id, date DESC
            ) AS today_opname"));

        $query = DB::table('stocks')
            ->leftJoin('products', 'products.id', '=', 'stocks.product_id')
            ->leftJoinSub($logsToday, 'logs_today', function ($join) {
                $join->on('stocks.id', '=', 'logs_today.stock_id');
            })
            ->leftJoinSub($latestOpnameSub, 'latest_opname', function ($join) {
                $join->on('stocks.id', '=', 'latest_opname.stock_id');
            })
            ->leftJoinSub($todayOpname, 'today_opname', function ($join) {
                $join->on('stocks.id', '=', 'today_opname.stock_id');
            })
            ->where('stocks.branch_id', Auth::user()->branch_id)
            ->orderBy('products.sort_order', 'asc')
            ->select(
                'stocks.id',
                'products.code',
                'products.name',
                DB::raw('COALESCE(logs_today.tanggal_logs_transaksi, CURRENT_DATE) AS tanggal_logs_transaksi'),
                DB::raw("TO_CHAR(latest_opname.date, 'dd/mm/YYYY') as tanggal_stock_awal"),
                'today_opname.date AS tanggal_stock_opname',
                DB::raw('COALESCE(latest_opname.quantity, 0) AS stock_awal'),
                DB::raw('COALESCE(logs_today.stok_masuk, 0) AS stok_masuk'),
                DB::raw('COALESCE(logs_today.stok_keluar, 0) AS stok_keluar'),
                DB::raw('COALESCE(latest_opname.quantity, 0) + COALESCE(logs_today.stok_masuk, 0) - COALESCE(logs_today.stok_keluar, 0) AS stock_akhir'),
                DB::raw('COALESCE(today_opname.quantity, 0) AS hasil_stock_opname'),
                DB::raw('(COALESCE(today_opname.quantity, 0) - COALESCE(latest_opname.quantity, 0) + COALESCE(logs_today.stok_masuk, 0) - COALESCE(logs_today.stok_keluar, 0)) AS selisih')
            );

        // Apply search filter
        $searchValue = $request->input('searchTerm');
        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('products.name', 'ilike', '%' . $searchValue . '%');
            });
        }

        // Apply sorting
        if ($request->has('order') && $request->order) {
            $columnIndex = $request->order[0]['column'];
            $sortDirection = $request->order[0]['dir'];
            $columnName = $request->columns[$columnIndex]['data'];

            if (!empty($columnName) && in_array($columnName, [
                'product_code', 'product_name', 'branch_code', 'branch_name'
            ])) {
                $query->orderBy($columnName, $sortDirection);
            }
        }

        $start = $request->input('start', 0);
        $length = $request->input('length', 10);

        $totalRecords = $query->count();
        $filteredRecords = $query->count();
        $data = $query->skip($start)->take($length)->get();

        return response()->json([
            'draw' => $request->input('draw'),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $data
        ]);
    }


    public function export(Request $request) {

        $branch = DB::table('branches')
            ->where('id', $request->branchId)
            ->select('code as branch_code', 'name as branch_name')
            ->first();

        $printDateTime = Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s');

        $filters = [
            'branch_id' => $request->branchId,
            'branch_code' => $branch ? $branch->branch_code : null,
            'branch_name' => $branch ? $branch->branch_name : null,
            'print_date_time' => $printDateTime
        ];

        $export = new StockExport($filters);
        $excelData = Excel::raw($export, \Maatwebsite\Excel\Excel::XLSX);

        // Return the data as a proper response
        return response($excelData, 200, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="stock-reports.xlsx"',
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0',
        ]);
    }

    public function opnameIndex($id) {
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

        return view('modules.inventory.stock.opname.index', ['stockId' => $id], compact('stockHeader'));
    }

    public function getOpnameList(Request $request, $stockId) {

        $params = $request->all();
        $query = DB::table('stock_opnames')
            ->select(
                'stock_opnames.*'
            )
            ->where('stock_opnames.stock_id', '=', $stockId);


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

    public function saveOpname(Request $request) {
        $validated = $request->validate([
            'stock_id' => 'required|integer',
            'quantity' => 'nullable|numeric|regex:/^\d+(\.\d{1,2})?$/',
        ]);

        DB::beginTransaction();

        try {
            $stockId = $validated['stock_id'];
            $opnameQuantity = $validated['quantity'] ?? 0;

            // // Calculate current stock balance from stock_logs
            // $currentStock = DB::table('stock_logs')
            //     ->where('stock_id', $stockId)
            //     ->selectRaw('COALESCE(SUM(in_quantity), 0) - COALESCE(SUM(out_quantity), 0) AS stock_balance')
            //     ->first()->stock_balance;

            // // Determine stock adjustment amount
            // $adjustment = $currentStock - $opnameQuantity;

            // Insert opname record
            DB::table('stock_opnames')->insert([
                'stock_id' => $stockId,
                'quantity' => $opnameQuantity,
                'date' => Carbon::now('Asia/Jakarta'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Insert adjustment entry in stock_logs
            // if ($adjustment != 0) {
            //     DB::table('stock_logs')->insert([
            //         'stock_id' => $stockId,
            //         'in_quantity' => $adjustment < 0 ? abs($adjustment) : 0,
            //         'out_quantity' => $adjustment > 0 ? abs($adjustment) : 0,
            //         'date' => now(),
            //         'reference' => 'Stock Opname',
            //     ]);
            // }

            DB::commit();

            return redirect()->route('stocks.opname-index', ['stockId' => $stockId]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json(['error' => 'An error occurred while processing the request.'], 500);
        }
    }

    public function createOpname(Request $request) {
        $stockId = $request->query('stockId');
        return view('modules.inventory.stock.opname.create', compact('stockId'));
    }

    public function updateOpname(Request $request) {
        $request->validate([
            'id' => 'required|exists:stock_opnames,id',
            'quantity' => ['required', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/']
        ]);

        DB::beginTransaction();

        try {
            // Fetch opname details
            $opname = DB::table('stock_opnames')
                ->where('id', $request->id)
                ->first();

            if (!$opname) {
                return response()->json(['error' => 'Stock opname not found.'], 404);
            }

            $stockId = $opname->stock_id;
            $newQuantity = number_format($request->quantity, 2, '.', '');

            // Fetch current stock balance from stock_logs
            $currentStock = DB::table('stock_logs')
                ->where('stock_id', $stockId)
                ->selectRaw('COALESCE(SUM(in_quantity), 0) - COALESCE(SUM(out_quantity), 0) AS stock_balance')
                ->first()->stock_balance;

            // Calculate the adjustment
            $adjustment = $currentStock - $newQuantity;

            // Update stock_opnames quantity
            DB::table('stock_opnames')
                ->where('id', $request->id)
                ->update([
                    'quantity' => $newQuantity,
                    'updated_at' => now()
                ]);

            // Insert adjustment entry in stock_logs if necessary
            if ($adjustment != 0) {
                DB::table('stock_logs')->insert([
                    'stock_id' => $stockId,
                    'in_quantity' => $adjustment < 0 ? abs($adjustment) : 0,
                    'out_quantity' => $adjustment > 0 ? abs($adjustment) : 0,
                    'date' => now(),
                    'reference' => 'Stock Opname Adjustment'
                ]);
            }

            DB::commit();

            return response()->json(['success' => true, 'message' => 'Quantity updated successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'An error occurred while updating the quantity.'], 500);
        }
    }

    public function stockOpname() {
        $branch = DB::table('branches')->where('id', Auth::user()->branch_id)->first();

        // Subquery: logs_today
        $logsToday = DB::table('stock_logs')
            ->select(
                'stock_logs.stock_id',
                DB::raw('DATE(stock_logs.date) AS tanggal_logs_transaksi'),
                DB::raw('SUM(stock_logs.in_quantity) AS stok_masuk'),
                DB::raw('SUM(stock_logs.out_quantity) AS stok_keluar')
            )
            ->whereRaw('DATE(stock_logs.date) = CURRENT_DATE')
            ->groupBy('stock_logs.stock_id', DB::raw('DATE(stock_logs.date)'));

        // Subquery: latest_opname (before today)
        $latestOpname = DB::table('stock_opnames')
            ->select('stock_opnames.stock_id', 'stock_opnames.quantity', 'stock_opnames.date')
            ->whereRaw('DATE(stock_opnames.date) < CURRENT_DATE')
            ->orderBy('stock_opnames.stock_id')
            ->orderByDesc('stock_opnames.date');

        // Wrap it in a distinct-on simulation using window function (Postgres only)
        $latestOpnameSub = DB::table(DB::raw("(
            SELECT DISTINCT ON (stock_id) stock_id, quantity, date
            FROM stock_opnames
            WHERE DATE(date) < CURRENT_DATE
            ORDER BY stock_id, date DESC
            ) AS latest_opname"));

        // Subquery: today_opname
        $todayOpname = DB::table(DB::raw("(
            SELECT DISTINCT ON (stock_id) stock_id, quantity, date
            FROM stock_opnames
            WHERE DATE(date) = CURRENT_DATE
            ORDER BY stock_id, date DESC
            ) AS today_opname"));

        $stocks = DB::table('stocks')
            ->leftJoin('products', 'products.id', '=', 'stocks.product_id')
            ->leftJoinSub($logsToday, 'logs_today', function ($join) {
                $join->on('stocks.id', '=', 'logs_today.stock_id');
            })
            ->leftJoinSub($latestOpnameSub, 'latest_opname', function ($join) {
                $join->on('stocks.id', '=', 'latest_opname.stock_id');
            })
            ->leftJoinSub($todayOpname, 'today_opname', function ($join) {
                $join->on('stocks.id', '=', 'today_opname.stock_id');
            })
            ->where('stocks.branch_id', Auth::user()->branch_id)
            ->orderBy('products.sort_order', 'asc')
            ->select(
                'stocks.id',
                'products.code as product_code',
                'products.name as product_name',
                DB::raw('COALESCE(logs_today.tanggal_logs_transaksi, CURRENT_DATE) AS tanggal_logs_transaksi'),
                DB::raw("TO_CHAR(latest_opname.date, 'dd/mm/YYYY') as tanggal_stock_awal"),
                'today_opname.date AS tanggal_stock_opname',
                DB::raw('COALESCE(latest_opname.quantity, 0) AS stock_awal'),
                DB::raw('COALESCE(logs_today.stok_masuk, 0) AS stok_masuk'),
                DB::raw('COALESCE(logs_today.stok_keluar, 0) AS stok_keluar'),
                DB::raw('COALESCE(latest_opname.quantity, 0) + COALESCE(logs_today.stok_masuk, 0) - COALESCE(logs_today.stok_keluar, 0) AS stock_akhir'),
                DB::raw('COALESCE(today_opname.quantity, 0) AS hasil_stock_opname'),
                DB::raw('COALESCE(today_opname.quantity, 0) - (COALESCE(latest_opname.quantity, 0) + COALESCE(logs_today.stok_masuk, 0) - COALESCE(logs_today.stok_keluar, 0)) AS selisih')
            )
            ->get();


        return view('modules.inventory.stock.stock-opname', compact('branch', 'stocks'));
    }

    public function stockOpnameSave(Request $request)
    {
        $products = $request->input('products');

        DB::beginTransaction();

        try {
            foreach ($products as $productData) {
                $stockId = $productData['stock_id'];
                $opnameQuantity = $productData['quantity'] ?? 0;
                $date = $productData['date'] ?? now();

                // Get current stock balance
                $currentStock = DB::table('stock_logs')
                    ->where('stock_id', $stockId)
                    ->selectRaw('COALESCE(SUM(in_quantity), 0) - COALESCE(SUM(out_quantity), 0) AS stock_balance')
                    ->first()->stock_balance;

                $adjustment = $currentStock - $opnameQuantity;

                // Insert into stock_opnames
                DB::table('stock_opnames')->insert([
                    "stock_id" => $stockId,
                    "quantity" => $opnameQuantity,
                    "date" => $date,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Insert into stock_logs if adjustment is needed
                // if ($adjustment != 0) {
                //     DB::table('stock_logs')->insert([
                //         "stock_id" => $stockId,
                //         "in_quantity" => $adjustment < 0 ? abs($adjustment) : 0,
                //         "out_quantity" => $adjustment > 0 ? abs($adjustment) : 0,
                //         "date" => $date,
                //         "reference" => "Stock Opname #" . $productData['date'],
                //     ]);
                // }
            }

            DB::commit();

            return response()->json(["message" => "Products updated successfully"]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["error" => "An error occurred while processing stock opnames."], 500);
        }
    }


    public function mutasi() {
        $branch = DB::table('branches')->where('id', Auth::user()->branch_id)->first();
        $branches = DB::table('branches')->whereNotIn('id', [$branch->id])->get();
        $stocks = DB::table('stocks')
            ->leftJoin('products', 'stocks.product_id', '=', 'products.id')
            ->leftJoin('branches', 'stocks.branch_id', '=', 'branches.id')
            ->leftJoin('stock_logs as sl', 'stocks.id', '=', 'sl.stock_id')
            ->select(
                'stocks.id as stock_id',
                'products.id as product_id',
                'products.code as product_code',
                'products.name as product_name',
            )
            ->where('stocks.branch_id', Auth::user()->branch_id)
            ->groupBy(
                'stocks.id',
                'products.id',
                'products.code',
                'products.name'
            )->orderBy('products.sort_order', 'asc')->get();
        return view('modules.inventory.stock.mutasi.index', compact('stocks', 'branch', 'branches'));
    }

    public function mutasiSave(Request $request) {
        $products = $request->input('products');

        foreach ($products as $productData) {
            DB::table('stock_mutations')
                ->insert([
                    "stock_id" => $productData['stock_id'],
                    "mutation_type" => $productData['type'],
                    "quantity" => $productData['quantity'],
                    "mutation_date" => $productData['date'],
                ]);

            if($productData['type'] == 'IN') {
                DB::table('stock_logs')
                    ->insert([
                        "stock_id" => $productData['stock_id'],
                        "in_quantity" => $productData['quantity'],
                        "date" => $productData['date'],
                        "reference" => "Mutasi #" . $productData['type'],
                    ]);
            } else {
                DB::table('stock_logs')
                    ->insert([
                        "stock_id" => $productData['stock_id'],
                        "out_quantity" => $productData['quantity'],
                        "date" => $productData['date'],
                        "reference" => "Mutasi #" . $productData['type'],
                    ]);
            }
        }

        return response()->json(["message" => "Products updated successfully"]);
    }

    public function limitIndex($id) {
        $stockHeader = $stock = DB::table('stocks')
            ->select(
                'stocks.*',
                'products.id as product_id',
                'products.code as product_code',
                'products.name as product_name',
                'branches.id as branch_id',
                'branches.code as branch_code',
                'branches.name as branch_name',
                DB::raw('COALESCE(SUM(sl.in_quantity), 0) - COALESCE(SUM(sl.out_quantity), 0) as total_quantity'),
            )
            ->leftJoin('products', 'stocks.product_id', '=', 'products.id')
            ->leftJoin('branches', 'stocks.branch_id', '=', 'branches.id')
            ->leftJoin('stock_logs as sl', 'stocks.id', '=', 'sl.stock_id')
            ->where('stocks.id', $id)
            ->groupBy('stocks.id', 'products.id', 'products.code', 'products.name', 'branches.id', 'branches.code', 'branches.name')
            ->first();

        return view('modules.inventory.stock.limit.index', ['stockId' => $id], compact('stockHeader'));
    }

public function saveLimit(Request $request)
{
    // Validate the incoming data
    $request->validate([
        'stock_id' => 'required|exists:stocks,id',  // Ensure the stock exists in the database
        'limit' => 'required|numeric|min:0',        // Ensure the limit is a valid number and non-negative
    ]);

    // Update the stock limit using a raw SQL query
    DB::table('stocks')
        ->where('id', $request->stock_id)
        ->update(['max_quantity' => $request->limit]);

    // Return a success response
    return response()->json(['success' => true, 'message' => 'Stock limit updated successfully']);
}


}
