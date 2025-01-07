<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;

use DB;

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
<<<<<<< HEAD

=======
        
>>>>>>> 89c6eeb774ef1f785e616ad2d19571dc93b4b3d6
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
<<<<<<< HEAD

        DB::table('suppliers')->insert([
            "name" => $request->name,
            "farmer_name" => $request->farmer_name,
            "address" => $request->address,
            "company_name" => $request->company_name,
            "is_active" => $request->is_active,
=======
        $baseUrl = config('app.url');

        $currentUserId = Auth::user()->id;

        //TODO set created_by and updated)_by
        DB::table('suppliers')->insert([
            "name" => $request->name,
            "phone_number" => $request->phone_number,
            "address" => $request->address,
            "is_active" => $request->is_active,
            "created_by" => $currentUserId
>>>>>>> 89c6eeb774ef1f785e616ad2d19571dc93b4b3d6
        ]);

        return redirect()->route('suppliers.index');
    }

    public function edit($id) {
        $supplier = DB::table('suppliers')->where('id', $id)->first();

        if (!$supplier) {
<<<<<<< HEAD
            return redirect()->route('suppliers.index')->with('error', 'supplier not found.');
=======
            return redirect()->route('suppliers.index')->with('error', 'Supplier not found.');
>>>>>>> 89c6eeb774ef1f785e616ad2d19571dc93b4b3d6
        }

        return view('modules.master.supplier.edit', compact('supplier'));
    }

    public function update(Request $request) {

<<<<<<< HEAD
        DB::table('suppliers')
            ->where('id', $request->id)
            ->update([
                "name" => $request->name,
                "farmer_name" => $request->farmer_name,
                "address" => $request->address,
                "company_name" => $request->company_name,
                "is_active" => $request->is_active,
=======
        $currentUserId = Auth::user()->id;

        DB::table('suppliers')
            ->where('id', $request->id)
            ->update([
                'name' => $request->name,
                'phone_number' => $request->phone_number,
                'address' => $request->address,
                "is_active" => $request->is_active,
                "updated_by" => $currentUserId
>>>>>>> 89c6eeb774ef1f785e616ad2d19571dc93b4b3d6
            ]);

        return redirect()->route('suppliers.index');
    }
}
