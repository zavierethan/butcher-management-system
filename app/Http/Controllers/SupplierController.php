<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;

class SupplierController extends Controller
{
    public function index() {
        return view('modules.master.supplier.index');
    }

    public function getLists(Request $request) {

        $params = $request->all();

        $query = DB::table('suppliers');

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
        return view('modules.master.supplier.create');
    }

    public function save(Request $request) {
        $baseUrl = config('app.url');

        $currentUserId = Auth::user()->id;

        //TODO set created_by and updated)_by
        DB::table('suppliers')->insert([
            "name" => $request->name,
            "phone_number" => $request->phone_number,
            "address" => $request->address,
            "is_active" => $request->is_active,
            "created_by" => $currentUserId
        ]);

        return redirect()->route('suppliers.index');
    }

    public function edit($id) {
        $supplier = DB::table('suppliers')->where('id', $id)->first();

        if (!$supplier) {
            return redirect()->route('suppliers.index')->with('error', 'Supplier not found.');
        }

        return view('modules.master.supplier.edit', compact('supplier'));
    }

    public function update(Request $request) {

        $currentUserId = Auth::user()->id;

        DB::table('suppliers')
            ->where('id', $request->id)
            ->update([
                'name' => $request->name,
                'phone_number' => $request->phone_number,
                'address' => $request->address,
                "is_active" => $request->is_active,
                "updated_by" => $currentUserId
            ]);

        return redirect()->route('suppliers.index');
    }
}
