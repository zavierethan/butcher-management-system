<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class CustomerController extends Controller
{
    public function index() {
        return view('modules.master.customer.index');
    }

    public function getLists(Request $request) {

        $params = $request->all();

        $query = DB::table('customers');

        $start = $request->input('start', 0);
        $length = $request->input('length', 10);

        $totalRecords = $query->count();
        $filteredRecords = $query->count();
        $data = $query->orderBy('id', 'desc')->skip($start)->take($length)->get();

        $response = [
            'draw' => $request->input('draw'),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $data
        ];

        return response()->json($response);
    }

    public function create() {
        return view('modules.master.customer.create');
    }

    public function save(Request $request) {
        $baseUrl = config('app.url');

        //TODO set created_by and updated)_by
        DB::table('customers')->insert([
            "name" => $request->name,
            "ktp_number" => $request->ktp_number,
            "phone_number" => $request->phone_number,
            "type" => $request->type,
            "address" => $request->address,
            "is_active" => $request->is_active,
        ]);

        return redirect()->route('customers.index');
    }

    public function edit($id) {
        $customer = DB::table('customers')->where('id', $id)->first();

        if (!$customer) {
            return redirect()->route('customers.index')->with('error', 'Customer not found.');
        }

        return view('modules.master.customer.edit', compact('customer'));
    }

    public function update(Request $request) {
        // $request->validate([
        //     'code' => 'required|string',
        //     'name' => 'required|string',
        //     'price' => 'required|numeric',
        // ]);

        //TODO add validation and updated_by based on user

        DB::table('customers')
            ->where('id', $request->id)
            ->update([
                'name' => $request->name,
                'ktp_number' => $request->ktp_number,
                'phone_number' => $request->phone_number,
                'type' => $request->type,
                "address" => $request->address,
                "is_active" => $request->is_active,
            ]);

        return redirect()->route('customers.index');
    }

    public function getListFiltered(Request $request) {
        $params = $request->q;

        $query = DB::table('customers');

        if($params != null) {
            $query->where('name', 'like', $params.'%');
        }

        $data = $query->orderBy('id', 'desc')->get();

        $totalRecords = $query->count();
        $filteredRecords = $query->count();

        $data = $query->orderBy('id', 'desc')->get();

        $response = [
            'draw' => $request->input('draw'),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $data
        ];

        return response()->json($response);
    }

    public function saveNewCustomerFromPOS(Request $request) {

        DB::table('customers')->insert([
            "name" => $request->name,
            "phone_number" => $request->phone_number,
        ]);

        return response()->json([
            'message' => 'customer successfully created'
        ], 201);
    }

}
