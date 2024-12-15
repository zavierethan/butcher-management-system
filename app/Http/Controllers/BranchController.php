<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class BranchController extends Controller
{
    public function index() {
        return view('modules.master.branch.index');
    }

    public function getLists(Request $request) {
        // $branches = DB::table('branches')
        //     ->select('branches.id', 'branches.code', 'branches.name', 'branches.address')
        //     ->where('branches.is_active', 1)
        //     ->paginate(10);

        // return $branches;

        $params = $request->all();

        $query = DB::table('branches');

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
        return view('modules.master.branch.create');
    }

    public function save(Request $request) {
        $baseUrl = config('app.url');

        //TODO set created_by and updated)_by
        DB::table('branches')->insert([
            "code" => $request->code,
            "name" => $request->name,
            "address" => $request->address,
            "is_active" => $request->is_active,
        ]);

        return redirect()->route('branches.index');
    }

    public function edit($id) {
        $branch = DB::table('branches')->where('id', $id)->first();

        if (!$branch) {
            return redirect()->route('branches.index')->with('error', 'Branch not found.');
        }

        return view('modules.master.branch.edit', compact('branch'));
    }

    public function update(Request $request) {
        // $request->validate([
        //     'code' => 'required|string',
        //     'name' => 'required|string',
        //     'price' => 'required|numeric',
        // ]);
        
        //TODO add validation and updated_by based on user

        DB::table('branches')
            ->where('id', $request->id)
            ->update([
                'code' => $request->code,
                'name' => $request->name,
                'address' => $request->address,
                "is_active" => $request->is_active,
            ]);

        return redirect()->route('branches.index');
    }

}
