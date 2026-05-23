<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\JournalService;
use DB;
use Auth;
use Carbon\Carbon;

class TransactionController extends Controller
{
    public function index() {
        $productCategories = DB::table('product_categories')->where('is_active', 1)->get();
        $branches = DB::table('branches')->where('is_active', 1)->get();
        $settings = DB::table('branch_settings')->where('branch_id', Auth::user()->branch_id)->first();
        $butcherees = DB::table('butcherees')->where('branch_id', Auth::user()->branch_id)->get();

        return view('modules.transactions.pos.index', compact('productCategories', 'branches', 'butcherees', 'settings'));
    }

    public function store(Request $request){
        $status = 0;

        // Note Status Transaksi
        // 1 = Lunas (Cash / Transfer yang sudah diterima)
        // 2 = Pending Piutang (Credit)
        // 3 = Pending Transfer (Transfer yang belum diterima)
        // 4 = Return (Transaksi retur)
        // 5 = Pending Online Order (Order dari online yang belum diproses)

        try {
            DB::beginTransaction();

            $branchCode = DB::table('branches')->where('id', Auth::user()->branch_id)->value('code');

            $transactionCode = DB::select('SELECT generate_transaction_code(?) AS transaction_code', [$branchCode])[0]->transaction_code;

            $paymentMethod = $request->payment_method;
            $totalAmount = $request->total_amount;

            $customerCreditLimit = $this->getCustomerCreditLimit($request->customer_id);
            $customerTotalDebt = $this->getCustomerTotalDebt($request->customer_id);

            if($paymentMethod == '2' && ($customerTotalDebt + $totalAmount) > $customerCreditLimit) {
                return response()->json([
                    'message' => 'Customer credit limit exceeded',
                    'customer_credit_limit' => $customerCreditLimit,
                    'customer_total_debt' => $customerTotalDebt
                ], 400);
            }

            // Journal entries based on payment method
            if ($paymentMethod == '1') {
                $status = 1;
                DB::statement("CALL create_journal_proc(?, ?, ?, ?)", [
                    'sales_cash', $transactionCode, 'Penjualan dengan pembayaran Cash', $totalAmount
                ]);

                $session = DB::table('pos_sessions')
                    ->where('branch_id', Auth::user()->branch_id)
                    ->where('status', 'OPEN')
                    ->where('created_at', '>=', now()->startOfDay())
                    ->where('created_at', '<', now()->endOfDay())
                    ->first();

                if (!$session) {
                    throw new \Exception('POS session tidak ditemukan / belum dibuka');
                }

                // insert cash movement (IN)
                DB::table('cash_movements')->insert([
                    'pos_session_id' => $session->id,
                    'user_id'        => Auth::user()->id,
                    'type'           => 'SALE',
                    'direction'      => 'IN',
                    'amount'         => $totalAmount,
                    'reference_type' => 'ORDER',
                    'reference_id'   => $session->id,
                    'description'    => 'Penjualan cash',
                    'created_at'     => now()
                ]);

            } elseif ($paymentMethod == '2') {
                $status = 2; // Pending Piutang
                DB::statement("CALL create_journal_proc(?, ?, ?, ?)", [
                    'sales_credit', $transactionCode, 'Penjualan dengan pembayaran Credit', $totalAmount
                ]);
            } elseif ($paymentMethod == '3') {

                $status = 3; // Pending Transfer
                if($request->transfer_type == 1) {
                    $status = 1;
                }

                DB::statement("CALL create_journal_proc(?, ?, ?, ?)", [
                    'sales_transfer', $transactionCode, 'Penjualan dengan pembayaran Transfer', $totalAmount
                ]);
            }

            // Convert uploaded file to base64
            $transferBase64 = null;
            if ($request->hasFile('transfer_attch')) {
                $file = $request->file('transfer_attch');
                $fileContents = file_get_contents($file->getRealPath());
                $transferBase64 = base64_encode($fileContents);
            }

            if($request->working_method == 2) { // Online Order (Processing Order)
                $status = 5; // Pending (Processing Order)
                $paymentMethod = null; // Disable payment method for online orders
            }

            // Insert transaction header
            $transactionId = DB::table('transactions')->insertGetId([
                "code"             => $transactionCode,
                "transaction_date" => now(),
                "customer_id"      => $request->customer_id,
                "payment_method"   => $paymentMethod,
                "butcher_name"     => $request->butcher_name,
                "discount"         => $request->total_discount,
                "shipping_cost"    => $request->shipping_cost,
                "sub_total"        => $request->sub_total,
                "total_amount"     => $totalAmount,
                "status"           => $status,
                "nominal_cash"     => $request->nominal_cash,
                "nominal_return"   => $request->nominal_return,
                "created_by"       => Auth::id(),
                "branch_id"        => $request->branch_id,
                "transfer_ref"     => $request->transfer_ref,
                "transfer_attch"   => $transferBase64,
                "ordering_method"  => $request->ordering_method,
                "working_method"   => $request->working_method,
                "notes"            => $request->notes,
            ]);

            // Parse and insert transaction items
            $details = json_decode($request->details, true);
            foreach ($details as $detail) {
                $transactionItemId = DB::table('transaction_items')->insertGetId([
                    "transaction_id" => $transactionId,
                    "product_id"     => $detail["product_id"],
                    "quantity"       => $detail["quantity"],
                    "base_price"     => $detail["base_price"],
                    "butcherees_id"  => $detail["butcher_id"],
                    "discount"       => $detail["discount"],
                ]);

                $stockId = DB::table('stocks')
                    ->where('product_id', $detail["product_id"])
                    ->where('branch_id', $request->branch_id)
                    ->value('id');

                DB::table('stock_logs')->insert([
                    "stock_id"     => $stockId,
                    "out_quantity" => $detail["quantity"],
                    "reference"    => 'Penjualan #' . $transactionCode,
                    "date"         => now(),
                    "ref_type"     => 'SALES',
                    "ref_id"       => $transactionItemId,
                ]);
            }

            DB::commit();

            return response()->json([
                'message'          => 'Transaction successfully created',
                'transaction_code' => $transactionCode,
                'transaction_id'   => $transactionId,
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'Failed to create transaction',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    public function getCustomerReceivable($customerId)
    {
        // 1. Calculate remaining balance from invoices
        $invoicedReceivable = DB::table('invoices')
            ->where('customer_id', $customerId)
            ->where('status', '!=', 'paid')
            ->sum('remaining_billed');

        // 2. Calculate receivable from transactions not yet invoiced
        $nonInvoicedReceivable = DB::table('transactions')
            ->where('customer_id', $customerId)
            ->where('status', '!=', 1) // status 1 = Lunas
            ->where('type', '!=', 'return') // exclude returns
            ->whereNotIn('id', function($query) {
                $query->select('transaction_id')
                    ->from('invoice_details')
                    ->whereNotNull('transaction_id');
            })
            ->sum('amount');

        // 3. Calculate available overpayment credit
        $availableOverpayment = DB::table('customer_overpayments')
            ->where('customer_id', $customerId)
            ->sum('remaining_amount');

        // 4. Calculate total receivable
        $totalReceivable = ($invoicedReceivable ?? 0) + ($nonInvoicedReceivable ?? 0);
        $netReceivable = $totalReceivable - ($availableOverpayment ?? 0);

        return [
            'customer_id' => $customerId,
            'invoiced_receivable' => $invoicedReceivable ?? 0,
            'non_invoiced_receivable' => $nonInvoicedReceivable ?? 0,
            'total_receivable' => $totalReceivable,
            'available_overpayment' => $availableOverpayment ?? 0,
            'net_receivable' => max(0, $netReceivable) // tidak bisa minus
        ];
    }

    private function getCustomerCreditLimit($customerId)
    {
        $creditLimit = DB::table('customer_credit_policies')
            ->where('customer_id', $customerId)
            ->value('credit_limit');

        return $creditLimit;
    }

    private function getCustomerTotalDebt($customerId)
    {
        $totalDebt = DB::table('transactions')
            ->where('customer_id', $customerId)
            ->where('payment_method', '=', 2) // payament_method 2 = Credit (Piutang)
            ->where('status', '!=', 1) // status 1 = Lunas
            ->sum('total_amount');

        return $totalDebt ?? 0;
    }

}
