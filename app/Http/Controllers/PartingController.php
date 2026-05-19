<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use Log;

class PartingController extends Controller
{
    public function index() {
        return view('modules.inventory.parting.index');
    }

    public function getLists(Request $request) {

        $params = $request->all();

        $query = DB::table('parting_cut_results')
            ->leftJoin('branches', 'parting_cut_results.branch_id', '=', 'branches.id')
            ->leftJoin('products', 'products.id', '=', 'parting_cut_results.product_id')
            ->select(
                'branches.name as branch_name',
                'parting_cut_results.date',
                DB::raw("TO_CHAR(parting_cut_results.date, 'DD/MM/YYYY') as date_formated"),
                DB::raw('SUM(parting_cut_results.quantity) as total_quantity'),
                DB::raw("SUM(CASE WHEN products.code = 'AA' THEN parting_cut_results.quantity ELSE 0 END) as ati_ampela"),
                DB::raw("SUM(CASE WHEN products.code = 'US' THEN parting_cut_results.quantity ELSE 0 END) as usus"),
            )
            ->where('parting_cut_results.branch_id', Auth::user()->branch_id)
            ->groupBy(
                'parting_cut_results.date',
                'branches.name'
            );

        if (!empty($params['date'])) {
            $query->where(DB::raw('DATE(parting_cut_results.date)'), $params['date']);
        }

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

    public function create() {
        $branch = DB::table('branches')->where('id', Auth::user()->branch_id)->first();
        $branches = DB::table('branches')->orderBy('name', 'asc')->get();
        $products = DB::table('products')->orderBy('sort_order', 'asc')->get();
        $butcherees = DB::table('butcherees')->orderBy('name', 'asc')->get();

        return view('modules.inventory.parting.create', compact('branches', 'products', 'butcherees', 'branch'));
    }

    public function save(Request $request) {
        // Validate required arrays before processing
        DB::beginTransaction();

        try {
            $products = $request->input('products', []);
            foreach ($products as $item) {
                $partingId = DB::table('parting_cut_results')->insertGetId([
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'date' => $item['date'],
                    'branch_id' => $item['branch_id'],
                ]);

                $stockId = DB::table('stocks')
                    ->where('product_id', $item['product_id'])
                    ->where('branch_id', $item['branch_id'])
                    ->value('id');

                DB::table('stock_logs')->insert([
                    "stock_id"     => $stockId,
                    "in_quantity"  => $item["quantity"],
                    "reference"    => 'Parting #' . $partingId,
                    "date"         => now(),
                    "ref_type"     => 'PARTING',
                    "ref_id"       => $partingId,
                ]);
            }

            DB::commit();
            return response()->json(['message' => 'Success']);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'Failed to create transaction',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    public function edit($id) {

        $products = DB::table('products')->orderBy('sort_order', 'asc')->get();

        $partingRows = DB::table('parting_cut_results')
            ->leftJoin('products', 'products.id', '=', 'parting_cut_results.product_id')
            ->where('parting_cut_results.date', $id)
            ->select(
                'parting_cut_results.id',
                'parting_cut_results.product_id',
                'parting_cut_results.branch_id',
                'parting_cut_results.date',
                'products.name as product_name',
                'parting_cut_results.quantity'
            )
            ->get();

        // Ambil info cabang dari salah satu row
        $branch_id = optional($partingRows->first())->branch_id;
        $branch_name = DB::table('branches')->where('id', $branch_id)->value('name');

        $parting = [
            'date' => $id,
            'branch_id' => $branch_id,
            'branch_name' => $branch_name,
            'items' => $partingRows
        ];

        return view('modules.inventory.parting.edit', compact('parting', 'products'));
    }


    public function update(Request $request) {
        try {
            $id = $request->input('id');
            $product_id = $request->input('product_id');
            $quantity = $request->input('quantity');

            DB::beginTransaction();

            // Get the parting record to find product_id for stock log
            $parting = DB::table('parting_cut_results')->where('id', $id)->first();

            if (!$parting) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }

            // Update the parting cut result
            DB::table('parting_cut_results')
                ->where('id', $id)
                ->update([
                    'product_id' => $product_id,
                    'quantity' => $quantity
                ]);

            // Update related stock log if quantity changed
            DB::table('stock_logs')
                ->where('ref_type', 'PARTING')
                ->where('ref_id', $id)
                ->update([
                    'in_quantity' => $quantity
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

    public function delete($id) {
        try {
            DB::beginTransaction();

            // Delete stock logs related to this parting item
            DB::table('stock_logs')
                ->where('ref_type', 'PARTING')
                ->where('ref_id', $id)
                ->delete();

            // Delete the parting cut result
            DB::table('parting_cut_results')
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
