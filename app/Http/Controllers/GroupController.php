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
        return view('modules.accounts.group.edit', compact('group', 'menuHierarchy'));
    }

    public function menuAccess($id) {
        $group = DB::table('groups')->where('id', $id)->first();

        $parent = DB::table('menus')->whereNull('parent_id')->orderBy('order', 'asc')->get();

        $child = DB::table('menus')->whereNotNull('parent_id')->orderBy('order', 'asc')->get();

        $menuAssigned = DB::table('group_menu_access')
                    ->where('group_id', $id)
                    ->pluck('menu_id') // Plucks the 'menu_id' column
                    ->toArray();

        return view('modules.accounts.group.menu-access', compact('group', 'parent', 'child', 'menuAssigned'));
    }

    public function update(Request $request) {
        DB::table('groups')->where('id', $request->group_id)->update([
            "code" => $request->code,
            "name" => $request->name
        ]);

        return redirect()->route('groups.index');
    }

    public function updateMenuAccess(Request $request) {
        $query = DB::table('group_menu_access');

        try {
            if($request['is_checked'] == 1) {
                $query->insert([
                    "group_id" => $request['group_id'],
                    "menu_id" => $request['menu_id']
                ]);

                return response()->json([
                    "message" => "Data Berhasil di Simpan"
                ], 201); // 201 Created
            } else {
                $query->where('group_id', $request['group_id'])->where('menu_id', $request['menu_id'])->delete();

                return response()->json([
                    "message" => "Data Berhasil di Hapus"
                ], 200);
            }

        }catch (\Exception $e) {
            return response()->json([
                "error" => "An error occurred",
                "details" => $e->getMessage()
            ], 500); // 500 Internal Server Error for unexpected errors
        }
    }
}
