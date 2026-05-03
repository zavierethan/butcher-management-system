<?php

namespace App\Http\Controllers\Finances;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

use DB;
use PDF;

class InvoiceController extends Controller
{
    public function index() {
        $customers = DB::table('customers')->where('is_active', 1)->get();
        return view('modules.finances.invoices.index', compact('customers'));
    }

    public function getLists(Request $request) {
        $params = $request->all();

        $query = DB::table('invoices')->select(
            "invoices.id",
            "invoices.invoice_no",
            "customers.name as customer_name",
            DB::raw("TO_CHAR(invoices.invoice_date, 'DD/MM/YYYY') as invoice_date"),
            DB::raw("TO_CHAR(invoices.start_periode, 'DD/MM/YYYY') as start_periode"),
            DB::raw("TO_CHAR(invoices.due_date, 'DD/MM/YYYY') as due_date"),
            DB::raw("TO_CHAR(invoices.end_periode, 'DD/MM/YYYY') as end_periode"),
            DB::raw("TO_CHAR(invoices.total_billed, 'FM999,999,999') as total_billed"),
            DB::raw("TO_CHAR(invoices.remaining_billed, 'FM999,999,999') as remaining_billed"),
            "invoices.status",
            DB::raw("TO_CHAR(invoices.created_at, 'DD/MM/YYYY HH24:MI:SS') as created_at")
        )
        ->leftJoin('customers', 'customers.id', '=', 'invoices.customer_id');

        if (!empty($params['start_date']) && !empty($params['end_date'])) {
            $query->whereBetween('invoices.invoice_date', [
                $params['start_date'],
                $params['end_date']
            ]);
        }

        if (!empty($params['customer'])) {
            $query->where('invoices.customer_id', $params['customer']);
        }

        if (!empty($params['status'])) {
            $query->where('invoices.status', $params['status']);
        }

        // Apply global search if provided
        $searchValue = $request->input('search.value'); // This is where DataTables sends the search input
        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('invoices.invoice_no', 'like', '%' . strtoupper($searchValue) . '%');
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
        $customers = DB::table('transactions')
            ->select(
                'transactions.customer_id as id',
                'customers.name'
            )
            ->leftJoin('customers', 'customers.id', '=', 'transactions.customer_id')->where('transactions.status', 2)->distinct()->get();

        return view('modules.finances.invoices.create', compact('customers'));
    }

