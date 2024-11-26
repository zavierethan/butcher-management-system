<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class GroupController extends Controller
{

    public function index() {
        return view('modules.settings.accounts.group.index');
    }

    public function getLists(Request $request){

        $params = $request->all();

        $query = DB::table('groups');

        // Pagination
        $start = $request->input('start', 0);
        $length = $request->input('length', 10);

        $totalRecords = $query->count(); // Total records before pagination
        $filteredRecords = $query->count(); // Total records after filtering
        $data = $query->skip($start)->take($length)->get();

        // Format the response
        return response()->json([
            'draw' => $request->input('draw'), // Draw counter
            'recordsTotal' => $totalRecords, // Total records
            'recordsFiltered' => $filteredRecords, // Records after filtering
            'data' => $data // Actual data for the current page
        ]);
    }
}
