<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class GroupController extends Controller
{

    public function index() {
        return view('modules.accounts.group.index');
    }

    public function getLists(Request $request){
        $params = $request->all();

        $query = DB::table('groups');

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

    public function create() {
        return view('modules.accounts.group.create');
    }

    public function save(Request $request) {
        DB::table('groups')->insert([
            "code" => $request->code,
            "name" => $request->name
        ]);

        return redirect()->route('groups.index');
    }

    public function edit($id) {
        $group = DB::table('groups')->where('id', $id)->first();

        return view('modules.accounts.group.edit', compact('group'));
    }

    public function menuAccess($id) {
        $group = DB::table('groups')->where('id', $id)->first();
        return view('modules.accounts.group.menu-access', compact('group'));
    }

    public function update(Request $request) {
        DB::table('groups')->where('id', $request->id)->update([
            "code" => $request->code,
            "name" => $request->name
        ]);

        return redirect()->route('groups.index');
    }
}
