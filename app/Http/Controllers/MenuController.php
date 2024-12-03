<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class MenuController extends Controller
{
    public function index() {
        return view('modules.accounts.menu.index');
    }

    public function getLists(Request $request){
        $params = $request->all();

        $query = DB::table('menus');

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
        return view('modules.accounts.menu.create');
    }

    public function save(Request $request) {
        DB::table('menus')->insert([
            "code" => $request->code,
            "name" => $request->name
        ]);

        return redirect()->route('menus.index');
    }

    public function edit($id) {
        $menu = DB::table('menus')->where('id', $id)->first();

        return view('modules.accounts.menu.edit', compact('menu'));
    }

    public function update(Request $request) {
        DB::table('menus')->where('id', $request->id)->update([
            "code" => $request->code,
            "name" => $request->name
        ]);

        return redirect()->route('menus.index');
    }
}
