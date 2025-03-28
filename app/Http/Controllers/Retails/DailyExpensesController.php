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
        $debitAccounts = DB::table('accounts')
            ->select(
                'accounts.id',
                'accounts.account_code',
                'accounts.name as account_name',
            )
            ->leftJoin('account_types', 'account_types.id', '=', 'accounts.type_id')
            ->where('account_types.category_id', 5)->whereIn('account_types.id', [9, 10, 11])->get();

        $creditAccounts = DB::table('accounts')
            ->select(
                'accounts.id',
                'accounts.account_code',
                'accounts.name as account_name',
            )
            ->leftJoin('account_types', 'account_types.id', '=', 'accounts.type_id')
            ->where('account_types.category_id', 1)->where('account_types.id', 1)->get();

        return view('modules.retails.daily-expenses.create', compact('debitAccounts', 'creditAccounts'));
    }

    public function save(Request $request) {

        $base64File = null;

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $fileContents = file_get_contents($file->getRealPath());
            $base64File = base64_encode($fileContents);
        }

        DB::table('daily_expenses')->insert([
            'date' => $request->date,
            'description' => $request->description,
            'reference' => $request->reference,
            'payment_method' => $request->payment_method,
            'amount' => $request->total_amount,
            'branch_id' => Auth::user()->branch_id,
            'attachment' => $base64File,
            'debit' => $request->debit,
            'credit' => $request->credit,
            'created_by' => Auth::user()->id
        ]);

        // DB::statement("CALL create_journal_proc(?, ?, ?, ?)", [
        //     'sales_transfer', $transactionCode, 'Penjualan dengan pembayaran Transfer', $payloads["header"]["total_amount"]
        // ]);

        $journalId = DB::table('journals')->insertGetId([
            "code" => DB::select('SELECT generate_journal_number() AS journal_number')[0]->journal_number,
            "date" => $request->date,
            "description" => $request->description,
            "reference" => $request->reference,
            "reference_type" => "expenses",
            "status" => "DRAFT",
            "created_by" => Auth::user()->id,
        ]);

        DB::table('journal_entries')->insert([
            "journal_id" => $journalId,
            "account_id" =>  $request->credit,
            "debit" => 0,
            "credit" => $request->total_amount
        ]);

        DB::table('journal_entries')->insert([
            "journal_id" => $journalId,
            "account_id" =>  $request->debit,
            "debit" => $request->total_amount,
            "credit" => 0
        ]);

        return redirect()->route('retails.daily-expenses.index');
    }

    public function edit($id) {
        $data = DB::table('daily_expenses')->where('id', $id)->first();
        $debitAccounts = DB::table('accounts')
            ->select(
                'accounts.id',
                'accounts.account_code',
                'accounts.name as account_name',
            )
            ->leftJoin('account_types', 'account_types.id', '=', 'accounts.type_id')
            ->where('account_types.category_id', 5)->whereIn('account_types.id',[9, 10, 11])->get();

        $creditAccounts = DB::table('accounts')
            ->select(
                'accounts.id',
                'accounts.account_code',
                'accounts.name as account_name',
            )
            ->leftJoin('account_types', 'account_types.id', '=', 'accounts.type_id')
            ->where('account_types.category_id', 1)->where('account_types.id', 1)->get();
        return view('modules.retails.daily-expenses.edit', compact('data','debitAccounts', 'creditAccounts'));
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
