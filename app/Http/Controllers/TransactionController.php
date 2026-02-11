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

        try {
            DB::beginTransaction();

            $branchCode = DB::table('branches')->where('id', Auth::user()->branch_id)->value('code');

            $transactionCode = DB::select('SELECT generate_transaction_code(?) AS transaction_code', [$branchCode])[0]->transaction_code;

            $paymentMethod = $request->payment_method;
            $totalAmount = $request->total_amount;

            // Journal entries based on payment method
            if ($paymentMethod == '1') {
                $status = 1;
                DB::statement("CALL create_journal_proc(?, ?, ?, ?)", [
                    'sales_cash', $transactionCode, 'Penjualan dengan pembayaran Cash', $totalAmount
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

            // Insert transaction header
            $transactionId = DB::table('transactions')->insertGetId([
                "code"             => $transactionCode,
                "transaction_date" => now(),
                "customer_id"      => $request->customer_id,
                "total_amount"     => $totalAmount,
                "payment_method"   => $paymentMethod,
                "butcher_name"     => $request->butcher_name,
                "discount"         => $request->discount,
                "shipping_cost"    => $request->shipping_cost,
                "status"           => $status,
                "nominal_cash"     => $request->nominal_cash,
                "nominal_return"   => $request->nominal_return,
                "created_by"       => Auth::id(),
                "branch_id"        => $request->branch_id,
                "transfer_ref"     => $request->transfer_ref,
                "transfer_attch"   => $transferBase64,
            ]);

            // Handle credit (payment method 2)
            if ($paymentMethod == '2') {
                $dueDate = now()->addDays(7)->format('Y-m-d');
                DB::table('receivables')->insert([
                    "transaction_id"     => $transactionId,
                    "transaction_no"     => $transactionCode,
                    "transaction_date"   => now()->format('Y-m-d'),
                    "customer_id"        => $request->customer_id,
                    "due_date"           => $dueDate,
                    "total_receivable"   => $totalAmount,
                    "remaining_balance"  => $totalAmount,
                    "status"             => 'unpaid',
                    "created_at"         => now(),
                ]);
            }

            // Parse and insert transaction items
            $details = json_decode($request->details, true);
            foreach ($details as $detail) {
                DB::table('transaction_items')->insert([
                    "transaction_id" => $transactionId,
                    "product_id"     => $detail["product_id"],
                    "quantity"       => $detail["quantity"],
                    "base_price"     => $detail["base_price"],
                    "unit_price"     => $detail["price"],
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

}
