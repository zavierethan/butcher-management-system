<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;

class UserController extends Controller
{
    public function index() {
        return view('modules.settings.accounts.user.index');
    }

    public function getLists(Request $request) {
        $params = $request->all();

        $query = DB::table('users')
                ->select('users.id','users.name as username', 'users.email', 'groups.name as group_name', 'users.created_at')
                ->leftJoin('groups', 'groups.id', '=', 'users.group_id');

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
