<?php

namespace App\Http\Controllers\Finances;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DB;
use Auth;

class AccountReceivableController extends Controller
{
    public function index() {
        $customers = DB::table('customers')->where('is_active', 1)->get();
        return view('modules.finances.account-receivable.index', compact('customers'));
    }

    public function getLists(Request $request){
        $params = $request->all();

        $query = DB::table('receivables')->select(
            "receivables.id",
            "transactions.code as transaction_no",
            "customers.name as customer_name",
            DB::raw("TO_CHAR(receivables.transaction_date, 'DD/MM/YYYY') as date"),
            DB::raw("TO_CHAR(receivables.due_date, 'DD/MM/YYYY') as due_date"),
            DB::raw("TO_CHAR(receivables.total_receivable, 'FM999,999,999') as total_amount"),
            DB::raw("TO_CHAR(receivables.remaining_balance, 'FM999,999,999') as remaining_balance"),
            "receivables.status",
            DB::raw("TO_CHAR(receivables.created_at, 'DD/MM/YYYY HH24:MI:SS') as created_at")
        )
        ->leftJoin('transactions', 'transactions.id', '=', 'receivables.transaction_id')
        ->leftJoin('customers', 'customers.id', '=', 'receivables.customer_id');

        if (!empty($params['start_date']) && !empty($params['end_date'])) {
            $query->whereBetween('receivables.transaction_date', [
                $params['start_date'],
                $params['end_date']
            ]);
        }

        if (!empty($params['customer'])) {
            $query->where('receivables.customer_id', $params['customer']);
        }

        if (!empty($params['status'])) {
            $query->where('receivables.status', $params['status']);
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
        $customers = DB::table('customers')->where('is_active', 1)->get();
        return view('modules.finances.account-receivable.create', compact('customers'));
    }

    public function save(Request $request) {
        $payloads = $request->all();

        try {
            // Start a database transaction
            DB::beginTransaction();

            $journalId = DB::table('receivables')->insertGetId([
                "transaction_id" => $payloads["header"]["transaction_id"],
                "customer_id" => $payloads["header"]["customer"],
                "invoice_date" => $payloads["header"]["date"],
                "due_date" => $payloads["header"]["due_date"],
                "total_amount" => $payloads["header"]["total_amount"],
                "remarks" => $payloads["header"]["remarks"],
                "status" => $payloads["header"]["status"],
                "created_at" => date('Y-m-d'),
            ]);

            // Commit the transaction
            DB::commit();

            // Return success response
            return response()->json([
                'message' => 'AR successfully created',
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
        $receivable = DB::table('receivables')->select(
            "receivables.id",
            "transactions.code as transaction_no",
            "customers.name as customer_name",
            "receivables.transaction_date",
            "receivables.due_date",
            DB::raw("TO_CHAR(receivables.total_receivable, 'FM999,999,999') as total_amount"),
            DB::raw("TO_CHAR(receivables.remaining_balance, 'FM999,999,999') as remaining_balance"),
            "receivables.status",
        )
        ->leftJoin('transactions', 'transactions.id', '=', 'receivables.transaction_id')
        ->leftJoin('customers', 'customers.id', '=', 'receivables.customer_id')->where('receivables.id', $id)->first();

        $payments = DB::table('payments')
            ->select(
                'payment_date',
                'reference',
                DB::raw("TO_CHAR(amount_paid, 'FM999,999,999') as amount_paid"),
                'attachment',
            )
            ->where('receivable_id', $receivable->id)->get();

        return view('modules.finances.account-receivable.edit', compact('receivable', 'payments'));
    }

    public function savePayments(Request $request) {
        try {
            // Start a database transaction
            DB::beginTransaction();

            $base64File = null;

            if ($request->hasFile('attachment')) {
                $file = $request->file('attachment');
                $fileContents = file_get_contents($file->getRealPath());
                $base64File = base64_encode($fileContents);
            }

            DB::table('payments')->insert([
                "receivable_id" => $request->receivable_id,
                "payment_date" => $request->date,
                "reference" => $request->reference,
                "amount_paid" => $request->amount_paid,
                "attachment" => $base64File
            ]);

            $receivable = DB::table('receivables')
                ->where('id', $request->receivable_id)
                ->first();

            if ($receivable) {
                // Calculate the new remaining balance
                $newRemainingBalance = $receivable->remaining_balance - $request->amount_paid;

                $status = "partial";

                if($newRemainingBalance <= 0) {
                    $status = "paid";

                    DB::table('transactions')->where('id', $receivable->transaction_id)->update(['status' => 1]);
                }

                // Update the remaining balance and status
                DB::table('receivables')
                    ->where('id', $request->receivable_id)
                    ->update([
                        "remaining_balance" => $newRemainingBalance,
                        "status" => $status
                    ]);
            }

            // Commit the transaction
            DB::commit();

            // Return success response
            return response()->json([
                'message' => 'Data Successfully created',
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
}
