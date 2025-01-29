<?php

namespace App\Http\Controllers\Retails;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DB;
use Auth;

class DailyExpensesController extends Controller
{
    public function index() {
        return view('modules.retails.daily-expenses.index');
    }

    public function getLists(Request $request) {
        $params = $request->all();

        $query = DB::table('daily_expenses')
            ->select(
                'daily_expenses.id',
                DB::raw("TO_CHAR(daily_expenses.date, 'DD/MM/YYYY') as date"),
                'daily_expenses.description',
                'daily_expenses.reference',
                DB::raw("TO_CHAR(daily_expenses.amount, 'FM999,999,999') as amount"),
                'daily_expenses.status',
                'daily_expenses.payment_method'
            )
            ->where('daily_expenses.branch_id', Auth::user()->branch_id);

        if (!empty($params['start_date']) && !empty($params['end_date'])) {
            $query->whereBetween('daily_expenses.date', [
                $params['start_date'],
                $params['end_date']
            ]);
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
        return view('modules.retails.daily-expenses.create');
    }

    public function save(Request $request) {

        DB::table('daily_expenses')->insert([
            'date' => $request->date,
            'description' => $request->description,
            'reference' => $request->reference,
            'payment_method' => $request->payment_method,
            'amount' => $request->amount,
            'branch_id' => Auth::user()->branch_id,
            'created_by' => Auth::user()->id
        ]);

        return redirect()->route('retails.daily-expenses.index');
    }

    public function edit($id) {
        $data = DB::table('daily_expenses')->where('id', $id)->first();
        return view('modules.retails.daily-expenses.edit', compact('data'));
    }

    public function update(Request $request) {

        DB::table('daily_expenses')->where('id', $request->id)->update([
            'date' => $request->date,
            'description' => $request->description,
            'reference' => $request->reference,
            'payment_method' => $request->payment_method,
            'amount' => $request->amount
        ]);

        return redirect()->route('retails.daily-expenses.index');
    }
}
