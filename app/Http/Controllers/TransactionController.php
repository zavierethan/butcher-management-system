<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\JournalService;
use DB;
use Auth;

class TransactionController extends Controller
{
    public function index() {
        $productCategories = DB::table('product_categories')->where('is_active', 1)->get();
        $branches = DB::table('branches')->where('is_active', 1)->get();
        $settings = DB::table('branch_settings')->where('branch_id', Auth::user()->branch_id)->first();
        $butcherees = DB::table('butcherees')->where('branch_id', Auth::user()->branch_id)->get();

        return view('modules.transactions.pos.index', compact('productCategories', 'branches', 'butcherees', 'settings'));
    }

    public function store(Request $request) {

        $payloads = $request->all();
        $status = 0;

        try {
            // Start a database transaction
            DB::beginTransaction();

            $branchCode = DB::table('branches')->where('id', Auth::user()->branch_id)->value('code');

            $transactionCode = DB::select('SELECT generate_transaction_code(?) AS transaction_code', [$branchCode])[0]->transaction_code;

            if($payloads["header"]["payment_method"] == '1') {
                $status = 1;

                DB::statement("CALL create_journal_proc(?, ?, ?, ?)", [
                    'sales_cash', $transactionCode, 'Penjualan dengan pembayaran Cash', $payloads["header"]["total_amount"]
                ]);
            }

            if($payloads["header"]["payment_method"] == '3') {
                $status = 2;

                DB::statement("CALL create_journal_proc(?, ?, ?, ?)", [
                    'sales_transfer', $transactionCode, 'Penjualan dengan pembayaran Transfer', $payloads["header"]["total_amount"]
                ]);
            }

            if($payloads["header"]["payment_method"] == '2') {
                $status = 2;

                DB::statement("CALL create_journal_proc(?, ?, ?, ?)", [
                    'sales_credit', $transactionCode, 'Penjualan dengan pembayaran Credit', $payloads["header"]["total_amount"]
                ]);
            }

            date_default_timezone_set('Asia/Jakarta');

            $transactionId = DB::table('transactions')->insertGetId([
                "code" => $transactionCode,
                "transaction_date" => date('Y-m-d H:i:s'),
                "customer_id" => $payloads["header"]["customer_name"],
                "total_amount" => $payloads["header"]["total_amount"],
                "payment_method" => $payloads["header"]["payment_method"],
                "customer_id" => $payloads["header"]["customer_id"],
                "butcher_name" => $payloads["header"]["butcher_name"],
                "discount" => $payloads["header"]["discount"],
                "shipping_cost" => $payloads["header"]["shipping_cost"],
                "status" => $status, // 1 = Lunas, 2 = Pending, 3 = Batal
                "nominal_cash" => $payloads["header"]["nominal_cash"],
                "nominal_return" => $payloads["header"]["nominal_return"],
                "created_by" => Auth::user()->id,
                "branch_id" => $payloads["header"]["branch_id"],
            ]);

            if($payloads["header"]["payment_method"] == '2') {

                $timestamp = strtotime('+7 days'); // Get current date

                $dueDate = date('Y-m-d', $timestamp);  // Add 7 days

                DB::table('receivables')->insertGetId([
                    "transaction_id" => $transactionId,
                    "transaction_no" => $transactionCode,
                    "transaction_date" => date("Y-m-d"),
                    "customer_id" => $payloads["header"]["customer_id"],
                    "due_date" => $dueDate,
                    "total_receivable" => $payloads["header"]["total_amount"],
                    "remaining_balance" => $payloads["header"]["total_amount"],
                    "status" => 'unpaid',
                    "created_at" => date('Y-m-d'),
                ]);
            }

            // Save the transaction details
            foreach ($payloads['details'] as $detail) {
                DB::table('transaction_items')->insertGetId([
                    "transaction_id" => $transactionId,
                    "product_id" =>  $detail["product_id"],
                    "quantity" => $detail["quantity"],
                    "base_price" => $detail["base_price"],
                    "unit_price" => $detail["price"],
                    "discount" => $detail["discount"],
                ]);

                $stockId = DB::table('stocks')->where('product_id', $detail["product_id"])->where('branch_id', $payloads["header"]["branch_id"])->value('id');

                DB::table('stock_logs')->insert([
                    "stock_id" => $stockId,
                    "out_quantity" => $detail["quantity"],
                    "date" => $detail["quantity"],
                    "reference" => 'Penjualan #'.$transactionCode,
                    "date" => date('Y-m-d H:i:s'),
                ]);
            }

            // Commit the transaction
            DB::commit();

            // Return success response
            return response()->json([
                'message' => 'Transaction successfully created',
                'transaction_code' => $transactionCode,
                'transaction_id' => $transactionId,
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
