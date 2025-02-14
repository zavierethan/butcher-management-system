<?php

namespace App\Http\Controllers\Finances;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DB;
use Auth;

class JournalController extends Controller
{
    public function index() {
        return view('modules.finances.journal.index');
    }

    public function getLists(Request $request){
        $params = $request->all();

        $query = DB::table('journals')->select(
            "journals.id",
            "journals.code",
            DB::raw("TO_CHAR(journals.date, 'DD/MM/YYYY') as date"),
            "journals.description",
            "journals.reference",
            "journals.status",
            DB::raw("TO_CHAR(journals.created_at, 'DD/MM/YYYY HH24:MI:SS') as created_at")
        );

        if (!empty($params['start_date']) && !empty($params['end_date'])) {
            $query->whereBetween('journals.date', [
                $params['start_date'],
                $params['end_date']
            ]);
        }

        if (!empty($params['status'])) {
            $query->where('journals.status', $params['status']);
        }

        // Apply global search if provided
        $searchValue = $request->input('search.value'); // This is where DataTables sends the search input
        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('transactions.code', 'like', '%' . strtoupper($searchValue) . '%');
            });
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
        $accounts = DB::table('accounts')->get();
        return view('modules.finances.journal.create', compact('accounts'));
    }

    public function save(Request $request) {
        $payloads = $request->all();

        try {
            // Start a database transaction
            DB::beginTransaction();

            $journalNumber = DB::select('SELECT generate_journal_number() AS journal_number')[0]->journal_number;

            $journalId = DB::table('journals')->insertGetId([
                "code" => $journalNumber,
                "date" => $payloads["header"]["date"],
                "description" => $payloads["header"]["description"],
                "reference" => $payloads["header"]["reference"],
                "remarks" => $payloads["header"]["remarks"],
                "status" => "DRAFT",
                "created_by" => Auth::user()->id,
            ]);

            // Save the transaction details
            foreach ($payloads['details'] as $detail) {
                DB::table('journal_entries')->insertGetId([
                    "journal_id" => $journalId,
                    "account_id" =>  $detail["accountId"],
                    "debit" => $detail["debit"],
                    "credit" => $detail["credit"]
                ]);
            }

            // Commit the transaction
            DB::commit();

            // Return success response
            return response()->json([
                'message' => 'Journals successfully created',
            ], 201);

        } catch (\Exception $e) {
            // Rollback transaction in case of error
            DB::rollBack();

            // Return error response
            return response()->json([
                'message' => 'Failed to create transaction',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function edit($id) {
        $accounts = DB::table('accounts')->get();
        $journal = DB::table('journals')->where('id', $id)->first();
        $journaldetails = DB::table('journal_entries')->where('journal_id', $journal->id)->get();
        return view('modules.finances.journal.edit', compact('accounts', 'journal', 'journaldetails'));
    }

    public function update(Request $request) {

    }
}
