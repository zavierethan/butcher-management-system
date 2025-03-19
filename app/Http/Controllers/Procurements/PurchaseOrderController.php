<?php

namespace App\Http\Controllers\Procurements;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Exports\PurchaseOrderExport;
use Maatwebsite\Excel\Facades\Excel;

use DB;
use PDF;

class PurchaseOrderController extends Controller
{
    public function index() {
        $suppliers = DB::table('suppliers')->where('is_active', 1)->get();
        return view('modules.procurements.purchase-order.index', compact('suppliers'));
    }

    public function getLists(Request $request) {
        $params = $request->all();

        $query = DB::table('purchase_orders')
                ->select(
                    'purchase_orders.id',
                    'purchase_orders.purchase_order_number',
                    DB::raw("TO_CHAR(purchase_orders.order_date, 'DD/MM/YYYY') as order_date"),
                    'purchase_orders.category',
                    'purchase_orders.status',
                    'suppliers.name as supplier_name',
                    DB::raw("TO_CHAR(purchase_orders.total_amount, 'FM999,999,999') as total_amount")
                )
                ->leftJoin('suppliers', 'suppliers.id', '=', 'purchase_orders.supplier_id');

        // Apply global search if provided
        $searchValue = $request->input('search.value'); // This is where DataTables sends the search input
        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('purchase_orders.purchase_order_number', 'like', '%' . strtoupper($searchValue) . '%');
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
            $query->whereBetween('purchase_orders.order_date', [
                $params['start_date'],
                $params['end_date']
            ]);
        }

        if (!empty($params['category'])) {
            $query->where('purchase_orders.category', $params['category']);
        }

        if (!empty($params['status'])) {
            $query->where('purchase_orders.status', $params['status']);
        }

        if (!empty($params['supplier'])) {
            $query->where('purchase_orders.supplier_id', $params['supplier']);
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
        $suppliers = DB::table('suppliers')->where('is_active', 1)->get();
        $purchaseRequests = DB::table('purchase_requests')
                        ->select('purchase_requests.id', 'purchase_requests.request_number', 'branches.name as requestor')
                        ->leftJoin('branches', 'branches.id', '=', 'purchase_requests.alocation')
                        ->whereIn('status', [2, 3])->get();
        return view('modules.procurements.purchase-order.create', compact('suppliers', 'purchaseRequests'));
    }

