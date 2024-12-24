<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;

class ProductDetailController extends Controller
{
    public function index() {
        return view('modules.master.product-detail.index');
    }

    public function getLists(Request $request, $id) {

        $params = $request->all();

        $currentUserBranchId = Auth::user()->branch_id;
        //TODO tambah kondisi jika user adalah admin, maka tidak berlaku kondisi per cabang

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
            ->where('branches.is_active', '=', 1)
            ->where('product_details.branch_id', '=', $currentUserBranchId)
            ->where('product_details.product_id', '=', $id);


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

    public function create($product_id) {
        $products = DB::table('products')->orderBy('name', 'asc')->get();

        $branches = DB::table('branches')
            ->leftJoin('product_details', function ($join) use ($product_id) {
                $join->on('branches.id', '=', 'product_details.branch_id')
                    ->where('product_details.product_id', '=', $product_id);
            })
            ->whereNull('product_details.id')
            ->select('branches.*')
            ->orderBy('branches.name', 'asc')
            ->get();

        return view('modules.master.product-detail.create', compact('products', 'branches', 'product_id'));
        // var_dump($branches);
    }

    public function save(Request $request) {
        $baseUrl = config('app.url');

        //TODO check if entry with same product id and branch id already exists
        DB::table('product_details')->insert([
            "product_id" => $request->product_id,
            "branch_id" => $request->branch_id,
            "price" => $request->price,
            "discount" => $request->discount,
            "start_period" => $request->calendar_event_start_date,
            "end_period" => $request->calendar_event_end_date,
        ]);

        // return redirect()->route('product-details.index');
        return redirect()->route('products.edit', ['id' => $request->product_id]);
    }

    public function edit($id) {
        $productDetails = DB::table('product_details')->where('id', $id)->first();
        $products = DB::table('products')->orderBy('name', 'asc')->get();
        $selectedProductId = $productDetails->product_id;
        $selectedBranchId = $productDetails->branch_id;
        $branches = DB::table('branches')
            ->leftJoin('product_details', function ($join) use ($selectedProductId) {
                $join->on('branches.id', '=', 'product_details.branch_id')
                    ->where('product_details.product_id', '=', $selectedProductId);
            })
            ->whereNull('product_details.id')
            ->select('branches.*')
            ->orderBy('branches.name', 'asc')
            ->get();

        if (!$productDetails) {
            return redirect()->route('product-details.index')->with('error', 'Product detail not found.');
        }

        return view('modules.master.product-detail.edit', compact('productDetails', 'products', 'branches', 'selectedProductId', 'selectedBranchId'));
    }

    public function update(Request $request) {
        //TODO add validation and updated_by based on user

        DB::table('product_details')
            ->where('id', $request->id)
            ->update([
                "product_id" => $request->product_id,
                "branch_id" => $request->branch_id,
                "price" => $request->price,
                "discount" => $request->discount,
                "start_period" => $request->calendar_event_start_date,
                "end_period" => $request->calendar_event_end_date,
            ]);

        return redirect()->route('products.edit', ['id' => $request->product_id]);
    }
}
