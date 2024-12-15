<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class TransactionController extends Controller
{
    public function index() {
        return view('modules.transactions.pos.index');
    }

    public function store(Request $request) {

        $payloads = $request->all();

        try {
            // Start a database transaction
            DB::beginTransaction();

            $transactionId = DB::table('transactions')->insertGetId([
                "code" => DB::select('SELECT generate_transaction_code() AS transaction_code')[0]->transaction_code,
                "transaction_date" => date("Y-m-d"),
                "customer_id" => $payloads["header"]["customer_name"],
                "total_amount" => $payloads["header"]["total_amount"],
                "payment_method" => $payloads["header"]["payment_method"],
                "status" => 3, // 1 = Pending, 2 = Menunggu Transfer, 3 = Lunas , 4  = Batal
            ]);

            // Save the transaction details
            foreach ($payloads['details'] as $detail) {
                DB::table('transaction_items')->insertGetId([
                    "transaction_id" => $transactionId,
                    "product_id" =>  $detail["product_id"],
                    "quantity" => $detail["quantity"],
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
