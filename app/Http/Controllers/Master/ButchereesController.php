<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DB;

class ButchereesController extends Controller
{
    public function index() {
        return view('modules.master.butcherees.index');
    }

    public function getLists(Request $request) {

        $params = $request->all();

        $query = DB::table('butcherees')
            ->select('butcherees.id','butcherees.name', 'branches.name as branch_name')
            ->join('branches', 'branches.id', '=', 'butcherees.branch_id');

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
        $branches = DB::table('branches')->get();
        return view('modules.master.butcherees.create', compact('branches'));
    }

    public function save(Request $request) {
        DB::table('butcherees')->insert([
            "name" => $request->name,
            "branch_id" => $request->branch_id
        ]);

        return redirect()->route('butcherees.index');
    }

    public function edit($id) {
        $butcherees = DB::table('butcherees')->where('id', $id)->first();
        $branches = DB::table('branches')->get();
        return view('modules.master.butcherees.edit', compact('butcherees', 'branches'));
    }

    public function update(Request $request) {

        DB::table('butcherees')
            ->where('id', $request->id)
            ->update([
                "name" => $request->name,
                "branch_id" => $request->branch_id
            ]);

        return redirect()->route('butcherees.index');
    }
}