    public function save(Request $request) {
        $payloads = $request->all();

        $details = array_values(array_unique($payloads['details']));

        $customer = DB::table('customer_credit_policies')->where('id', $payloads["header"]["customer"])->first();

        $invoiceDate = Carbon::parse($payloads["header"]["date"]);
        $dueInterval = optional($customer)->due_date_interval;
        $dueDate = $invoiceDate->copy()->addDays(is_numeric($dueInterval) ? intval($dueInterval) : 7);

        try {
            // Start a database transaction
            DB::beginTransaction();

            $invoiceNumber = DB::select('SELECT generate_invoice_number() AS invoice_number')[0]->invoice_number;

            $invoiceId = DB::table('invoices')->insertGetId([
                "customer_id"         => $payloads["header"]["customer"],
                "invoice_no"          => $invoiceNumber,
                "invoice_date"        => $payloads["header"]["date"],
                "total_billed"        => $payloads["header"]["total_billed"],
                "remaining_billed"    => $payloads["header"]["total_billed"],
                "start_periode"       => $payloads["header"]["start_date"],
                "end_periode"         => $payloads["header"]["end_date"],
                "due_date"            => $dueDate->format('Y-m-d'),
                "status"              => "unpaid",
            ]);

            // Save the transaction details
            foreach ($details as $key => $value) {
                // Get transaction amount
                $transaction = DB::table('transactions')->where('id', $value)->first();

                DB::table('invoice_details')->insertGetId([
                    "invoice_id"       => $invoiceId,
                    "transaction_id"   => $value,
                    "amount"           => $transaction->total_amount - $transaction->discount,
                    "remaining_amount" => $transaction->total_amount - $transaction->discount,
                ]);
            }

            // Commit the transaction
            DB::commit();

            // Return success response
            return response()->json([
                'message' => 'Invoice successfully created',
                'invoice_number' =>  $invoiceNumber,
                'invoice_id' =>  $invoiceId,
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

    public function getTransactions(Request $request) {
        $customerId = $request->customer;
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        $query = DB::table('transactions')
            ->select(
                DB::raw("TO_CHAR(transaction_date, 'dd/mm/YYYY') as date"),
                'transactions.id as transaction_id',
                'transactions.code as transaction_no',
                'transactions.total_amount',
            )
            ->where('transactions.customer_id', $customerId)
            ->where('transactions.status', 2)
            ->where('transactions.transaction_date', '>=', $startDate)
            ->where('transactions.transaction_date', '<=', $endDate);

        $data = $query->get();

        return response()->json($data);
    }

    public function getTransactionItems(Request $request) {
        $data = DB::table('transactions')
                    ->select(
                        DB::raw("TO_CHAR(transaction_date, 'dd/mm/YYYY') as date"),
                        'transactions.id as transaction_id',
                        'transactions.code as transaction_no',
                        'transactions.total_amount',
                    )
                    ->whereIn('transactions.id', $request->transaction_ids)
                    ->orderBy('transactions.code', 'ASC')
                    ->get();

        return response()->json($data);
    }

    public function printInvoice($id) {
        $invoice = DB::table('invoices')
            ->select(
                'invoices.id',
                'invoices.invoice_no',
                DB::raw("TO_CHAR(invoices.invoice_date, 'dd/mm/YYYY') as invoice_date"),
                'customers.name as customer_name',
                'customers.phone_number',
                'customers.address',
            )
            ->leftJoin('customers', 'customers.id', '=', 'invoices.customer_id')->where('invoices.id', $id)->first();

        $transactionIds = DB::table('invoice_details')->where('invoice_id',  $invoice->id)->pluck('transaction_id')->toArray();

        $invoiceItems = DB::table('invoice_details')
            ->select(
                DB::raw("TO_CHAR(transactions.transaction_date, 'dd/mm/YYYY') as date"),
                'transactions.code as transaction_no',
                'invoice_details.amount',
                'invoice_details.remaining_amount'
            )
            ->leftJoin('transactions', 'transactions.id', '=', 'invoice_details.transaction_id')
            ->where('invoice_details.invoice_id', $invoice->id)
            ->orderBy('transactions.transaction_date', 'asc')
            ->get();

        $totalSellPrice = DB::table('invoice_details')
            ->where('invoice_id', $invoice->id)
            ->sum('amount');

        $totalFormatted = number_format($totalSellPrice, 0, '.', ',');

        // Convert image to Base64
        $imagePath = public_path('assets/media/logos/priyadis-butcherss.png'); // Update the path as needed
        $base64Image = $this->convertImageToBase64($imagePath);

        $pdf = PDF::loadView('modules.finances.invoices.print', [
            "invoice" => $invoice,
            "invoiceItems" => $invoiceItems,
            "totalSellPrice" => $totalFormatted,
            "base64Image" => $base64Image,
        ]);

        return $pdf->stream('Invoice '.$invoice->customer_name.'.pdf');
    }

    private function convertImageToBase64($path){
        if (!file_exists($path)) {
            return null;
        }

        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        return 'data:image/' . $type . ';base64,' . base64_encode($data);
    }

    public function edit($id) {
        $customers = DB::table('customers')->get();
        $invoice = DB::table('invoices')
            ->select(
                'invoices.*'
            )
            ->leftJoin('customers', 'customers.id', '=', 'invoices.customer_id')->where('invoices.id', $id)->first();

        $invoiceItems = DB::table('invoice_details')
            ->select(
                'invoice_details.id',
                'invoice_details.transaction_id',
                'invoice_details.amount',
                'invoice_details.remaining_amount',
                DB::raw("TO_CHAR(transactions.transaction_date, 'dd/mm/YYYY') as transaction_date"),
                'transactions.code as transaction_no',
                'transactions.total_amount',
            )
            ->leftJoin('transactions', 'transactions.id', '=', 'invoice_details.transaction_id')
            ->where('invoice_details.invoice_id', $id)
            ->orderBy('transactions.transaction_date', 'asc')
            ->get();

        $paymentHistories = DB::table('receivable_payments')
            ->select(
                'receivable_payments.id',
                DB::raw("TO_CHAR(receivable_payments.payment_date, 'DD/MM/YYYY') as date"),
                DB::raw("TO_CHAR(receivable_payments.amount, 'FM999,999,999') as amount"),
                DB::raw("CASE WHEN receivable_payments.payment_method = 1 THEN 'Tunai' ELSE 'Transfer' END as payment_method"),
                'customers.name as customer_name',
                'invoices.invoice_no as invoice_number',
                'branches.name as branch_name'
            )
            ->leftJoin('invoices', 'invoices.id', '=', 'receivable_payments.invoice_id')
            ->leftJoin('customers', 'customers.id', '=', 'invoices.customer_id')
            ->leftJoin('branches', 'branches.id', '=', 'receivable_payments.branch_id')
            ->where('invoices.id', $id)
            ->get();

        return view('modules.finances.invoices.edit', compact('customers','invoice', 'invoiceItems', 'paymentHistories'));
    }
}
