<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class ProductController extends Controller
{
    public function index() {
        $products = $this->getList();

        return view('modules.master.product.index', compact('products'));
    }

    public function getList() {
        // $products = DB::table('products')
        //     ->leftjoin('stocks', 'products.id', '=', 'stocks.product_id')
        //     ->leftJoin('branches', 'branches.id', '=', 'stocks.branch_id')
        //     ->select('products.id', 'products.code', 'products.name', 'products.price', 'stocks.quantity', 'branches.name as branch_name')
        //     ->where('products.is_active', 1)
        //     ->paginate(10);

        $products = DB::table('products')
            ->select('products.id', 'products.code', 'products.name', 'products.price')
            ->where('products.is_active', 1)
            ->paginate(10);

        return $products;
    }

    public function edit($id) {
        $product = DB::table('products')->where('id', $id)->first();

        if (!$product) {
            return redirect()->route('products.index')->with('error', 'Product not found.');
        }

        return view('modules.master.product.edit', compact('product'));
    }

    public function update(Request $request, $id) {
        $request->validate([
            'code' => 'required|string',
            'name' => 'required|string',
            'price' => 'required|numeric',
        ]);

        DB::table('products')
            ->where('id', $id)
            ->update([
                'code' => $request->code,
                'name' => $request->name,
                'price' => $request->price,
            ]);

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy($id) {
        DB::table('products')
            ->where('id', $id)
            ->update(['is_active' => 0]);

        return redirect()->route('products.index')->with('success', 'Product soft deleted successfully!');
    }

    public function create() {
        return view('modules.master.product.create');
    }

    //TODO: CREATE AN ALERT FOR INVALID DATA INPUT
    public function store(Request $request) {
        // Validate the data
        $validatedData = $request->validate([
            'code' => 'required|unique:products,code',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);

        // Insert the new product
        DB::table('products')->insert([
            'code' => $validatedData['code'],
            'name' => $validatedData['name'],
            'price' => $validatedData['price'],
            'is_active' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('products.index')->with('success', 'Product created successfully!');
    }

}
