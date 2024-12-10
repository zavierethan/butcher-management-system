<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Hash;
use Auth;

class UserController extends Controller
{
    public function index() {
        return view('modules.accounts.user.index');
    }

    public function getLists(Request $request) {
        $params = $request->all();

        // Base query
        $query = DB::table('users')
            ->select('users.id', 'users.name as username', 'users.email', 'groups.name as group_name', 'users.is_active', 'users.created_at')
            ->leftJoin('groups', 'groups.id', '=', 'users.group_id');

        // Apply global search if provided
        $searchValue = $request->input('search.value'); // This is where DataTables sends the search input
        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('users.name', 'like', '%' . $searchValue . '%')
                ->orWhere('users.email', 'like', '%' . $searchValue . '%')
                ->orWhere('groups.name', 'like', '%' . $searchValue . '%');
            });
        }

        // Get total and filtered records count
        $totalRecords = DB::table('users')->count(); // Total records without filtering
        $filteredRecords = $query->count(); // Total records after filtering

        // Pagination and sorting
        $start = $request->input('start', 0);
        $length = $request->input('length', 10);
        $orderColumnIndex = $request->input('order.0.column', 0);
        $orderColumn = $request->input("columns.$orderColumnIndex.data", 'id'); // Column name
        $orderDirection = $request->input('order.0.dir', 'desc'); // asc or desc

        $data = $query->orderBy($orderColumn, $orderDirection)
                    ->skip($start)
                    ->take($length)
                    ->get();

        // Return response
        return response()->json([
            'draw' => $request->input('draw'),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $data,
        ]);
    }


    public function create() {
        $groups = DB::table('groups')->get();
        return view('modules.accounts.user.create', compact('groups'));
    }

    public function save(Request $request) {

        DB::table('users')->insert([
            "name" => $request->username,
            "email" => $request->email,
            "password" => Hash::make("123456"),
            "group_id" => $request->group_id,
            "is_active" => $request->is_active,
            "created_at" => date('Y-m-d h:i:s'),
        ]);

        return redirect()->route('users.index');
    }

    public function edit($id) {
        $user = DB::table('users')->where('id', $id)->first();
        $groups = DB::table('groups')->get();
        return view('modules.accounts.user.edit', compact('user', 'groups'));
    }

    public function update(Request $request) {

        DB::table('users')->where('id', $request->id)->update([
            "name" => $request->username,
            "email" => $request->email,
            "group_id" => $request->group_id,
            "is_active" => $request->is_active,
        ]);

        return redirect()->route('users.index');
    }

    public function changePassword() {
        return view('modules.accounts.user.change-password');
    }

    public function updatePassword(Request $request) {
        // Check if the current password is correct
        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return back()->withErrors(['current_password' => 'The current password is incorrect.']);
        }

        // Update the password
        Auth::user()->update([
            'password' => Hash::make($request->new_password),
        ]);

        Auth::logout();
        return redirect('/login');
    }
}
