<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;

class ProductController extends Controller
{
    public function index() {
        return view('modules.master.product.index');
    }

    public function getLists(Request $request) {

        $params = $request->all();

        $query = DB::table('products')
            ->leftJoin('product_categories', 'products.category_id', '=', 'product_categories.id')
            ->select('products.*', 'product_categories.name as category_name');

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

        // Validate input fields, including image upload
        // $request->validate([
        //     'name' => 'required|string|max:255',
        //     'media' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        // ]);

        // Handle the image upload
        $imagePath = null;
        if ($request->hasFile('media')) {
            // Store image in 'public/products' directory
            $imagePath = $request->file('media')->store('products', 'public');
        }

        DB::transaction(function () use ($request, $imagePath) {
            // Insert new product and retrieve its ID
            $productId = DB::table('products')->insertGetId([
                "code" => $request->code,
                "name" => $request->name,
                "is_active" => $request->is_active,
                "category_id" => $request->category_id,
                "url_path" => $imagePath
            ]);

            // Retrieve all branches
            $branches = DB::table('branches')->get();

            // Prepare product_details entries
            $productDetails = $branches->map(function ($branch) use ($productId) {
                return [
                    'product_id' => $productId,
                    'branch_id' => $branch->id,
                ];
            })->toArray();

            // Insert into product_details
            DB::table('product_details')->insert($productDetails);
        });

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

        // Initialize update data
        $updateData = [
            'code' => $request->code,
            'name' => $request->name,
            'is_active' => $request->is_active,
            'category_id' => $request->category_id,
        ];

        $imagePath = null;
        if ($request->hasFile('media')) {
            // Store image in 'public/products' directory
            $imagePath = $request->file('media')->store('products', 'public');
            $updateData['url_path'] = $imagePath;
        }

        DB::table('products')
            ->where('id', $request->id)
            ->update($updateData);

        return redirect()->route('products.index');
    }

    public function getListProducts(Request $request) {
        $params = $request->q;
        $branchId = $request->branch_id;

        $query = DB::table('products')
            ->leftJoin('product_details', 'products.id', '=', 'product_details.product_id')
            ->leftJoin('product_categories', 'products.category_id', '=', 'product_categories.id')
            ->select(
                'products.*',
                'product_categories.name as category_name',
                'product_details.price',
                'product_details.branch_id',
                'product_details.discount',
                'product_details.start_period',
                'product_details.end_period'
                )
            ->where('product_details.branch_id', $branchId)
            ->where('products.is_active', '=', 1);

        if($params != null) {
            $query->where('products.name', 'like', '%'.strtoupper($params).'%');
        }

        $totalRecords = $query->count();
        $filteredRecords = $query->count();

        $data = $query->orderBy('products.name', 'asc')->get();

        // Map url_path
        $data = $data->map(function ($product) {
            if ($product->url_path) {
                $product->url_path = asset('storage/' . $product->url_path);
            } else {
                $product->url_path = asset('storage/default.png'); // Optional default image
            }
            return $product;
        });

        $response = [
            'draw' => $request->input('draw'),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $data
        ];

        return response()->json($response);
    }

}
