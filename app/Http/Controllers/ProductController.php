<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class ProductController extends Controller
{
    public function index() {
        return view('modules.master.product.index');
    }

    public function getLists(Request $request) {

        $params = $request->all();

        $query = DB::table('products');

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
        $categories = DB::table('product_categories')->orderBy('name', 'asc')->get();

        return view('modules.master.product.create', compact('categories'));
    }

    public function save(Request $request) {
        $baseUrl = config('app.url');

        //TODO set created_by and updated)_by
        DB::table('products')->insert([
            "code" => $request->code,
            "name" => $request->name,
            "price" => $request->price,
            "is_active" => $request->is_active,
            "category_id" => $request->category_id
        ]);

        return redirect()->route('products.index');
    }

    public function edit($id) {
        $product = DB::table('products')->where('id', $id)->first();
        $selectedCategoryId = $product->category_id;
        $categories = DB::table('product_categories')->orderBy('name', 'asc')->get();

        if (!$product) {
            return redirect()->route('products.index')->with('error', 'Product not found.');
        }

        return view('modules.master.product.edit', compact('product', 'selectedCategoryId', 'categories'));
    }

    public function update(Request $request) {
        // $request->validate([
        //     'code' => 'required|string',
        //     'name' => 'required|string',
        //     'price' => 'required|numeric',
        // ]);
        
        //TODO add validation and updated_by based on user

        DB::table('products')
            ->where('id', $request->id)
            ->update([
                'code' => $request->code,
                'name' => $request->name,
                'price' => $request->price,
                "is_active" => $request->is_active,
                "category_id" => $request->category_id
            ]);

        return redirect()->route('products.index');
    }

}
