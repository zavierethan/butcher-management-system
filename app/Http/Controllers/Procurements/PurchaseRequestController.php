<?php

namespace App\Http\Controllers\Procurements;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Exports\PurchaseRequestExport;
use Maatwebsite\Excel\Facades\Excel;

use DB;
use Auth;

class PurchaseRequestController extends Controller
{
    public function index() {
        $branches =  DB::table('branches')->where('is_active', 1)->get();
        return view('modules.procurements.purchase-request.index', compact('branches'));
    }

    public function getLists(Request $request) {
        $params = $request->all();

        $query = DB::table('purchase_requests')
                ->select(
                    'purchase_requests.id',
                    'purchase_requests.request_number',
                    DB::raw("TO_CHAR(purchase_requests.request_date, 'DD/MM/YYYY') as request_date"),
                    'purchase_requests.pic',
                    'purchase_requests.category',
                    'purchase_requests.status',
                    'branches.name as alocation',
                    DB::raw("TO_CHAR(purchase_requests.nominal_application, 'FM999,999,999') as nominal_application"),
                    DB::raw("TO_CHAR(purchase_requests.nominal_realization, 'FM999,999,999') as nominal_realization")
                )
                ->leftJoin('branches', 'branches.id', '=', 'purchase_requests.alocation');

        // Apply global search if provided
        $searchValue = $request->input('search.value'); // This is where DataTables sends the search input
        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('purchase_requests.request_number', 'like', '%' . strtoupper($searchValue) . '%');
            });
        }

        // Apply sorting
        if ($request->has('order') && $request->order) {
            $columnIndex = $request->order[0]['column']; // Column index from the DataTable
            $sortDirection = $request->order[0]['dir']; // 'asc' or 'desc'
            $columnName = $request->columns[$columnIndex]['data']; // Column name

            $query->orderBy($columnName, $sortDirection);
        }

        if (!empty($params['start_date']) && !empty($params['end_date'])) {
            $query->whereBetween('purchase_requests.request_date', [
                $params['start_date'],
                $params['end_date']
            ]);
        }

        if (!empty($params['category'])) {
            $query->where('purchase_requests.category', $params['category']);
        }

        if (!empty($params['status'])) {
            $query->where('purchase_requests.status', $params['status']);
        }

        if (!empty($params['alocation'])) {
            $query->where('purchase_requests.alocation', $params['alocation']);
        }

        $start = $request->input('start', 0);
        $length = $request->input('length', 10);

        $totalRecords = $query->count();
        $filteredRecords = $query->count();
        $data = $query->orderBy('id', 'desc')->skip($start)->take($length)->get();

        return response()->json([
            'draw' => $request->input('draw'),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $data
        ]);
    }

    public function create() {
        $branches = DB::table('branches')->where('is_active', 1)->get();
        $items = DB::table('products')->get();
        return view('modules.procurements.purchase-request.create', compact('branches', 'items'));
    }

    public function save(Request $request) {
        $payloads = $request->all();

        try {
            // Start a database transaction
            DB::beginTransaction();

            $requestNumber = DB::select('SELECT generate_purchase_request_number() AS purchase_request_number')[0]->purchase_request_number;

            $requestId = DB::table('purchase_requests')->insertGetId([
                "request_number" => $requestNumber,
                "request_date" => $payloads["header"]["date"],
                "alocation" => $payloads["header"]["alocation"],
                "pic" => $payloads["header"]["pic"],
                "category" => $payloads["header"]["category"],
                "status" => "pending",
                "nominal_application" => $payloads["header"]["nominal_application"],
                "nominal_realization" => 0,
            ]);

            // Save the transaction details
            foreach ($payloads['details'] as $detail) {
                DB::table('purchase_request_items')->insertGetId([
                    "purchase_request_id" => $requestId,
                    "item_id" =>  $detail["item_id"],
                    "quantity" => $detail["quantity"],
                    "price" => $detail["price"],
                    "category" => $detail["category"],
                ]);
            }

            // Commit the transaction
            DB::commit();

            // Return success response
            return response()->json([
                'message' => 'Purchase Request successfully created',
                'request_number' => $requestNumber,
            ], 201);

        } catch (\Exception $e) {
            // Rollback transaction in case of error
            DB::rollBack();

            // Return error response
            return response()->json([
                'message' => 'Failed to create transaction',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function edit($id) {
        $branches = DB::table('branches')->where('is_active', 1)->get();

        $purchaseRequest = DB::table('purchase_requests')->where('id', $id)->first();

        if($purchaseRequest->category == 'PR') {
            $purchaseRequestItems = DB::table('purchase_request_items')
                            ->select(
                                'products.name as product_name',
                                'purchase_request_items.*'
                            )
                            ->leftJoin('products', 'products.id', '=', 'purchase_request_items.item_id')
                            ->where('purchase_request_id', $purchaseRequest->id)->get();
        } else {
            $purchaseRequestItems = DB::table('purchase_request_items')
                            ->select(
                                'inventories.name as product_name',
                                'purchase_request_items.*'
                            )
                            ->leftJoin('inventories', 'inventories.id', '=', 'purchase_request_items.item_id')
                            ->where('purchase_request_id', $purchaseRequest->id)->get();
        }

        return view('modules.procurements.purchase-request.edit', compact('branches','purchaseRequest', 'purchaseRequestItems'));
    }

    public function approval($id) {
        $branches = DB::table('branches')->where('is_active', 1)->get();

        $purchaseRequest = DB::table('purchase_requests')->where('id', $id)->first();

        if($purchaseRequest->category == 'PR') {
            $purchaseRequestItems = DB::table('purchase_request_items')
                            ->select(
                                'products.name as product_name',
                                'purchase_request_items.*'
                            )
                            ->leftJoin('products', 'products.id', '=', 'purchase_request_items.item_id')
                            ->where('purchase_request_id', $purchaseRequest->id)->get();
        } else {
            $purchaseRequestItems = DB::table('purchase_request_items')
                            ->select(
                                'inventories.name as product_name',
                                'purchase_request_items.*'
                            )
                            ->leftJoin('inventories', 'inventories.id', '=', 'purchase_request_items.item_id')
                            ->where('purchase_request_id', $purchaseRequest->id)->get();
        }

        return view('modules.procurements.purchase-request.approval', compact('branches','purchaseRequest', 'purchaseRequestItems'));
    }

    public function update(Request $request) {

        DB::table('purchase_requests')->where('id', $request->id)->update([
            "nominal_realization" => $request->sub_total,
            "approval_date" => date('Y-m-d H:i:s'),
            "approved_by" => Auth::user()->name,
            "status" => $request->status
        ]);

        return response()->json([
            'message' => 'Purchase Request successfully updated'
        ], 200);

    }

    public function getPurchaseRequest(Request $request) {

        $params = $request["category"];

        $query = DB::table('purchase_requests')
                        ->select('purchase_requests.id', 'purchase_requests.request_number', 'branches.name as requestor')
                        ->leftJoin('branches', 'branches.id', '=', 'purchase_requests.alocation')
                        ->where('status', 'approve')->where('has_proccessed', 0);

        if($params == 'OP') {
            $query->where('purchase_requests.category', 'OP');
        }

        if($params == 'PR') {
            $query->where('purchase_requests.category', 'PR');
        }

        $response = $query->get();

        return response()->json($response);
    }

    public function getPurchaseRequestItem(Request $request) {
        $params = $request->purchase_request_id;

        $category = DB::table('purchase_requests')->where('id', $params)->value('category');

        if($category == 'PR') {
            $response = DB::table('purchase_request_items')
                ->select(
                    'purchase_requests.request_number',
                    'purchase_request_items.id as purchase_request_item_id',
                    'purchase_request_items.item_id',
                    'products.name',
                    'purchase_request_items.category',
                    'purchase_request_items.quantity',
                    DB::raw("TO_CHAR(purchase_request_items.price, 'FM999,999,999') as price"),
                    DB::raw("TO_CHAR(purchase_request_items.price * purchase_request_items.quantity , 'FM999,999,999') as total_price")
                )
                ->join('purchase_requests', 'purchase_requests.id', '=', 'purchase_request_items.purchase_request_id')
                ->leftJoin('products', 'products.id', '=', 'purchase_request_items.item_id')
                ->where('approval_status', 1)
                ->where('purchase_request_id', $params)
                ->get();
        } else {
            $response = DB::table('purchase_request_items')
                ->select(
                    'purchase_requests.request_number',
                    'purchase_request_items.id as purchase_request_item_id',
                    'purchase_request_items.item_id',
                    'inventories.name',
                    'purchase_request_items.category',
                    'purchase_request_items.quantity',
                    DB::raw("TO_CHAR(purchase_request_items.price, 'FM999,999,999') as price"),
                    DB::raw("TO_CHAR(purchase_request_items.price * purchase_request_items.quantity , 'FM999,999,999') as total_price")
                )
                ->join('purchase_requests', 'purchase_requests.id', '=', 'purchase_request_items.purchase_request_id')
                ->leftJoin('inventories', 'inventories.id', '=', 'purchase_request_items.item_id')
                ->where('approval_status', 1)
                ->where('purchase_request_id', $params)
                ->get();
        }

        return response()->json($response);
    }

    public function approveItem(Request $request) {
        DB::table('purchase_request_items')->where('id', $request->id)->update([
            "quantity" => $request->quantity,
            "price" => $request->price,
            "approval_status" => $request->approval_status
        ]);

        return response()->json([
            'message' => 'Purchase Order successfully updated'
        ], 200);
    }

    public function export(Request $request) {

        $filters = [
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'category' => $request->category,
            'alocation' => $request->alocation,
            'status' => $request->status,
        ];

        // Generate raw Excel data
        $export = new PurchaseRequestExport($filters);
        $excelData = Excel::raw($export, \Maatwebsite\Excel\Excel::XLSX);

        // Return the data as a proper response
        return response($excelData, 200, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="transaction-reports.xlsx"',
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0',
        ]);
    }
}
