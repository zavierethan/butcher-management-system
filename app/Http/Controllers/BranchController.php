<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class BranchController extends Controller
{
    public function index() {
        return view('modules.master.branch.index');
    }

    public function getLists(Request $request) {

        $params = $request->all();

        $query = DB::table('branches');

        $start = $request->input('start', 0);
        $length = $request->input('length', 10);

        $totalRecords = $query->count();
        $filteredRecords = $query->count();
        $data = $query->orderBy('name', 'asc')->skip($start)->take($length)->get();

        $response = [
            'draw' => $request->input('draw'),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $data
        ];

        return response()->json($response);
    }

    public function create() {
        return view('modules.master.branch.create');
    }

    public function save(Request $request) {
        $baseUrl = config('app.url');

        DB::transaction(function () use ($request) {
            // Insert new branch and retrieve its ID
            $branchId = DB::table('branches')->insertGetId([
                "code" => $request->code,
                "name" => $request->name,
                "address" => $request->address,
                "phone_number" => $request->phone_number,
                "is_active" => $request->is_active,
            ]);

            // Retrieve all existing products
            $products = DB::table('products')->get();

            // Prepare product_details and stock entries
            $productDetails = [];
            $stocks = [];

            foreach ($products as $product) {
                $productDetails[] = [
                    'product_id' => $product->id,
                    'branch_id' => $branchId,
                ];

                $stocks[] = [
                    'product_id' => $product->id,
                    'branch_id' => $branchId,
                ];
            }

            // Insert product_details for the new branch
            if (!empty($productDetails)) {
                DB::table('product_details')->insert($productDetails);
            }

            // Insert stock entries for the new branch
            if (!empty($stocks)) {
                DB::table('stocks')->insert($stocks);
            }
        });

        return redirect()->route('branches.index');
    }


    public function edit($id) {
        $branch = DB::table('branches')->where('id', $id)->first();

        if (!$branch) {
            return redirect()->route('branches.index')->with('error', 'Branch not found.');
        }

        return view('modules.master.branch.edit', compact('branch'));
    }

    public function update(Request $request) {
        DB::table('branches')
            ->where('id', $request->id)
            ->update([
                'code' => $request->code,
                'name' => $request->name,
                'address' => $request->address,
                'phone_number' => $request->phone_number,
                "is_active" => $request->is_active,
            ]);

        return redirect()->route('branches.index');
    }

    public function productSettings($id) {
        $branch = DB::table('branches')->where('id', $id)->first();

        $branches = DB::table('branches')->orderBy('id')->get();

        $products = DB::table('product_details')
            ->leftJoin('products', 'products.id', '=', 'product_details.product_id')
            ->select(
                'products.id',
                'product_details.branch_id',
                'products.name',
                'products.code',
                'products.group_flag',
                DB::raw("TO_CHAR(product_details.cogs, 'FM999,999,999') as cogs"),
                'product_details.margin',
                DB::raw("TO_CHAR(product_details.margin_price, 'FM999,999,999') as margin_price"),
                DB::raw("TO_CHAR(product_details.cogs_plus_margin, 'FM999,999,999') as cogs_plus_margin"),
                DB::raw("TO_CHAR(product_details.price, 'FM999,999,999') as price"),
                'product_details.discount',
                'product_details.start_period',
                'product_details.end_period',
                'product_details.is_active',
            )
            ->where('product_details.branch_id', $id)
            ->orderBy('sort_order', 'asc')
            ->get();

        $latestPrice = DB::table('purchase_order_items')
            ->join('purchase_orders', 'purchase_orders.id', '=', 'purchase_order_items.purchase_order_id')
            ->select(
                DB::raw("TO_CHAR(purchase_orders.received_date, 'DD/MM/YYYY') as received_date"),
                DB::raw('ROUND(AVG(purchase_order_items.price)) as avg_price')
            )
            ->where('purchase_orders.received_date', function ($query) {
                $query->select(DB::raw('MAX(received_date)'))
                      ->from('purchase_orders');
            })
            ->groupBy('purchase_orders.received_date')
            ->first();

        return view('modules.master.branch.product-setting', compact('branch', 'branches', 'products', 'latestPrice'));
    }

    public function productSettingBulkUpdate(Request $request) {
        $products = $request->input('products');

        foreach ($products as $productData) {

            if (!isset($productData['branch_id'])) {
                continue;
            }

            DB::table('product_details')
                ->where('branch_id', $productData['branch_id'])
                ->where('product_id', $productData['id'])
                ->update([
                    "cogs" => $productData['cogs'],
                    "margin" => $productData['margin'],
                    "margin_price" => $productData['margin_price'],
                    "cogs_plus_margin" => $productData['cogs_plus_margin'],
                    "price" => $productData['final_sale_price'],
                    "discount" => $productData['discount'],
                    "start_period" => $productData['disc_start'],
                    "end_period" => $productData['disc_end'],
                    "is_active" => $productData['active_status'],
                ]);
        }

        return response()->json(["message" => "Products updated successfully"]);
    }

}
