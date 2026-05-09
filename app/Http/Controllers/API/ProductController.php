<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class ProductController extends Controller
{
    public function getListProducts(Request $request)
    {
        try {
            $branchId = $request->query('branch_id');

            if (!$branchId) {
                return response()->json([
                    'status' => false,
                    'message' => 'branch_id is required',
                    'data' => null
                ], 400);
            }

            $products = DB::table('product_details as pd')
                ->join('products as p', 'p.id', '=', 'pd.product_id')
                ->where('pd.branch_id', $branchId)
                ->where('pd.is_active', 1)
                ->whereNotIn('p.code', ["DLV", "RW"])
                ->select(
                    'p.id',
                    'p.name',
                    'p.code',
                    'pd.cogs',
                    'pd.price',
                    'pd.discount'
                )
                ->orderBy('p.sort_order', 'asc')
                ->get();

            return response()->json([
                'status' => true,
                'message' => 'Products retrieved successfully',
                'data' => $products
            ], 200);

        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => 'Failed to retrieve products',
                'error' => $e->getMessage(),
                'data' => null
            ], 500);
        }
    }
}
