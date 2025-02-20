<?php

namespace App\Http\Controllers\Finances;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DB;

class AccountPayableController extends Controller
{
    public function index() {
        $suppliers = DB::table('suppliers')->where('is_active', 1)->get();
        return view('modules.finances.account-payable.index', compact('suppliers'));
    }

    public function getLists(Request $request){
        $params = $request->all();

        $query = DB::table('payables')->select(
            "payables.id",
            "payables.purchase_order_no",
            "suppliers.name as supplier_name",
            DB::raw("TO_CHAR(payables.purchase_order_date, 'DD/MM/YYYY') as date"),
            DB::raw("TO_CHAR(payables.due_date, 'DD/MM/YYYY') as due_date"),
            DB::raw("TO_CHAR(payables.total_payable, 'FM999,999,999') as total_amount"),
            DB::raw("TO_CHAR(payables.remaining_balance, 'FM999,999,999') as remaining_balance"),
            "payables.status",
            DB::raw("TO_CHAR(payables.created_at, 'DD/MM/YYYY HH24:MI:SS') as created_at")
        )
        ->leftJoin('purchase_orders', 'purchase_orders.id', '=', 'payables.purchase_order_id')
        ->leftJoin('suppliers', 'suppliers.id', '=', 'payables.supplier_id');

        if (!empty($params['start_date']) && !empty($params['end_date'])) {
            $query->whereBetween('payables.purchase_order_date', [
                $params['start_date'],
                $params['end_date']
            ]);
        }

        if (!empty($params['suppliers'])) {
            $query->where('payables.supplier_id', $params['customer']);
        }

        if (!empty($params['status'])) {
            $query->where('payables.status', $params['status']);
        }

        // Apply global search if provided
        $searchValue = $request->input('search.value'); // This is where DataTables sends the search input
        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('purchase_orders.purchase_order_number', 'like', '%' . strtoupper($searchValue) . '%');
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

    public function edit($id) {
        $payable = DB::table('payables')->select(
            "payables.id",
            "payables.purchase_order_no",
            "suppliers.name as supplier_name",
            "payables.purchase_order_date",
            "payables.due_date",
            DB::raw("TO_CHAR(payables.total_payable, 'FM999,999,999') as total_amount"),
            DB::raw("TO_CHAR(payables.remaining_balance, 'FM999,999,999') as remaining_balance"),
            "payables.status",
        )
        ->leftJoin('purchase_orders', 'purchase_orders.id', '=', 'payables.purchase_order_id')
        ->leftJoin('suppliers', 'suppliers.id', '=', 'payables.supplier_id')->where('payables.id', $id)->first();

        $payments = DB::table('payable_payments')
            ->select(
                'payment_date',
                'reference',
                DB::raw("TO_CHAR(amount_paid, 'FM999,999,999') as amount_paid"),
                'attachment',
            )
            ->where('payable_id', $payable->id)->get();

        return view('modules.finances.account-payable.edit', compact('payable', 'payments'));
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

            DB::table('payable_payments')->insert([
                "payable_id" => $request->payable_id,
                "payment_date" => $request->date,
                "reference" => $request->reference,
                "amount_paid" => $request->amount_paid,
                "attachment" => $base64File
            ]);

            // DB::statement("CALL create_journal_proc(?, ?, ?, ?)", [
            //     'payment_receivable', $request->reference, 'Pembayaran hutang usaha', $request->amount_paid
            // ]);

            $payable = DB::table('payables')
                ->where('id', $request->payable_id)
                ->first();

            if ($payable) {
                // Calculate the new remaining balance
                $newRemainingBalance = $payable->remaining_balance - $request->amount_paid;

                $status = "partial";

                if($newRemainingBalance <= 0) {
                    $status = "paid";

                    DB::table('purchase_orders')->where('id', $payable->purchase_order_id)->update(['status' => 1]);
                }

                // Update the remaining balance and status
                DB::table('payables')
                    ->where('id', $request->payable_id)
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
