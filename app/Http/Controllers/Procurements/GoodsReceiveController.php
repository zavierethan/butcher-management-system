<?php

namespace App\Http\Controllers\Procurements;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DB;

class GoodsReceiveController extends Controller
{
    public function index() {
        $suppliers = DB::table('suppliers')->where('is_active', 1)->get();
        return view('modules.procurements.goods-receive.index', compact('suppliers'));
    }

    public function getLists(Request $request){
        $params = $request->all();

        $query = DB::table('purchase_orders')
                ->select(
                    'purchase_orders.id',
                    'purchase_orders.purchase_order_number',
                    DB::raw("TO_CHAR(purchase_orders.received_date, 'DD/MM/YYYY') as received_date"),
                    'purchase_orders.category',
                    'purchase_orders.received_by',
                    'suppliers.name',
                    'purchase_orders.status'
                )
                ->leftJoin('suppliers', 'suppliers.id', '=', 'purchase_orders.supplier_id')
                ->where('purchase_orders.status', 2);

        // Apply global search if provided
        $searchValue = $request->input('search.value');
        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('purchase_orders.purchase_order_number', 'like', '%' . strtoupper($searchValue) . '%');
            });
        }

        // Apply sorting
        if ($request->has('order') && $request->order) {
            $columnIndex = $request->order[0]['column'];
            $sortDirection = $request->order[0]['dir'];
            $columnName = $request->columns[$columnIndex]['data'];
            $query->orderBy($columnName, $sortDirection);
        }

        if (!empty($params['start_date']) && !empty($params['end_date'])) {
            $query->whereBetween('purchase_orders.order_date', [
                $params['start_date'],
                $params['end_date']
            ]);
        }

        if (!empty($params['supplier'])) {
            $query->where('purchase_orders.supplier_id', $params['supplier']);
        }

        if (!empty($params['category'])) {
            $query->where('purchase_orders.category', $params['category']);
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
        $purchaseOrders = DB::table('purchase_orders')->where('status','!=', 2)->get();
        return view('modules.procurements.goods-receive.create', compact('purchaseOrders'));
    }

    public function save(Request $request) {
        $payloads = $request->all();

        try {
            // Start a database transaction
            DB::beginTransaction();

            $orderId = DB::table('purchase_orders')->where('id', $payloads["header"]["purchase_order_id"])->update([
                "received_date" => $payloads["header"]["received_date"],
                "received_by" => $payloads["header"]["received_by"],
                "payment_status" => $payloads["header"]["payment_status"],
                "status" => 2,
            ]);

            // Save the transaction details
            foreach ($payloads['details'] as $detail) {
                DB::table('purchase_order_items')->where('id', $detail["purchase_order_item_id"])->update([
                    "received_quantity" => $detail["received_quantity"],
                    "received_unit" => $detail["received_unit"],
                    "received_price" => $detail["received_price"],
                    "realisation" => $detail["realisation"],
                    "remarks" => $detail["remarks"]
                ]);
            }

            // Commit the transaction
            DB::commit();

            // Return success response
            return response()->json([
                'message' => 'Goods Received successfully created',
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

    public function edit($id){
        $purchaseOrder = DB::table('purchase_orders')->where('id', $id)->first();

        if($purchaseOrder->category == 'PR') {
            $items = DB::table('purchase_order_items')
                    ->select(
                        'purchase_order_items.id',
                        'products.name',
                        'purchase_request_items.item_notes',
                        'purchase_order_items.quantity',
                        DB::raw("TO_CHAR(purchase_order_items.price, 'FM999,999,999') as price"),
                        'purchase_order_items.received_quantity',
                        DB::raw("TO_CHAR(purchase_order_items.received_price, 'FM999,999,999') as received_price"),
                        DB::raw("
                                CASE
                                    WHEN purchase_order_items.realisation = 1 THEN 'TEREALISASI'
                                    ELSE 'TIDAK TEREALISASI'
                                END AS realisation
                            "),
                        'purchase_order_items.remarks',
                    )
                    ->leftJoin('products', 'products.id', '=', 'purchase_order_items.item_id')
                    ->join('purchase_request_items', 'purchase_request_items.id', '=', 'purchase_order_items.purchase_request_item_id')
                    ->where('purchase_order_id', $purchaseOrder->id)->get();
        } else {
            $items = DB::table('purchase_order_items')
                    ->select(
                        'purchase_order_items.id',
                        'inventories.name',
                        'purchase_request_items.item_notes',
                        'purchase_order_items.quantity',
                        DB::raw("TO_CHAR(purchase_order_items.price, 'FM999,999,999') as price"),
                        'purchase_order_items.received_quantity',
                        DB::raw("TO_CHAR(purchase_order_items.received_price, 'FM999,999,999') as received_price"),
                        'purchase_order_items.remarks',
                    )
                    ->leftJoin('inventories', 'inventories.id', '=', 'purchase_order_items.item_id')
                    ->join('purchase_request_items', 'purchase_request_items.id', '=', 'purchase_order_items.purchase_request_item_id')
                    ->where('purchase_order_id', $purchaseOrder->id)->get();
        }

        return view('modules.procurements.goods-receive.edit', compact('purchaseOrder', 'items'));
    }
}
