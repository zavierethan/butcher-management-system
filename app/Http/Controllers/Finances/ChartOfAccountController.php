<?php

namespace App\Http\Controllers\Finances;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DB;

class ChartOfAccountController extends Controller
{
    public function index() {
        $types = DB::table('account_types')->get();
        $categories = DB::table('account_categories')->get();
        return view('modules.finances.chart-of-account.index', compact('types', 'categories'));
    }

    public function getLists(Request $request) {
        $params = $request->all();

        $query = DB::table('accounts')
            ->select(
                'accounts.id',
                'accounts.account_code',
                'accounts.name as account_name',
                'account_types.name as account_types',
                'account_categories.name as account_categories'
            )
            ->leftJoin('account_types', 'account_types.id', '=', 'accounts.type_id')
            ->leftJoin('account_categories', 'account_categories.id', '=', 'account_types.category_id');

        // Apply global search if provided
        $searchValue = $request->input('search.value'); // This is where DataTables sends the search input
        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('accounts.account_code', 'like', '%' . strtoupper($searchValue) . '%');
            });
        }

        if (!empty($params['type'])) {
            $query->where('account_types.id', $params['type']);
        }

        if (!empty($params['category'])) {
            $query->where('account_categories.id', $params['category']);
        }

        // Apply sorting
        if ($request->has('order') && $request->order) {
            $columnIndex = $request->order[0]['column']; // Column index from the DataTable
            $sortDirection = $request->order[0]['dir']; // 'asc' or 'desc'
            $columnName = $request->columns[$columnIndex]['data']; // Column name

            $query->orderBy($columnName, $sortDirection);
        }

        $start = $request->input('start', 0);
        $length = $request->input('length', 10);

        $totalRecords = $query->count();
        $filteredRecords = $query->count();
        $data = $query->orderBy('accounts.account_code')->skip($start)->take($length)->get();

        return response()->json([
            'draw' => $request->input('draw'),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $data
        ]);
    }

    public function create() {
        $types = DB::table('account_types')->get();
        $categories = DB::table('account_categories')->get();
        return view('modules.finances.chart-of-account.create', compact('types', 'categories'));
    }

    public function save(Request $request) {

        DB::table('accounts')->insert([
            'account_code' => $request->code,
            'name' => $request->name,
            'type_id' => $request->type
        ]);

        return redirect()->route('finances.chart-of-accounts.index');
    }

    public function edit($id) {
        $data = DB::table('accounts')->where('id', $id)->first();
        $types = DB::table('account_types')->get();
        return view('modules.finances.chart-of-account.edit', compact('data', 'types'));
    }

    public function update(Request $request) {

        DB::table('accounts')->where('id', $request->id)->update([
            'account_code' => $request->code,
            'name' => $request->name,
            'type_id' => $request->type
        ]);

        return redirect()->route('finances.chart-of-accounts.index');
    }
}
