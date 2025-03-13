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

        // Insert branch baru ke branches table dan get ID nya
        $branchId = DB::table('branches')->insertGetId([
            "code" => $request->code,
            "name" => $request->name,
            "address" => $request->address,
            "phone_number" => $request->phone_number,
            "is_active" => $request->is_active,
        ]);

        $products = DB::table('products')->get();
        // buat entry product details untuk di insert
        $productDetails = $products->map(function ($product) use ($branchId) {
            return [
                'product_id' => $product->id,
                'branch_id' => $branchId,
            ];
        })->toArray();

        // Insert product details untuk branch baru tersebut
        DB::table('product_details')->insert($productDetails);

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

        $products = DB::table('product_details')
            ->leftJoin('products', 'products.id', '=', 'product_details.product_id')
            ->select(
                'products.id',
                'product_details.branch_id',
                'products.name',
                'products.code',
                'products.group_flag',
                'product_details.cogs',
                'product_details.cogs_plus_margin',
                'product_details.price',
                'product_details.discount',
                'product_details.start_period',
                'product_details.end_period',
                'product_details.is_active',
            )
            ->where('product_details.branch_id', $id)
            ->orderBy('sort_order', 'asc')
            ->get();

        return view('modules.master.branch.product-setting', compact('branch', 'products'));
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
