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

        $query = DB::table('partings')
        ->leftJoin('branches', 'partings.branch_id', '=', 'branches.id')
        ->leftJoin('parting_cut_results', 'partings.id', '=', 'parting_cut_results.parting_id')
        ->leftJoin('products', 'products.id', '=', 'parting_cut_results.product_id')
        ->select(
            'partings.id',
            'partings.air_susut_parting',
            'partings.air_susut_display',
            'partings.air_susut_usus',
            'partings.air_susut_ati_ampela',
            'branches.name as branch_name',
            DB::raw("TO_CHAR(partings.date, 'DD/MM/YYYY') as date_formated"),
            DB::raw('COALESCE(SUM(parting_cut_results.quantity), 0) as total_quantity'),
            DB::raw("
                COALESCE(
                    SUM(
                        CASE
                            WHEN products.code = 'AA'
                            THEN parting_cut_results.quantity
                            ELSE 0
                        END
                    ),
                0) as ati_ampela
            "),
            DB::raw("
                COALESCE(
                    SUM(
                        CASE
                            WHEN products.code = 'US'
                            THEN parting_cut_results.quantity
                            ELSE 0
                        END
                    ),
                0) as usus
            ")
        )
        ->where('partings.branch_id', Auth::user()->branch_id)
        ->groupBy(
            'partings.id',
            'partings.date',
            'branches.name',
            'partings.air_susut_parting',
            'partings.air_susut_display',
            'partings.air_susut_usus',
            'partings.air_susut_ati_ampela',
        );

        if (!empty($params['date'])) {
            $query->where(DB::raw('DATE(partings.date)'), $params['date']);
        }

        $start = $request->input('start', 0);
        $length = $request->input('length', 10);

        // Count total and filtered records
        $totalRecords = $query->count();
        $filteredRecords = $query->count();

        $data = $query->orderBy('partings.date', 'desc')->skip($start)->take($length)->get();

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

            // Check if parting already exists for this date and branch
            $existingParting = DB::table('partings')
                ->where('date', $request->input('date'))
                ->where('branch_id', $request->input('branch_id'))
                ->first();

            if ($existingParting) {
                $partingId = $existingParting->id;
            } else {
                $partingId = DB::table('partings')->insertGetId([
                    'date' => $request->input('date'),
                    'branch_id' => $request->input('branch_id'),
                    'butcher_id' => $request->input('butcher_id'),
                    'air_susut_parting' => $request->input('air_susut_parting'),
                    'air_susut_display' => $request->input('air_susut_display'),
                    'air_susut_usus' => $request->input('air_susut_usus'),
                    'air_susut_ati_ampela' => $request->input('air_susut_ati_ampela'),
                ]);
            }

            $products = $request->input('products', []);

            foreach ($products as $item) {
                $partingCutResultId = DB::table('parting_cut_results')->insertGetId([
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'date' => $item['date'],
                    'branch_id' => $item['branch_id'],
                    'parting_id' => $partingId,
                ]);

                $stockId = DB::table('stocks')
                    ->where('product_id', $item['product_id'])
                    ->where('branch_id', $item['branch_id'])
                    ->value('id');

                DB::table('stock_logs')->insert([
                    "stock_id"     => $stockId,
                    "in_quantity"  => $item["quantity"],
                    "reference"    => 'Parting #' . $partingCutResultId,
                    "date"         => now(),
                    "ref_type"     => 'PARTING',
                    "ref_id"       => $partingCutResultId,
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

        $parting = DB::table('partings')
            ->select(
                'partings.*',
                'branches.name as branch_name'
            )
            ->leftJoin('branches', 'partings.branch_id', '=', 'branches.id')
            ->where('partings.id', $id)
            ->first();

        $partingCutResults = DB::table('parting_cut_results')
            ->leftJoin('products', 'products.id', '=', 'parting_cut_results.product_id')
            ->where('parting_cut_results.parting_id', $id)
            ->select(
                'parting_cut_results.id',
                'parting_cut_results.product_id',
                'products.name as product_name',
                'parting_cut_results.quantity'
            )
            ->get();

        return view('modules.inventory.parting.edit', compact('parting', 'partingCutResults', 'products'));
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
