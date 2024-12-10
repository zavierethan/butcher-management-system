<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
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
        $data = $query->orderBy('id', 'desc')->skip($start)->take($length)->get();

        return response()->json([
            'draw' => $request->input('draw'),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $data
        ]);
    }

    public function create() {

        $routes = Route::getRoutes();

        // Filter routes to only include GET routes (optional)
        $urls = [];
        foreach ($routes as $route) {
            // You can customize the filtering as needed
            if ($route->methods()[0] == 'GET') {
                $urls[] = [
                    'uri' => $route->uri(), // Use URI instead of name
                    'url' => url($route->uri()) // Generate URL using URI
                ];
            }
        }

        $parentIds = DB::table('menus')->get();

        return view('modules.accounts.menu.create', compact('urls', 'parentIds'));
    }

    public function save(Request $request) {
        $baseUrl = config('app.url');

        DB::table('menus')->insert([
            "name" => $request->name,
            "parent_id" => $request->parent_id,
            "url" => $baseUrl.'/'.$request->url,
            "icon" => $request->icon,
            "order" => $request->order,
            "is_active" => $request->is_active,
        ]);

        return redirect()->route('menus.index');
    }

    public function edit($id) {
        $menu = DB::table('menus')->where('id', $id)->first();

        $routes = Route::getRoutes();

        // Filter routes to only include GET routes (optional)
        $urls = [];
        foreach ($routes as $route) {
            // You can customize the filtering as needed
            if ($route->methods()[0] == 'GET') {
                $urls[] = [
                    'uri' => $route->uri(), // Use URI instead of name
                    'url' => url($route->uri()) // Generate URL using URI
                ];
            }
        }

        $parentIds = DB::table('menus')->get();

        return view('modules.accounts.menu.edit', compact('menu', 'urls', 'parentIds'));
    }

    public function update(Request $request) {
        DB::table('menus')->where('id', $request->id)->update([
            "name" => $request->name,
            "parent_id" => $request->parent_id,
            "url" => $request->url,
            "icon" => $request->icon,
            "order" => $request->order,
            "is_active" => $request->is_active,
        ]);

        return redirect()->route('menus.index');
    }
}
