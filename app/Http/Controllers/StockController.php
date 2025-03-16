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

        // Base query
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

        // Pagination parameters
        $start = $request->input('start', 0);
        $length = $request->input('length', 10);

        // Total records count
        $totalRecords = DB::table('stocks')->count();

        // Correctly count filtered records using subquery
        $filteredRecords = DB::table(DB::raw("({$query->toSql()}) as subquery"))
            ->mergeBindings($query)
            ->count();

        // Get paginated data
        $data = $query->orderBy('stocks.id', 'desc')
            ->skip($start)
            ->take($length)
            ->get();

        // Prepare response
        $response = [
            'draw' => $request->input('draw'),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $data
        ];

        return response()->json($response);
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

        // Start transaction to ensure both operations (stock log insertion and stock update) succeed or fail together
        DB::beginTransaction();

        try {
            $stockOpname = DB::table('stock_opnames')->insertGetId([
                'stock_id' => $validated['stock_id'],
                'quantity' => $validated['quantity'] ?? 0,
                'date' => Carbon::now('Asia/Jakarta'),
            ]);

            // Commit the transaction
            DB::commit();

            return redirect()->route('stocks.opname-index', ['stockId' => $validated['stock_id']]);
        } catch (\Exception $e) {
            // Rollback the transaction if something goes wrong
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

            DB::table('stock_opnames')
                ->where('id', $request->id)
                ->update([
                    'quantity' => number_format($request->quantity, 2, '.', ''),
                    'updated_at' => now()
                ]);

        return response()->json(['success' => true, 'message' => 'Quantity updated successfully']);
    }

}
