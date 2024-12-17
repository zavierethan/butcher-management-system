<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;

class TransactionController extends Controller
{
    public function index() {
        $productCategories = DB::table('product_categories')->where('is_active', 1)->get();
        return view('modules.transactions.pos.index', compact('productCategories'));
    }

    public function store(Request $request) {

        $payloads = $request->all();
        $status = 0;

        try {
            // Start a database transaction
            DB::beginTransaction();

            if($payloads["header"]["payment_method"] == '1') {
                $status = 1;
            }

            if($payloads["header"]["payment_method"] == '2') {
                $status = 2;
            }

            if($payloads["header"]["payment_method"] == '3') {
                $status = 2;
            }

            if($payloads["header"]["payment_method"] == '4') {
                $status = 1;
            }

            $transactionId = DB::table('transactions')->insertGetId([
                "code" => DB::select('SELECT generate_transaction_code() AS transaction_code')[0]->transaction_code,
                "transaction_date" => date("Y-m-d"),
                "customer_id" => $payloads["header"]["customer_name"],
                "total_amount" => $payloads["header"]["total_amount"],
                "payment_method" => $payloads["header"]["payment_method"],
                "status" => $status, // 1 = Lunas, 2 = Pending, 3 = Batal
                "created_by" => Auth::user()->id,
            ]);

            // Save the transaction details
            foreach ($payloads['details'] as $detail) {
                DB::table('transaction_items')->insertGetId([
                    "transaction_id" => $transactionId,
                    "product_id" =>  $detail["product_id"],
                    "quantity" => $detail["quantity"],
                    "base_price" => $detail["base_price"],
                    "unit_price" => $detail["price"],
                ]);
            }

            // Commit the transaction
            DB::commit();

            // Return success response
            return response()->json([
                'message' => 'Transaction successfully created',
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
