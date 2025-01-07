<?php

namespace App\Http\Controllers\Procurements;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DB;

class PurchaseRequestController extends Controller
{
    public function index() {
        return view('modules.procurements.purchase-request.index');
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
        return view('modules.procurements.purchase-request.create', compact('branches'));
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
        $purchaseRequestItems = DB::table('purchase_requests')->where('id', $id);

        return view('modules.procurements.purchase-request.edit', compact('branches','purchaseRequest', 'purchaseRequestItems'));
    }
}
