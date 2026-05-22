<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;

class MutasiController extends Controller
{
    public function index()
    {
        return view('modules.inventory.mutasi.index');
    }

    public function getLists(Request $request)
    {
        $params = $request->all();

        $query = DB::table('stock_mutations')
            ->leftJoin('stocks', 'stock_mutations.stock_id', '=', 'stocks.id')
            ->select(
                'stock_mutations.mutation_date',
                DB::raw("TO_CHAR(stock_mutations.mutation_date, 'dd/mm/YYYY') as date"),
                DB::raw("SUM(CASE WHEN stock_mutations.mutation_category = 'MUTASI' THEN stock_mutations.quantity ELSE 0 END) as mutasi"),
                DB::raw("SUM(CASE WHEN stock_mutations.mutation_category = 'PRIVE' THEN stock_mutations.quantity ELSE 0 END) as prive"),
                DB::raw("SUM(CASE WHEN stock_mutations.mutation_category = 'MASUK' THEN stock_mutations.quantity ELSE 0 END) as masuk"),
                DB::raw("SUM(CASE WHEN stock_mutations.mutation_category = 'RETURN' THEN stock_mutations.quantity ELSE 0 END) as return"),
                DB::raw("SUM(CASE WHEN stock_mutations.mutation_category = 'SEDEKAH' THEN stock_mutations.quantity ELSE 0 END) as sedekah"),
                DB::raw("SUM(CASE WHEN stock_mutations.mutation_category = 'BONUS' THEN stock_mutations.quantity ELSE 0 END) as bonus")
            )
            ->where('stocks.branch_id', Auth::user()->branch_id)
            ->groupBy(DB::raw("TO_CHAR(stock_mutations.mutation_date, 'dd/mm/YYYY')"), 'stock_mutations.mutation_date');

        $start = $request->input('start', 0);
        $length = $request->input('length', 10);

        // Count total and filtered records
        $totalRecords = $query->count();
        $filteredRecords = $query->count();

        $data = $query->orderBy('date', 'desc')->skip($start)->take($length)->get();

        $response = [
            'draw' => $request->input('draw'),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $data
        ];

        return response()->json($response);
    }

    public function create()
    {
        $branch = DB::table('branches')->where('id', Auth::user()->branch_id)->first();
        $branches = DB::table('branches')->whereNotIn('id', [$branch->id])->get();
        $stocks = DB::table('stocks')
            ->leftJoin('products', 'stocks.product_id', '=', 'products.id')
            ->leftJoin('branches', 'stocks.branch_id', '=', 'branches.id')
            ->leftJoin('stock_logs as sl', 'stocks.id', '=', 'sl.stock_id')
            ->select(
                'stocks.id as stock_id',
                'products.id as product_id',
                'products.code as product_code',
                'products.name as product_name',
            )
            ->where('stocks.branch_id', Auth::user()->branch_id)
            ->groupBy(
                'stocks.id',
                'products.id',
                'products.code',
                'products.name',
                'products.sort_order'
            )->orderBy('products.sort_order', 'asc')->get();

        return view('modules.inventory.mutasi.create', compact('stocks', 'branch', 'branches'));
    }

    public function save(Request $request)
    {
        $products = $request->input('products');

        foreach ($products as $productData) {
            $mutasiId = DB::table('stock_mutations')
                ->insert([
                    "stock_id" => $productData['stock_id'],
                    "mutation_type" => $productData['type'],
                    "mutation_category" => $productData['category'],
                    "quantity" => $productData['quantity'],
                    "mutation_date" => $productData['date'],
                    "remarks" => $productData['remarks'] ?? null,
                ]);

            if($productData['type'] == 'IN') {
                DB::table('stock_logs')
                    ->insert([
                        "stock_id" => $productData['stock_id'],
                        "in_quantity" => $productData['quantity'],
                        "date" => $productData['date'],
                        "reference" => "Mutasi #" . $mutasiId,
                        "ref_type" => $productData['type'],
                        "ref_id" => $mutasiId,
                    ]);
            } else {
                DB::table('stock_logs')
                    ->insert([
                        "stock_id" => $productData['stock_id'],
                        "out_quantity" => $productData['quantity'],
                        "date" => $productData['date'],
                        "reference" => "Mutasi #" . $mutasiId,
                        "ref_type" => $productData['type'],
                        "ref_id" => $mutasiId,
                    ]);
            }
        }

        return response()->json(["message" => "Products updated successfully"]);
    }

    public function edit($id)
    {
        $mutasi = DB::table('stock_mutations')
            ->leftJoin('stocks', 'stock_mutations.stock_id', '=', 'stocks.id')
            ->select(
                'stock_mutations.id',
                'stock_mutations.stock_id',
                'stock_mutations.mutation_date',
                'stock_mutations.mutation_type',
                'stock_mutations.mutation_category as category',
                'stock_mutations.quantity',
                'stock_mutations.remarks',
                'stocks.branch_id'
            )
            ->where('stocks.branch_id', Auth::user()->branch_id)
            ->where('stock_mutations.mutation_date', $id)
            ->get();

        $branch = DB::table('branches')->where('id', Auth::user()->branch_id)->first();
        $branches = DB::table('branches')->whereNotIn('id', [$branch->id])->get();
        $stocks = DB::table('stocks')
            ->leftJoin('products', 'stocks.product_id', '=', 'products.id')
            ->leftJoin('branches', 'stocks.branch_id', '=', 'branches.id')
            ->leftJoin('stock_logs as sl', 'stocks.id', '=', 'sl.stock_id')
            ->select(
                'stocks.id as stock_id',
                'products.id as product_id',
                'products.code as product_code',
                'products.name as product_name',
            )
            ->where('stocks.branch_id', Auth::user()->branch_id)
            ->groupBy(
                'stocks.id',
                'products.id',
                'products.code',
                'products.name',
                'products.sort_order'
            )->orderBy('products.sort_order', 'asc')->get();

        $branch_id = null;
        $mutation_date = null;
        if (!$mutasi->isEmpty()) {
            $branch_id = $mutasi->first()->branch_id;
            $mutation_date = $mutasi->first()->mutation_date;
        }
        return view('modules.inventory.mutasi.edit', compact('mutasi', 'branch_id', 'mutation_date', 'stocks', 'branches', 'branch'));
    }

    public function update(Request $request, $id)
    {
        try {
            $mutation_id = $request->input('id');
            $stock_id = $request->input('stock_id');
            $type = $request->input('type');
            $category = $request->input('category');
            $quantity = $request->input('quantity');
            $remarks = $request->input('remarks');

            DB::beginTransaction();

            // Check if record exists
            $existing = DB::table('stock_mutations')->where('id', $mutation_id)->first();
            if (!$existing) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }

            // Get stock info for product name
            $stock = DB::table('stocks')
                ->leftJoin('products', 'stocks.product_id', '=', 'products.id')
                ->where('stocks.id', $stock_id)
                ->select('products.name')
                ->first();

            // Update the mutation record
            DB::table('stock_mutations')
                ->where('id', $mutation_id)
                ->update([
                    'stock_id' => $stock_id,
                    'mutation_type' => $type,
                    'mutation_category' => $category,
                    'quantity' => $quantity,
                    'remarks' => $remarks
                ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil diperbarui'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function delete($id)
    {
        try {
            DB::beginTransaction();

            // Check if record exists
            $existing = DB::table('stock_mutations')->where('id', $id)->first();
            if (!$existing) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }

            // Delete the mutation record
            DB::table('stock_mutations')
                ->where('id', $id)
                ->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus data',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
