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
}
