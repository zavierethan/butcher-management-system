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
            // $query->orWhere('products.code', 'like', '%'.strtoupper($params).'%');
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

    public function getListProductsForCarcass(Request $request) {
        $params = $request->q;

        $query = DB::table('products')
            ->select(
                'products.id',
                'products.code',
                'products.name',
                'products.formula'
            )
            ->where('category_id', function ($query) {
                $query->select('category_id')
                    ->from('products')
                    ->where('name', 'KARKAS')
                    ->limit(1);
            })
            ->where('products.name', '!=', 'KARKAS')
            ->where('products.is_active', '=', 1);

        $totalRecords = $query->count();
        $filteredRecords = $query->count();

        $data = $query->orderBy('products.name', 'asc')->get();

        $response = [
            'draw' => $request->input('draw'),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $data
        ];

        return response()->json($response);
    }

    public function updateFormula(Request $request) {
        // Update the formula in the products table
        $updateData = [
            'formula' => $request->formula,
        ];

        $updated = DB::table('products')
            ->where('id', $request->id)
            ->update($updateData);

        if ($updated) {
            // Fetch the updated product
            $product = DB::table('products')
                ->where('id', $request->id)
                ->select('id', 'formula', 'code')
                ->first();

            if ($product && $product->formula) {
                // Get all branches where this product has entries in product_details
                $branches = DB::table('product_details')
                    ->where('product_id', $product->id)
                    ->pluck('branch_id');


                foreach ($branches as $branchId) {
                    // Get the price of KARKAS for the current branch
                    $carcassPrice = DB::table('product_details')
                        ->join('products', 'product_details.product_id', '=', 'products.id')
                        ->where('products.name', 'KARKAS') // Fix the query
                        ->where('product_details.branch_id', $branchId)
                        ->value('product_details.price');

                    if ($carcassPrice) {
                        try {
                            // Replace 'carcass' with the price, and ensure proper numeric handling
                            $formula = str_replace('carcass', "({$carcassPrice})", $product->formula);
                            
                            // Debug the final formula
                            \Log::debug("Evaluating formula: {$formula}");

                            // Safely evaluate the formula
                            $updatedPrice = eval('return ' . $formula . ';');

                            // Update the price in product_details
                            DB::table('product_details')
                                ->where('product_id', $product->id)
                                ->where('branch_id', $branchId)
                                ->update(['price' => $updatedPrice]);
                        } catch (\Throwable $e) {
                            // Log evaluation errors
                            \Log::error("Error evaluating formula for product ID {$product->id} in branch {$branchId}: {$e->getMessage()}");
                        }
                    } else {
                        // Log if KARKAS price is not found for the branch
                        \Log::warning("KARKAS price not found for branch {$branchId}");
                    }
                }
            } else {
                \Log::warning("Product or formula not found for product ID {$request->id}");
            }
        }

        return response()->json(['success' => (bool) $updated]);
    }


}
