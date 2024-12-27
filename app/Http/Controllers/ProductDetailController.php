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
        $rules = [
            'id' => 'required|integer|exists:product_details,id',
            'price' => 'nullable|numeric',
            'discount' => 'nullable|numeric',
            'start_period' => 'nullable|date',
            'end_period' => 'nullable|date',
        ];

        // Validate the request
        $validatedData = $request->validate($rules);

        // Prepare data for update
        $updateData = array_filter($validatedData, function ($key) {
            return in_array($key, ['price', 'discount', 'start_period', 'end_period']);
        }, ARRAY_FILTER_USE_KEY);

        // Perform the update
        $updated = DB::table('product_details')
            ->where('id', $validatedData['id'])
            ->update($updateData);

        // Return JSON response
        return response()->json(['success' => (bool) $updated]);
    }

    public function updateStatus(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|exists:product_details,id',
            'is_active' => 'required|boolean',
        ]);

        // Update the 'is_active' column for the specific product
        $product = DB::table('product_details')
                    ->where('id', $validated['id'])
                    ->update(['is_active' => $validated['is_active']]);

        if ($product) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false], 500);
        }
    }

    // public function updateRow(Request $request)
    // {
    //     $rules = [
    //         'id' => 'required|integer|exists:product_details,id',
    //         'price' => 'nullable|numeric',
    //         'discount' => 'nullable|numeric',
    //         'start_period' => 'nullable|date',
    //         'end_period' => 'nullable|date',
    //     ];

    //     // Validate the request
    //     $validatedData = $request->validate($rules);

    //     // Prepare data for update
    //     $updateData = array_filter($validatedData, function ($key) {
    //         return in_array($key, ['price', 'discount', 'start_period', 'end_period']);
    //     }, ARRAY_FILTER_USE_KEY);

    //     // Perform the update
    //     $updated = DB::table('product_details')
    //         ->where('id', $validatedData['id'])
    //         ->update($updateData);

    //     // Return JSON response
    //     return response()->json(['success' => (bool) $updated]);
    // }


    public function updateAllPrice(Request $request)
    {
        $price = $request->input('price');

        // Check if the price is empty and set it to null if true
        if (empty($price)) {
            $price = null;
        }

        try {
            // Update all rows
            DB::table('product_details')->update(['price' => $price]);

            return response()->json(['success' => true, 'message' => 'All rows updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error updating rows', 'error' => $e->getMessage()]);
        }
    }

    public function updateAllDiscount(Request $request)
    {
        $discount = $request->input('discount');

        // Check if the discount is empty and set it to null if true
        if (empty($discount)) {
            $discount = null;
        }

        try {
            // Update all rows
            DB::table('product_details')->update(['discount' => $discount]);

            return response()->json(['success' => true, 'message' => 'All rows updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error updating rows', 'error' => $e->getMessage()]);
        }
    }

    public function updateAllDiscountDate(Request $request)
    {
        
        if ($request->has('discountStartDate')) {
            $discountStartDate = $request->input('discountStartDate');
            if (empty($discountStartDate)) {
                $discountStartDate = null;
            }

            try {
                // Update all rows
                DB::table('product_details')->update(['start_period' => $discountStartDate]);

                return response()->json(['success' => true, 'message' => 'All rows updated successfully']);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => 'Error updating rows', 'error' => $e->getMessage()]);
            }

        } else if ($request->has('discountEndDate')) {
            $discountEndDate = $request->input('discountEndDate');
            if (empty($discountEndDate)) {
                $discountEndDate = null;
            }

            try {
                // Update all rows
                DB::table('product_details')->update(['end_period' => $discountEndDate]);

                return response()->json(['success' => true, 'message' => 'All rows updated successfully']);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => 'Error updating rows', 'error' => $e->getMessage()]);
            }
        }
    }

}
