<?php

namespace App\Http\Controllers\Retails;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DB;
use Auth;

class ReceivablePaymentController extends Controller
{
    public function index() {
        $customers = DB::table('customers')->get();
        return view('modules.retails.receivable-payments.index', compact('customers'));
    }

    public function getLists(Request $request) {
        $params = $request->all();

        $query = DB::table('receivable_payments')
            ->select(
                'receivable_payments.id',
                DB::raw("TO_CHAR(receivable_payments.payment_date, 'DD/MM/YYYY') as date"),
                DB::raw("TO_CHAR(receivable_payments.amount, 'FM999,999,999') as amount"),
                'receivable_payments.payment_method',
                'customers.name as customer_name',
                'invoices.invoice_no as invoice_number'
            )
            ->leftJoin('invoices', 'invoices.id', '=', 'receivable_payments.invoice_id')
            ->leftJoin('customers', 'customers.id', '=', 'invoices.customer_id')
            ->where('receivable_payments.branch_id', Auth::user()->branch_id);

        if (!empty($params['start_date']) && !empty($params['end_date'])) {
            $query->whereBetween('receivable_payments.payment_date', [
                $params['start_date'],
                $params['end_date']
            ]);
        }

        if (!empty($params['customer'])) {
            $query->where('customers.id', $params['customer']);
        }

        if (!empty($params['invoice_number'])) {
            $query->where('invoices.invoice_no', 'like', '%' . strtoupper($params['invoice_number']) . '%');
        }

        if (!empty($params['payment_method'])) {
            $query->where('receivable_payments.payment_method', $params['payment_method']);
        }

        if ($request->has('order') && $request->order) {
            $columnIndex = $request->order[0]['column'];
            $sortDirection = $request->order[0]['dir'];
            $columnName = $request->columns[$columnIndex]['data'];

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
        $invoices = DB::table('invoices')->where('status', '!=', 'paid')->get();

        return view('modules.retails.receivable-payments.create', compact('invoices'));
    }

    public function save(Request $request)
    {
        DB::transaction(function () use ($request) {
            $paymentAmount = $request->amount;
            $invoiceId = $request->invoice_id;

            // Insert payment record
            $paymentId = DB::table('receivable_payments')->insertGetId([
                'payment_date' => $request->date,
                'payment_code' => "000" . $invoiceId . date('YmdHis'),
                'invoice_id' => $invoiceId,
                'branch_id' => auth()->user()->branch_id,
                'payment_method' => $request->payment_method,
                'amount' => $paymentAmount
            ]);

            // Implement FIFO payment allocation
            $this->allocatePaymentFIFO($invoiceId, $paymentAmount);
        });

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil disimpan'
        ]);
    }

    private function allocatePaymentFIFO($invoiceId, $paymentAmount)
    {
        // Get invoice details ordered by transaction date (FIFO)
        $invoiceDetails = DB::table('invoice_details')
            ->select('invoice_details.*', 'transactions.transaction_date')
            ->leftJoin('transactions', 'transactions.id', '=', 'invoice_details.transaction_id')
            ->where('invoice_details.invoice_id', $invoiceId)
            ->where('invoice_details.remaining_amount', '>', 0)
            ->orderBy('transactions.transaction_date', 'asc')
            ->get();

        $remainingPayment = $paymentAmount;

        foreach ($invoiceDetails as $detail) {
            if ($remainingPayment <= 0) {
                break;
            }

            $payableAmount = min($remainingPayment, $detail->remaining_amount);
            $newRemainingAmount = $detail->remaining_amount - $payableAmount;

            // Update remaining amount in invoice_details
            DB::table('invoice_details')
                ->where('id', $detail->id)
                ->update(['remaining_amount' => $newRemainingAmount]);

            $remainingPayment -= $payableAmount;
        }

        // Update remaining billed in invoice
        $totalRemaining = DB::table('invoice_details')
            ->where('invoice_id', $invoiceId)
            ->sum('remaining_amount');

        // Get total billed amount for status determination
        $totalBilled = DB::table('invoice_details')
            ->where('invoice_id', $invoiceId)
            ->sum('amount');

        DB::table('invoices')
            ->where('id', $invoiceId)
            ->update([
                'remaining_billed' => $totalRemaining
            ]);

        // Update invoice status based on payment status
        if ($totalRemaining <= 0) {
            DB::table('invoices')
                ->where('id', $invoiceId)
                ->update(['status' => 'paid']);
        } elseif ($totalRemaining < $totalBilled) {
            DB::table('invoices')
                ->where('id', $invoiceId)
                ->update(['status' => 'partial']);
        }
    }

    public function edit($id) {
        return view('modules.retails.receivable-payments.edit');
    }

    public function update(Request $request) {

        DB::table('receivable_payments')->where('id', $request->id)->update([
            'payment_date' => $request->date,
            'description' => $request->description,
            'reference' => $request->reference,
            'payment_method' => $request->payment_method,
            'amount' => $request->amount
        ]);

        return redirect()->route('retails.receivable-payments.index');
    }
}
