<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class ProductCategoryController extends Controller
{
    public function index() {
        return view('modules.master.product-category.index');
    }

    public function getLists(Request $request) {

        $params = $request->all();

        $query = DB::table('product_categories');

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

        //TODO set created_by and updated)_by
        DB::table('product_categories')->insert([
            "name" => $request->name,
            "is_active" => $request->is_active,
        ]);

        return redirect()->route('product-categories.index');
    }

    public function edit($id) {
        $productCategory = DB::table('product_categories')->where('id', $id)->first();

        if (!$productCategory) {
            return redirect()->route('product-categories.index')->with('error', 'Product category not found.');
        }

        return view('modules.master.product-category.edit', compact('productCategory'));
    }

    public function update(Request $request) {
        // $request->validate([
        //     'code' => 'required|string',
        //     'name' => 'required|string',
        //     'price' => 'required|numeric',
        // ]);
        
        //TODO add validation and updated_by based on user

        DB::table('product_categories')
            ->where('id', $request->id)
            ->update([
                'name' => $request->name,
                "is_active" => $request->is_active,
            ]);

        return redirect()->route('product-categories.index');
    }

    public function getProductCategories() {
        $categories = DB::table('product_categories')->pluck('name', 'id'); // Fetch categories with their IDs
        return response()->json($categories); // Return as JSON
    }


}
