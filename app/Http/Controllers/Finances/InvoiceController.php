<?php

namespace App\Http\Controllers\Finances;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DB;
use PDF;

class InvoiceController extends Controller
{
    public function index() {

    }

    public function getLists(Request $request) {

    }

    public function create() {
        $customers = DB::table('receivables')
            ->select(
                'receivables.customer_id as id',
                'customers.name'
            )
            ->leftJoin('customers', 'customers.id', '=', 'receivables.customer_id')->where('status', 'unpaid')->distinct()->get();
        return view('modules.finances.invoices.create', compact('customers'));
    }

    public function save(Request $request) {
        $payloads = $request->all();

        $details = array_values(array_unique($payloads['details']));

        try {
            // Start a database transaction
            DB::beginTransaction();

            $invoiceNumber = DB::select('SELECT generate_invoice_number() AS invoice_number')[0]->invoice_number;

            $invoiceId = DB::table('invoices')->insertGetId([
                "customer_id" => $payloads["header"]["customer"],
                "invoice_no" => $invoiceNumber,
                "invoice_date" => $payloads["header"]["date"],
                "total_billed" => $payloads["header"]["total_billed"],
            ]);

            // Save the transaction details
            foreach ($details as $key => $value) {
                DB::table('invoice_details')->insertGetId([
                    "invoice_id" => $invoiceId,
                    "receivable_id" => $value,
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

    public function getReceivable(Request $request) {
        $customerId = $request->customer;

        $data = DB::table('receivables')
            ->select(
                DB::raw("TO_CHAR(transaction_date, 'dd/mm/YYYY') as date"),
                'transaction_id',
                'transaction_no',
                DB::raw("TO_CHAR(total_receivable, 'FM999,999,999') as total_receivable")
            )
            ->where('customer_id', $customerId)
            ->where('status', 'unpaid')
            ->get();

        return response()->json($data);
    }

    public function getReceivableItems(Request $request) {
        $data = DB::table('transactions')
                    ->select(
                        'transactions.id as transaction_id',
                        DB::raw("TO_CHAR(transactions.transaction_date, 'dd/mm/YYYY') as date"),
                        'transactions.code as transaction_no',
                        'products.name',
                        'transaction_items.quantity',
                        DB::raw("TO_CHAR(transaction_items.base_price, 'FM999,999,999') as base_price"),
                        DB::raw("TO_CHAR(transaction_items.unit_price, 'FM999,999,999') as sell_price"),
                        'transaction_items.discount'
                    )
                    ->leftJoin('transaction_items', 'transaction_items.transaction_id', '=', 'transactions.id')
                    ->leftJoin('products', 'products.id', '=', 'transaction_items.product_id')
                    ->whereIn('transaction_id', $request->transaction_ids)
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

        $receivableIds = DB::table('invoice_details')->where('invoice_id',  $invoice->id)->pluck('receivable_id')->toArray();

        $invoiceItems = DB::table('transactions')
            ->select(
                DB::raw("TO_CHAR(transactions.transaction_date, 'dd/mm/YYYY') as date"),
                'transactions.code as transaction_no',
                'products.name',
                'transaction_items.quantity',
                DB::raw("TO_CHAR(transaction_items.base_price, 'FM999,999,999') as base_price"),
                DB::raw("TO_CHAR(transaction_items.unit_price, 'FM999,999,999') as sell_price"),
                'transaction_items.discount'
            )
            ->leftJoin('transaction_items', 'transaction_items.transaction_id', '=', 'transactions.id')
            ->leftJoin('products', 'products.id', '=', 'transaction_items.product_id')
            ->whereIn('transaction_id', $receivableIds)
            ->orderBy('transactions.code', 'ASC')
            ->get();

        // Convert image to Base64
        $imagePath = public_path('assets/media/logos/priyadis-butcherss.png'); // Update the path as needed
        $base64Image = $this->convertImageToBase64($imagePath);

        $pdf = PDF::loadView('modules.finances.invoices.print', [
            "invoice" => $invoice,
            "invoiceItems" => $invoiceItems,
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
}
