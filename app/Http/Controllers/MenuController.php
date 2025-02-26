<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use DB;

class MenuController extends Controller
{
    public function index() {
        $parentMenus = DB::table('menus')->whereNull('parent_id')->orderBy('order')->get();
        return view('modules.accounts.menu.index', compact('parentMenus'));
    }

    public function getLists(Request $request) {
        $params = $request->all();

        $query = DB::table('menus as child')
            ->select(
                'child.id',
                'child.name as menu_name',
                'parent.name as parent_name',
                'child.url',
                'child.order',
                'child.is_active'
            )
            ->leftJoin('menus as parent', 'child.parent_id', '=', 'parent.id');

        // Fix: Reference the alias `child.parent_id`
        if (!empty($params['parent_id'])) {
            $query->where('child.parent_id', $params['parent_id']);
        }

        // Apply global search if provided
        $searchValue = $request->input('search.value'); // DataTables search input
        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('child.name', 'like', '%' . $searchValue . '%'); // Fix: Use alias `child.name`
            });
        }

        $start = $request->input('start', 0);
        $length = $request->input('length', 10);

        // Clone the query to get correct record counts before pagination
        $totalRecords = DB::table('menus')->count(); // Total records without filters
        $filteredRecords = $query->count(); // Total records with applied filters

        // Fix: Reference `child.order` instead of `menus.order`
        $data = $query->orderBy('child.parent_id', 'asc')->skip($start)->take($length)->get();

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
            "url" => $request->url,
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
