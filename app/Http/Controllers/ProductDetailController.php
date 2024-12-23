<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class ProductDetailController extends Controller
{
    public function index() {
        return view('modules.master.product-detail.index');
    }

    public function getLists(Request $request) {

        $params = $request->all();

        $query = DB::table('product_details')
            ->leftJoin('products', 'product_details.product_id', '=', 'products.id')
            ->leftJoin('branches', 'product_details.branch_id', '=', 'branches.id')
            ->select(
                'product_details.*',
                'products.id as product_id',
                'products.code as product_code',
                'products.name as product_name',
                'branches.id as branch_id',
                'branches.code as branch_code',
                'branches.name as branch_name'
            )
            ->where('products.is_active', '=', 1)
            ->where('branches.is_active', '=', 1);


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

    public function create() {
        return view('modules.master.product-category.create');
    }

    public function save(Request $request) {
        $baseUrl = config('app.url');

        //TODO check if entry with same product id and branch id already exists
        DB::table('product_details')->insert([
            "product_id" => $request->product_id,
            "branch_id" => $request->branch_id,
            "price" => $request->price,
            "discount" => $request->discount,
            "start_period" => $request->start_period,
            "end_period" => $request->end_period,
        ]);

        return redirect()->route('product-details.index');
    }

    public function edit($id) {
        $productDetail = DB::table('product_details')->where('id', $id)->first();

        if (!$productDetail) {
            return redirect()->route('product-details.index')->with('error', 'Product detail not found.');
        }

        return view('modules.master.product-detail.edit', compact('productDetail'));
    }

    public function update(Request $request) {
        // $request->validate([
        //     'code' => 'required|string',
        //     'name' => 'required|string',
        //     'price' => 'required|numeric',
        // ]);
        
        //TODO add validation and updated_by based on user

        DB::table('product_details')
            ->where('id', $request->id)
            ->update([
                "price" => $request->price,
                "discount" => $request->discount,
                "start_period" => $request->start_period,
                "end_period" => $request->end_period,
            ]);

        return redirect()->route('product-details.index');
    }
}
