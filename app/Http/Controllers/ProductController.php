<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;

class ProductController extends Controller
{
    public function __construct() {
        date_default_timezone_set("Asia/Jakarta");
    }

    public function index() {
        return view('modules.master.product.index');
    }

    public function getLists(Request $request) {

        $params = $request->all();

        $query = DB::table('products')
            ->leftJoin('product_categories', 'products.category_id', '=', 'product_categories.id')
            ->leftJoin('product_clasifications', 'products.clasification_id', '=', 'product_clasifications.id')
            ->leftJoin('pricing_types', 'products.pricing_type_id', '=', 'pricing_types.id')
            ->select('products.*', 'product_categories.name as category_name', 'product_clasifications.name as clasification', 'pricing_types.name as pricing_type');

        // Apply global search if provided
        if ($request->has('searchTerm') && !empty($request->input('searchTerm'))) {
            $searchValue = strtoupper($request->input('searchTerm'));
            $query->where(function ($q) use ($searchValue) {
                $q->where('products.name', 'ilike', '%' . $searchValue . '%')
                ->orWhere('products.code', 'ilike', '%' . $searchValue . '%');
            });
        }

        $start = $request->input('start', 0);
        $length = $request->input('length', 10);

        // Count total and filtered records
        $totalRecords = DB::table('products')->count(); // Total without filters
        $filteredRecords = $query->count(); // Count after applying filters

        $data = $query->orderBy('sort_order', 'asc')->skip($start)->take($length)->get();

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
                "url_path" => $imagePath,
                "unit" => "KG"
            ]);

            // Retrieve all branches
            $branches = DB::table('branches')->get();

            // Prepare product_details and stock entries
            $productDetails = [];
            $stocks = [];

            foreach ($branches as $branch) {
                $productDetails[] = [
                    'product_id' => $productId,
                    'branch_id' => $branch->id,
                ];

                $stocks[] = [
                    'product_id' => $productId,
                    'branch_id' => $branch->id,
                ];
            }

            // Insert into product_details
            DB::table('product_details')->insert($productDetails);

            // Insert into stocks
            DB::table('stocks')->insert($stocks);
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

    public function getListProducts(Request $request){
        $params = $request->q;
        $branchId = $request->branch_id;

        // Build the query
        $query = DB::table('product_details')
            ->leftJoin('products', 'products.id', '=', 'product_details.product_id')
            ->select(
                'products.id',
                'products.name',
                'products.code',
                'products.url_path',
                'product_details.cogs',
                'product_details.price',
                'product_details.discount',
            )
            ->where('product_details.branch_id', $branchId)
            ->where('product_details.is_active', '=', 1);

        // Apply filtering for name or code
        if (!empty($params)) {
            $query->where(function ($q) use ($params) {
                $q->where('products.name', 'like', '%' . strtoupper($params) . '%')
                ->orWhere('products.code', 'like', '%' . strtoupper($params) . '%');
            });
        }

        // Ensure unique results
        $query->distinct();

        // Count total records (before applying pagination)
        $totalRecords = $query->count();

        // Fetch filtered results
        $data = $query
            ->orderBy('products.name', 'asc')
            ->get();

        // Build response
        $response = [
            'draw' => $request->input('draw'),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords, // Same as total for now
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

    // api untuk parting
    public function getAllProductsInAllBranches(){

        // Build the query
        $query = DB::table('products')
            ->leftJoin('product_categories', 'products.category_id', '=', 'product_categories.id')
            ->select(
                'products.id',
                'products.name',
                'products.code',
                'products.url_path',
                'products.is_active',
                'product_categories.name as category_name',
            )
            ->where('products.is_active', '=', 1);

        // Ensure unique results
        $query->distinct();

        // Fetch filtered results
        $data = $query
            ->orderBy('products.name', 'asc')
            ->get();

        // Build response
        $response = [
            'data' => $data
        ];

        return response()->json($response);
    }
}
