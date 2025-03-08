<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Log;
use Illuminate\Database\QueryException;
use App\Exports\StockExport;
use Maatwebsite\Excel\Facades\Excel;
use Validator;

class StockController extends Controller
{
    public function index() {
        return view('modules.inventory.stock.index');
    }

    public function getLists(Request $request) {
        $params = $request->all();

        // Default date range: today
        $today = date('Y-m-d');
        $startDate = $params['startDate'] ?? $today;
        $endDate = $params['endDate'] ?? $today;


        $query = DB::table('stocks')
            ->leftJoin('products', 'stocks.product_id', '=', 'products.id')
            ->leftJoin('branches', 'stocks.branch_id', '=', 'branches.id')
            ->leftJoin('stock_logs as sl', 'stocks.id', '=', 'sl.stock_id')
            ->select(
                'stocks.*',
                'products.code as product_code',
                'products.name as product_name',
                'branches.code as branch_code',
                'branches.name as branch_name',
                DB::raw('COALESCE(SUM(sl.in_quantity), 0) - COALESCE(SUM(sl.out_quantity), 0) as realtime_quantity')
            )
            ->groupBy(
                'stocks.id',
                'products.code',
                'products.name',
                'branches.code',
                'branches.name'
            );


        // Apply date range filter (default or provided)
        $query->whereBetween('stocks.date', [$startDate, $endDate]);

        // Apply global search
        $searchValue = $request->input('searchTerm'); // DataTables search input
        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('products.name', 'ilike', '%' . $searchValue . '%');
            });
        }

        // Apply sorting
        if ($request->has('order') && $request->order) {
            $columnIndex = $request->order[0]['column']; // Column index from DataTables
            $sortDirection = $request->order[0]['dir']; // 'asc' or 'desc'
            $columnName = $request->columns[$columnIndex]['data']; // Column name

            if (!empty($columnName) && in_array($columnName, [
                'product_code', 'product_name', 'branch_code', 'branch_name', 'quantity', 'opname_quantity', 'date'
            ])) {
                $query->orderBy($columnName, $sortDirection);
            }
        }

        if (!$request->has('order')) {
            $query->orderBy('stocks.date', 'desc');
        }

        // Pagination parameters
        $start = $request->input('start', 0);
        $length = $request->input('length', 10);

        $totalRecords = DB::table('stocks')->count(); // Total records without filters
        $filteredRecords = $query->count(); // Total records after filters
        $data = $query->orderBy('id', 'desc')->skip($start)->take($length)->get(); // Paginated data

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

        return view('modules.inventory.stock.create', compact('branches', 'products'));
    }

    public function save(Request $request) {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'branch_id' => 'required|exists:branches,id',
            'calendar_event_date' => 'required|date',
            'base_price' => 'required|numeric|min:0',
            'sale_price' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            // Insert data
            DB::table('stocks')->insert([
                "product_id" => $request->product_id,
                "branch_id" => $request->branch_id,
                "date" => $request->calendar_event_date,
                "base_price" => $request->base_price,
                "sale_price" => $request->sale_price
            ]);

            return response()->json([
                'success' => true,
                'redirect' => route('stocks.index')
            ]);
        } catch (QueryException $e) {
            if ($e->getCode() == 23505) { // Unique constraint violation
                return response()->json([
                    'success' => false,
                    'message' => 'Entry tersebut sudah ada. Cek data stocks yang sudah ada atau status active-nya di data master products.'
                ], 422);
            }

            // Handle other errors
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong.'
            ], 500);
        }
    }


    public function updateOpname(Request $request) {
        $id = $request->id;

        \Log::debug("MASUK OPNAME DENGAN ID: {$id}");

        try {
            DB::beginTransaction();

            // Update the opname_quantity
            $updated = DB::table('stocks')
                ->where('id', $id)
                ->update([
                    'opname_quantity' => $request->opname_quantity,
                    // 'base_price' => $request->base_price,
                    // 'sale_price' => $request->sale_price
                ]);

            if (!$updated) {
                \Log::error("Failed to update opname_quantity for ID: {$id}");
                return response()->json(['success' => false, 'message' => 'Failed to update opname_quantity'], 500);
            }

            // Retrieve the updated stock details
            $stock = DB::table('stocks')->where('id', $id)->first();

            if (!$stock) {
                \Log::error("Stock not found for ID: {$id}");
                DB::rollBack();
                return response()->json(['success' => false, 'message' => 'Stock not found'], 500);
            }

            // note: fitur membuat row stock baru ketika update opname untuk sekarang disabled dulu
            // mau diganti untuk membuat stock baru jadinya lewat parting

            // Convert the given date and add one day
            // $newDate = date('Y-m-d', strtotime($request->date . ' +1 day'));

            // Insert new stock and get the inserted ID
            // $newStockId = DB::table('stocks')->insertGetId([
            //     'product_id' => $stock->product_id,
            //     'branch_id' => $stock->branch_id,
            //     'date' => $newDate,
            //     'quantity' => $request->opname_quantity,
            //     'opname_quantity' => null
            // ]);

            // if (!$newStockId) {
            //     \Log::error("Failed to insert into stocks for product {$stock->product_id} and branch {$stock->branch_id} on date {$newDate}");
            //     DB::rollBack();
            //     return response()->json(['success' => false, 'message' => 'Failed to insert into stocks'], 500);
            // }

            // Insert a new row in stock_logs
            // DB::table('stock_logs')->insert([
            //     'stock_id' => $newStockId,
            //     'in_quantity' => $request->opname_quantity,
            //     'date' => now()->setTimezone('Asia/Jakarta'),
            //     'reference' => 'Stock opname'
            // ]);

            DB::commit();
            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Failed to update opname: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Gagal memperbarui stock opname.'], 500);
        }
    }

    public function export(Request $request) {

        $filters = [
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'search_term' => $request->search_term
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

    public function getMutableList(Request $request) {
        $params = $request->all();

        // Default date range: today
        $today = date('Y-m-d');


        $query = DB::table('stocks')
            ->leftJoin('products', 'stocks.product_id', '=', 'products.id')
            ->leftJoin('branches', 'stocks.branch_id', '=', 'branches.id')
            ->leftJoin('stock_logs as sl', 'stocks.id', '=', 'sl.stock_id')
            ->select(
                'stocks.*',
                'products.code as product_code',
                'products.name as product_name',
                'branches.code as branch_code',
                'branches.name as branch_name',
                DB::raw('COALESCE(SUM(sl.in_quantity), 0) - COALESCE(SUM(sl.out_quantity), 0) as realtime_quantity')
            )
            ->groupBy(
                'stocks.id',
                'products.code',
                'products.name',
                'branches.code',
                'branches.name'
            );


        // Apply date range filter (default or provided)
        $query->whereDate('stocks.date', $today);

        // Exclude carcass
        $query->whereRaw('LOWER(products.name) != ?', ['karkas']);

        // Apply sorting
        if ($request->has('order') && $request->order) {
            $columnIndex = $request->order[0]['column']; // Column index from DataTables
            $sortDirection = $request->order[0]['dir']; // 'asc' or 'desc'
            $columnName = $request->columns[$columnIndex]['data']; // Column name

            if (!empty($columnName) && in_array($columnName, [
                'product_code', 'product_name', 'branch_code', 'branch_name', 'quantity', 'opname_quantity', 'date'
            ])) {
                $query->orderBy($columnName, $sortDirection);
            }
        }

        if (!$request->has('order')) {
            $query->orderBy('products.name', 'asc');
        }

        // Pagination parameters
        $start = $request->input('start', 0);
        $length = $request->input('length', 10);

        $totalRecords = DB::table('stocks')->count(); // Total records without filters
        $filteredRecords = $query->count(); // Total records after filters
        $data = $query->orderBy('id', 'desc')->skip($start)->take($length)->get(); // Paginated data

        $response = [
            'draw' => $request->input('draw'),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $data
        ];

        return response()->json($response);
    }
}
