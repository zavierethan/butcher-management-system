<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class BranchController extends Controller
{
        public function index() {
        $branches = $this->getList();

        return view('modules.master.branch.index', compact('branches'));
    }

    public function getList() {
        $branches = DB::table('branches')
            ->select('branches.id', 'branches.code', 'branches.name', 'branches.address')
            ->where('branches.is_active', 1)
            ->paginate(10);

        return $branches;
    }

    public function edit($id) {
        $product = DB::table('branches')->where('id', $id)->first();

        if (!$product) {
            return redirect()->route('branches.index')->with('error', 'Branch not found.');
        }

        return view('modules.master.branch.edit', compact('branch'));
    }

    public function update(Request $request, $id) {
        $request->validate([
            'code' => 'required|string',
            'name' => 'required|string',
            'address' => 'required|string',
        ]);

        DB::table('branches')
            ->where('id', $id)
            ->update([
                'code' => $request->code,
                'name' => $request->name,
                'address' => $request->address,
            ]);

        return redirect()->route('branches.index')->with('success', 'Branch updated successfully.');
    }

    public function destroy($id) {
        DB::table('branches')
            ->where('id', $id)
            ->update(['is_active' => 0]);

        return redirect()->route('branches.index')->with('success', 'Branch soft deleted successfully!');
    }

    public function create() {
        return view('modules.master.branch.create');
    }

    //TODO: CREATE AN ALERT FOR INVALID DATA INPUT
    public function store(Request $request) {
        // Validate the data
        $validatedData = $request->validate([
            'code' => 'required|unique:branches,code',
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
        ]);

        // Insert the new product
        DB::table('products')->insert([
            'code' => $validatedData['code'],
            'name' => $validatedData['name'],
            'address' => $validatedData['address'],
            'is_active' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('branches.index')->with('success', 'Branch created successfully!');
    }
}
