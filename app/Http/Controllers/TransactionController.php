<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;

class TransactionController extends Controller
{
    public function index() {
        $productCategories = DB::table('product_categories')->where('is_active', 1)->get();
        $branches =  DB::table('branches')->where('is_active', 1)->get();
        return view('modules.transactions.pos.index', compact('productCategories', 'branches'));
    }

    public function store(Request $request) {

        $payloads = $request->all();
        $status = 0;

        try {
            // Start a database transaction
            DB::beginTransaction();

            $branchCode = DB::table('branches')->where('id', Auth::user()->branch_id)->value('code');

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

            $transactionCode = DB::select('SELECT generate_transaction_code(?) AS transaction_code', [$branchCode])[0]->transaction_code;

            $transactionId = DB::table('transactions')->insertGetId([
                "code" => $transactionCode,
                "transaction_date" => date("Y-m-d"),
                "customer_id" => $payloads["header"]["customer_name"],
                "total_amount" => $payloads["header"]["total_amount"],
                "payment_method" => $payloads["header"]["payment_method"],
                "customer_id" => $payloads["header"]["customer_id"],
                "butcher_name" => $payloads["header"]["butcher_name"],
                "discount" => $payloads["header"]["discount"],
                "shipping_cost" => $payloads["header"]["shipping_cost"],
                "status" => $status, // 1 = Lunas, 2 = Pending, 3 = Batal
                "created_by" => Auth::user()->id,
                "branch_id" => $payloads["header"]["branch_id"],
            ]);

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

                // $stock = DB::table('stocks')->where('product_id', $detail["product_id"])->where('branch_id', $payloads["header"]["branch_id"])->where('date', date("Y-m-d"))->first();

                // DB::table('stock_logs')->insert([
                //     "stock_id" => $stock->id,
                //     "out_quantity" => $detail["quantity"],
                //     "date" => date("Y-m-d")
                // ]);
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