    public function save(Request $request) {
        $payloads = $request->all();

        try {
            // Start a database transaction
            DB::beginTransaction();

            $orderNumber = DB::select('SELECT generate_purchase_order_number() AS purchase_order_number')[0]->purchase_order_number;

            $orderId = DB::table('purchase_orders')->insertGetId([
                "purchase_order_number" => $orderNumber,
                "order_date" => $payloads["header"]["date"],
                "supplier_id" => $payloads["header"]["supplier"],
                // "pic" => $payloads["header"]["pic"],
                "category" => $payloads["header"]["category"],
                "total_amount" => $payloads["header"]["total_amount"],
                "payment_status" => $payloads["header"]["payment_status"], // 1 = UnPaid / Hutang, 2 = Paid
                "status" => 1,
            ]);

            // Save the transaction details
            foreach ($payloads['details'] as $detail) {
                DB::table('purchase_order_items')->insertGetId([
                    "purchase_order_id" => $orderId,
                    "purchase_request_item_id" => $detail["purchase_request_item_id"],
                    "item_id" =>  $detail["item_id"],
                    "quantity" => $detail["quantity"],
                    "price" => $detail["price"],
                ]);

                DB::table('purchase_requests')->where('request_number', $detail["item_req_number"])->update(["status" => 5]);
            }

            // Commit the transaction
            DB::commit();

            // Return success response
            return response()->json([
                'message' => 'Purchase Order successfully created',
                'order_number' =>  $orderNumber,
                'order_id' =>  $orderId,
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
        $suppliers = DB::table('suppliers')->where('is_active', 1)->get();
        $purchaseOrder = DB::table('purchase_orders')->where('id', $id)->first();

        if($purchaseOrder->category == 'PR') {
            $items = DB::table('purchase_order_items')
                    ->select(
                        'products.name',
                        'purchase_request_items.item_notes',
                        'purchase_order_items.quantity',
                        'purchase_order_items.price',
                        DB::raw("purchase_order_items.price * purchase_order_items.quantity as total")
                    )
                    ->leftJoin('products', 'products.id', '=', 'purchase_order_items.item_id')
                    ->join('purchase_request_items', 'purchase_request_items.id', '=', 'purchase_order_items.purchase_request_item_id')
                    ->where('purchase_order_id', $purchaseOrder->id)->get()->map(function ($item) {
                        // Format the prices using number_format
                        $item->price = number_format($item->price, 0, '.', ',');// Format for money
                        return $item;
                    });
        } else {
            $items = DB::table('purchase_order_items')
                    ->select(
                        'inventories.name',
                        'purchase_request_items.item_notes',
                        'purchase_order_items.quantity',
                        'purchase_order_items.price',
                        DB::raw("purchase_order_items.price * purchase_order_items.quantity as total")
                    )
                    ->leftJoin('inventories', 'inventories.id', '=', 'purchase_order_items.item_id')
                    ->join('purchase_request_items', 'purchase_request_items.id', '=', 'purchase_order_items.purchase_request_item_id')
                    ->where('purchase_order_id', $purchaseOrder->id)->get()->map(function ($item) {
                        // Format the prices using number_format
                        $item->price = number_format($item->price, 0, '.', ',');// Format for money
                        return $item;
                    });
        }

        return view('modules.procurements.purchase-order.edit', compact('suppliers', 'purchaseOrder', 'items'));
    }

    public function update(Request $request) {
        $payloads = $request->all();

        DB::table('purchase_orders')->where('id', $payloads["header"]["id"])->update([
            "status" => $payloads["header"]["status"],
            "total_amount" => $payloads["header"]["sub_total"]
        ]);

        return response()->json([
            'message' => 'Purchase Order successfully updated'
        ], 200);
    }

    public function print($id) {

        $purchaseOrder = DB::table('purchase_orders')
                    ->select(
                        'purchase_orders.id',
                        'purchase_orders.category',
                        'purchase_orders.purchase_order_number',
                        DB::raw("TO_CHAR(purchase_orders.order_date, 'dd/mm/YYYY') as order_date"),
                        'suppliers.name as supplier_name',
                        DB::raw("TO_CHAR(purchase_orders.total_amount, 'FM999,999,999') as total_amount")
                    )
                    ->leftJoin('suppliers', 'suppliers.id', '=', 'purchase_orders.supplier_id')
                    ->where('purchase_orders.id', $id)->first();

        if($purchaseOrder->category == 'PR') {
            $detailItems = DB::table('purchase_order_items')
                    ->select(
                        'products.name',
                        'purchase_order_items.quantity',
                        'purchase_order_items.price',
                        DB::raw("purchase_order_items.price * purchase_order_items.quantity as total")
                    )
                    ->leftJoin('products', 'products.id', '=', 'purchase_order_items.item_id')
                    ->where('purchase_order_id', $purchaseOrder->id)->get()->map(function ($item) {
                        // Format the prices using number_format
                        $item->price = number_format($item->price, 0, '.', ',');// Format for money
                        return $item;
                    });
        } else {
            $detailItems = DB::table('purchase_order_items')
                    ->select(
                        'inventories.name',
                        'purchase_order_items.quantity',
                        'purchase_order_items.price',
                        DB::raw("purchase_order_items.price * purchase_order_items.quantity as total")
                    )
                    ->leftJoin('inventories', 'inventories.id', '=', 'purchase_order_items.item_id')
                    ->where('purchase_order_id', $purchaseOrder->id)->get()->map(function ($item) {
                        // Format the prices using number_format
                        $item->price = number_format($item->price, 0, '.', ',');// Format for money
                        return $item;
                    });
        }

        $imagePath = public_path('assets/media/logos/priyadis-butcherss.png'); // Update the path as needed
        $base64Image = $this->convertImageToBase64($imagePath);

        $pdf = PDF::loadView('modules.procurements.purchase-order.print', [
            "purchaseOrder" => $purchaseOrder,
            "detailItems" => $detailItems,
            "logo" => $base64Image
        ]);

        return $pdf->stream('purchase_order.pdf'); // To display
    }

    public function getPurchaseOrderItem(Request $request) {
        $params = $request->purchase_order_id;

        $category = DB::table('purchase_orders')->where('id', $params)->value('category');

        if($category == 'PR') {
            $response = DB::table('purchase_order_items')
                ->select(
                    'purchase_order_items.id as purchase_order_item_id',
                    'products.name',
                    'purchase_order_items.quantity',
                    DB::raw("TO_CHAR(purchase_order_items.price, 'FM999,999,999') as price")
                )
                ->join('purchase_orders', 'purchase_orders.id', '=', 'purchase_order_items.purchase_order_id')
                ->leftJoin('products', 'products.id', '=', 'purchase_order_items.item_id')
                ->where('purchase_order_items.purchase_order_id', $params)
                ->get();
        } else {
            $response = DB::table('purchase_order_items')
                ->select(
                    'purchase_order_items.id as purchase_order_item_id',
                    'inventories.name',
                    'purchase_order_items.quantity',
                    DB::raw("TO_CHAR(purchase_order_items.price, 'FM999,999,999') as price")
                )
                ->join('purchase_orders', 'purchase_orders.id', '=', 'purchase_order_items.purchase_order_id')
                ->leftJoin('inventories', 'inventories.id', '=', 'purchase_order_items.item_id')
                ->where('purchase_order_items.purchase_order_id', $params)
                ->get();
        }

        return response()->json($response);
    }

    public function export(Request $request) {

        $filters = [
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'category' => $request->category,
            'supplier' => $request->supplier,
            'status' => $request->status,
        ];

        // Generate raw Excel data
        $export = new PurchaseOrderExport($filters);
        $excelData = Excel::raw($export, \Maatwebsite\Excel\Excel::XLSX);

        // Return the data as a proper response
        return response($excelData, 200, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="procurement-reports.xlsx"',
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0',
        ]);
    }

    private function convertImageToBase64($path){
        if (!file_exists($path)) {
            return null;
        }

        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        return 'data:image/' . $type . ';base64,' . base64_encode($data);
    }
}
