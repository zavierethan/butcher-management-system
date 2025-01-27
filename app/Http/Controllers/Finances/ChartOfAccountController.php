<?php

namespace App\Http\Controllers\Finances;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DB;

class ChartOfAccountController extends Controller
{
    public function index() {
        return view('modules.finances.chart-of-account.index');
    }

    public function getLists(Request $request) {
        $params = $request->all();

        $query = DB::table('chart_of_accounts');

        // Apply global search if provided
        $searchValue = $request->input('search.value'); // This is where DataTables sends the search input
        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('chart_of_accounts.account_code', 'like', '%' . strtoupper($searchValue) . '%');
            });
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
        $data = $query->orderBy('id', 'desc')->skip($start)->take($length)->get();

        return response()->json([
            'draw' => $request->input('draw'),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $data
        ]);
    }

    public function create() {
        return view('modules.finances.chart-of-account.create');
    }

    public function save(Request $request) {

        DB::table('chart_of_accounts')->insert([
            'account_code' => $request->code,
            'account_name' => $request->name,
            'account_type' => $request->type
        ]);

        return redirect()->route('finances.chart-of-accounts.index');
    }

    public function edit($id) {
        $data = DB::table('chart_of_accounts')->where('id', $id)->first();
        return view('modules.finances.chart-of-account.edit', compact('data'));
    }

    public function update(Request $request) {

        DB::table('chart_of_accounts')->where('id', $request->id)->update([
            'account_code' => $request->code,
            'account_name' => $request->name,
            'account_type' => $request->type
        ]);

        return redirect()->route('finances.chart-of-accounts.index');
    }
}
