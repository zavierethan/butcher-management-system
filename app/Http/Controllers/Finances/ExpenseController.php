<?php

namespace App\Http\Controllers\Finances;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DB;
use Auth;

class ExpenseController extends Controller
{
    public function index() {
        return view('modules.finances.expenses.index');
    }

    public function getLists(Request $request) {
        $params = $request->all();

        $query = DB::table('expenses')
            ->select(
                'expenses.id',
                DB::raw("TO_CHAR(expenses.date, 'DD/MM/YYYY') as date"),
                'expenses.description',
                'expenses.reference',
                DB::raw("TO_CHAR(expenses.amount, 'FM999,999,999') as amount"),
                'expenses.status',
                'expenses.payment_method'
            );

        if (!empty($params['start_date']) && !empty($params['end_date'])) {
            $query->whereBetween('expenses.date', [
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
        $debitAccounts = DB::table('accounts')
            ->select(
                'accounts.id',
                'accounts.account_code',
                'accounts.name as account_name',
            )
            ->leftJoin('account_types', 'account_types.id', '=', 'accounts.type_id')
            ->where('account_types.category_id', 5)->get();

        $creditAccounts = DB::table('accounts')
            ->select(
                'accounts.id',
                'accounts.account_code',
                'accounts.name as account_name',
            )
            ->leftJoin('account_types', 'account_types.id', '=', 'accounts.type_id')
            ->where('account_types.category_id', 1)->get();

        return view('modules.finances.expenses.create', compact('debitAccounts', 'creditAccounts'));
    }

    public function save(Request $request) {

        $base64File = null;

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $fileContents = file_get_contents($file->getRealPath());
            $base64File = base64_encode($fileContents);
        }

        DB::table('expenses')->insert([
            'date' => $request->date,
            'description' => $request->description,
            'reference' => $request->reference,
            'payment_method' => $request->payment_method,
            'amount' => $request->total_amount,
            'attachment' => $base64File,
            'debit' => $request->debit,
            'credit' => $request->credit,
            'created_by' => Auth::user()->id
        ]);

        return redirect()->route('finances.expenses.index');
    }

    public function edit($id) {
        $data = DB::table('expenses')->where('id', $id)->first();
        $debitAccounts = DB::table('accounts')
            ->select(
                'accounts.id',
                'accounts.account_code',
                'accounts.name as account_name',
            )
            ->leftJoin('account_types', 'account_types.id', '=', 'accounts.type_id')
            ->where('account_types.category_id', 5)->get();

        $creditAccounts = DB::table('accounts')
            ->select(
                'accounts.id',
                'accounts.account_code',
                'accounts.name as account_name',
            )
            ->leftJoin('account_types', 'account_types.id', '=', 'accounts.type_id')
            ->where('account_types.category_id', 1)->get();
        return view('modules.finances.expenses.edit', compact('data','debitAccounts', 'creditAccounts'));
    }

    public function update(Request $request) {

        DB::table('expenses')->where('id', $request->id)->update([
            'date' => $request->date,
            'description' => $request->description,
            'reference' => $request->reference,
            'payment_method' => $request->payment_method,
            'amount' => $request->amount
        ]);

        return redirect()->route('retails.daily-expenses.index');
    }
}
