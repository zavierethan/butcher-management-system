<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

class FreshChickenCuttingController extends Controller
{
    public function index()
    {
        return view('modules.inventory.fresh-chicken-cutting.index');
    }

    public function getLists(Request $request){
        $params = $request->all();

        $query = DB::table('live_chicken_receipts')
            ->leftJoin(
                'fresh_chicken_cut_results',
                'live_chicken_receipts.id',
                '=',
                'fresh_chicken_cut_results.live_chicken_receipt_id'
            )
            ->leftJoin(
                'branches',
                'live_chicken_receipts.branch_id',
                '=',
                'branches.id'
            )
            ->select(
                'live_chicken_receipts.id',
                'live_chicken_receipts.date',
                'live_chicken_receipts.total_live_chicken',
                'live_chicken_receipts.total_weight as receipt_total_weight',
                'branches.name as branch_name',

                DB::raw("
                    TO_CHAR(
                        live_chicken_receipts.date,
                        'DD/MM/YYYY'
                    ) as date_formated
                "),

                DB::raw("
                    COALESCE(
                        SUM(fresh_chicken_cut_results.total_chickens),
                        0
                    ) as total_chickens
                "),

                DB::raw("
                    COALESCE(
                        SUM(fresh_chicken_cut_results.weight),
                        0
                    ) as cut_total_weight
                "),

                DB::raw("
                    COALESCE(
                        SUM(fresh_chicken_cut_results.net_weight),
                        0
                    ) as total_net_weight
                ")
            )
            ->where(
                'live_chicken_receipts.branch_id',
                Auth::user()->branch_id
            )
            ->groupBy(
                'live_chicken_receipts.id',
                'live_chicken_receipts.date',
                'live_chicken_receipts.total_live_chicken',
                'live_chicken_receipts.total_weight',
                'branches.name'
            );

        if (!empty($params['date'])) {
            $query->where(DB::raw('DATE(live_chicken_receipts.date)'), $params['date']);
        }

        $start = $request->input('start', 0);
        $length = $request->input('length', 10);

        // Count total and filtered records
        $totalRecords = $query->count();
        $filteredRecords = $query->count();

        $data = $query->orderBy('live_chicken_receipts.date', 'desc')->skip($start)->take($length)->get();

        return response()->json([
            'draw' => $request->input('draw'),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $data
        ]);
    }

    public function create()
    {
        $branch = DB::table('branches')->where('id', Auth::user()->branch_id)->first();
        return view('modules.inventory.fresh-chicken-cutting.create', compact('branch'));
    }

    public function save(Request $request) {
        $branchId = $request->input('branch_id');
        $date = $request->input('date');
        $totalLiveChicken = $request->input('total_live_chicken');
        $totalWeight = $request->input('total_weight');
        $items = $request->input('items', []);

        if (empty($items)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Tidak ada data hasil potong!'
            ], 400);
        }

        DB::beginTransaction();

        try {

            /**
             * Cari header berdasarkan branch + date
             */
            $receipt = DB::table('live_chicken_receipts')
                ->where('branch_id', $branchId)
                ->where('date', $date)
                ->first();

            if ($receipt) {

                $receiptId = $receipt->id;

                /**
                 * Optional:
                 * Update data header jika sudah ada
                 */
                DB::table('live_chicken_receipts')
                    ->where('id', $receiptId)
                    ->update([
                        'total_live_chicken' => $totalLiveChicken,
                        'total_weight' => $totalWeight,
                        'updated_at' => now()
                    ]);

            } else {

                $receiptId = DB::table('live_chicken_receipts')
                    ->insertGetId([
                        'branch_id' => $branchId,
                        'date' => $date,
                        'total_live_chicken' => $totalLiveChicken,
                        'total_weight' => $totalWeight,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
            }

            $insertData = [];

            foreach ($items as $item) {

                $insertData[] = [
                    'live_chicken_receipt_id' => $receiptId,
                    'branch_id' => $branchId,
                    'date' => $date,
                    'total_chickens' => $item['total_chicken'] ?? 0,
                    'weight' => $item['weight'] ?? 0,
                    'container_weight' => $item['container_weight'] ?? 0,
                    'net_weight' => $item['net_weight'] ?? 0,
                ];
            }

            DB::table('fresh_chicken_cut_results')
                ->insert($insertData);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil disimpan'
            ]);

        } catch (\Throwable $e) {

            DB::rollBack();

            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function edit($id)
    {
        // Get header dari live_chicken_receipts berdasarkan id
        $receipt = DB::table('live_chicken_receipts')
            ->leftJoin('branches', 'live_chicken_receipts.branch_id', '=', 'branches.id')
            ->where('live_chicken_receipts.id', $id)
            ->select(
                'live_chicken_receipts.id',
                'live_chicken_receipts.date',
                'live_chicken_receipts.branch_id',
                'live_chicken_receipts.total_live_chicken',
                'live_chicken_receipts.total_weight',
                'branches.name as branch_name'
            )
            ->first();

        if (!$receipt) {
            return abort(404, 'Data tidak ditemukan');
        }

        // Get items dari fresh_chicken_cut_results
        $freshChickenCuttingRows = DB::table('fresh_chicken_cut_results')
            ->where('live_chicken_receipt_id', $id)
            ->get();

        $freshChickenCutting = [
            'id' => $receipt->id,
            'date' => $receipt->date,
            'branch_id' => $receipt->branch_id,
            'branch_name' => $receipt->branch_name,
            'total_live_chicken' => $receipt->total_live_chicken,
            'total_weight' => $receipt->total_weight,
            'items' => $freshChickenCuttingRows
        ];

        return view('modules.inventory.fresh-chicken-cutting.edit', compact('freshChickenCutting'));
    }

    public function update(Request $request)
    {
        try {
            $id = $request->input('id');
            $isHeader = $request->input('is_header', 0);

            DB::beginTransaction();

            // Update header (live_chicken_receipts)
            if ($isHeader) {
                $totalLiveChicken = $request->input('total_live_chicken');
                $totalWeight = $request->input('total_weight');

                if (!$totalLiveChicken || !$totalWeight) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Data header tidak lengkap'
                    ], 400);
                }

                // Check if header exists
                $existing = DB::table('live_chicken_receipts')->where('id', $id)->first();
                if (!$existing) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Data header tidak ditemukan'
                    ], 404);
                }

                // Update the header
                DB::table('live_chicken_receipts')
                    ->where('id', $id)
                    ->update([
                        'total_live_chicken' => $totalLiveChicken,
                        'total_weight' => $totalWeight,
                        'updated_at' => now()
                    ]);

                DB::commit();

                return response()->json([
                    'success' => true,
                    'message' => 'Header berhasil diperbarui'
                ]);
            }

            // Update item (fresh_chicken_cut_results)
            $total_chicken = $request->input('total_chicken');
            $weight = $request->input('weight');
            $container_weight = $request->input('container_weight');
            $net_weight = $request->input('net_weight');

            // Validate required fields
            if (!$id || !$total_chicken || !$weight) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data tidak lengkap'
                ], 400);
            }

            // Check if record exists
            $existing = DB::table('fresh_chicken_cut_results')->where('id', $id)->first();
            if (!$existing) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }

            // Update the record
            DB::table('fresh_chicken_cut_results')
                ->where('id', $id)
                ->update([
                    'total_chickens' => $total_chicken,
                    'weight' => $weight,
                    'container_weight' => $container_weight,
                    'net_weight' => $net_weight
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
            $existing = DB::table('fresh_chicken_cut_results')->where('id', $id)->first();
            if (!$existing) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }

            // Delete the record
            DB::table('fresh_chicken_cut_results')
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
