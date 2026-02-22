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

        $query = DB::table('fresh_chicken_cut_results')
            ->join('branches', 'fresh_chicken_cut_results.branch_id', '=', 'branches.id')
            ->select(
                DB::raw("TO_CHAR(fresh_chicken_cut_results.date, 'DD/MM/YYYY') as date_formated"),
                'fresh_chicken_cut_results.date',
                'branches.name as branch_name',
                DB::raw('SUM(fresh_chicken_cut_results.total_chickens) as total_chickens'),
                DB::raw('SUM(fresh_chicken_cut_results.weight) as total_weight'),
                DB::raw('SUM(fresh_chicken_cut_results.net_weight) as total_net_weight')
            )
            ->where('fresh_chicken_cut_results.branch_id', Auth()->user()->branch_id)
            ->groupBy('fresh_chicken_cut_results.date', 'branches.name');

        if (!empty($params['start_date']) && !empty($params['end_date'])) {
            $query->whereBetween(DB::raw('DATE(fresh_chicken_cut_results.date)'), [
                $params['start_date'],
                $params['end_date']
            ]);
        }

        // Apply sorting
        if ($request->has('order') && $request->order) {
            $columnIndex = $request->order[0]['column']; // Column index from the DataTable
            $sortDirection = $request->order[0]['dir']; // 'asc' or 'desc'
            $columnName = $request->columns[$columnIndex]['data']; // Column name

            // Map frontend column name to valid SQL column
            $orderMap = [
                'date_formated' => 'fresh_chicken_cut_results.date',
                'date' => 'fresh_chicken_cut_results.date',
                'branch_name' => 'branches.name',
                'total_chickens' => DB::raw('SUM(fresh_chicken_cut_results.total_chickens)'),
                'total_weight' => DB::raw('SUM(fresh_chicken_cut_results.weight)'),
                'total_net_weight' => DB::raw('SUM(fresh_chicken_cut_results.net_weight)'),
            ];
            $orderByCol = isset($orderMap[$columnName]) ? $orderMap[$columnName] : 'fresh_chicken_cut_results.date';
            $query->orderBy($orderByCol, $sortDirection);
        }

        $start = $request->input('start', 0);
        $length = $request->input('length', 10);

        $totalRecords = $query->count();
        $filteredRecords = $query->count();
        $data = $query->skip($start)->take($length)->get();

        return response()->json([
            'draw' => $request->input('draw'),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $data
        ]);
    }

    public function create()
    {
        $branches = DB::table('branches')->get();
        return view('modules.inventory.fresh-chicken-cutting.create', compact('branches'));
    }

    public function save(Request $request)
    {
        $branch_id = Auth()->user()->branch_id;
        $date = $request->input('date');
        $items = $request->input('items', []);

        if(empty($items)) {
            return response()->json(['status' => 'error', 'message' => 'Tidak ada data hasil potong!'], 400);
        }

        $insertData = [];
        foreach($items as $item) {
            $insertData[] = [
                'branch_id' => $branch_id,
                'date' => $date,
                'total_chickens' => $item['total_chicken'] ?? 0,
                'weight' => $item['weight'] ?? 0,
                'container_weight' => $item['container_weight'] ?? 0,
                'net_weight' => $item['net_weight'] ?? 0,
            ];
        }

        DB::table('fresh_chicken_cut_results')->insert($insertData);

        return response()->json(['status' => 'success', 'message' => 'Data berhasil disimpan']);
    }

    public function edit($id)
    {
        $freshChickenCuttingRows = DB::table('fresh_chicken_cut_results')
            ->where('date', $id)
            ->get();

        // Ambil info cabang dari salah satu row
        $branch_id = optional($freshChickenCuttingRows->first())->branch_id;
        $branch_name = DB::table('branches')->where('id', $branch_id)->value('name');

        $freshChickenCutting = [
            'date' => $id,
            'branch_id' => $branch_id,
            'branch_name' => $branch_name,
            'items' => $freshChickenCuttingRows
        ];

        return view('modules.inventory.fresh-chicken-cutting.edit', compact('freshChickenCutting'));
    }

    // Update satu row hasil potong ayam fresh
    public function updateRow(Request $request, $id)
    {
        $data = [
            'total_chickens' => $request->input('total_chicken', 0),
            'weight' => $request->input('weight', 0),
            'container_weight' => $request->input('container_weight', 0),
            'net_weight' => $request->input('net_weight', 0)
        ];
        $updated = DB::table('fresh_chicken_cut_results')->where('id', $id)->update($data);
        if ($updated) {
            return response()->json(['status' => 'success', 'message' => 'Row berhasil diupdate']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Gagal update row'], 400);
        }
    }

    // Delete satu row hasil potong ayam fresh
    public function deleteRow(Request $request, $id)
    {
        $deleted = DB::table('fresh_chicken_cut_results')->where('id', $id)->delete();
        if ($deleted) {
            return response()->json(['status' => 'success', 'message' => 'Row berhasil dihapus']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Gagal hapus row'], 400);
        }
    }
}
