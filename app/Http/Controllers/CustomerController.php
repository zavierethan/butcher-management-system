<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class CustomerController extends Controller
{
    public function index() {
        return view('modules.master.customer.index');
    }

    public function getLists(Request $request) {

        $params = $request->all();

        $query = DB::table('customers')
            ->leftJoin('customer_overpayments', 'customer_overpayments.customer_id', '=', 'customers.id')
            ->selectRaw("
                customers.id,
                customers.name,
                customers.ktp_number,
                customers.phone_number,
                customers.type,
                customers.address,
                TO_CHAR(
                    ROUND(
                        COALESCE(SUM(
                            CASE
                                WHEN customer_overpayments.direction = 'IN' THEN customer_overpayments.amount
                                WHEN customer_overpayments.direction = 'OUT' THEN -customer_overpayments.amount
                                ELSE 0
                            END
                        ), 0)::numeric
                    ),
                    'FM999,999,999'
                ) as total_saldo_overpayment
            ")
            ->groupBy(
                'customers.id',
                'customers.name',
                'customers.ktp_number',
                'customers.phone_number',
                'customers.type',
                'customers.address',
                );

        // Apply global search if provided
        $searchValue = $request->input('search.value');
        if (!empty($searchValue)) {
            $query->whereRaw('customers.name ILIKE ?', ['%' . $searchValue . '%']);
        }

        $start = $request->input('start', 0);
        $length = $request->input('length', 10);

        $totalRecords = $query->count();
        $filteredRecords = $query->count();
        $data = $query->orderBy('customers.id', 'desc')->skip($start)->take($length)->get();

        $response = [
            'draw' => $request->input('draw'),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $data
        ];

        return response()->json($response);
    }

    public function create() {
        return view('modules.master.customer.create');
    }

    public function save(Request $request) {

        DB::table('customers')->insert([
            "name" => $request->name,
            "ktp_number" => $request->ktp_number,
            "phone_number" => $request->phone_number,
            "type" => $request->type,
            "address" => $request->address,
            "transaction_notes" => $request->transaction_notes,
            "is_active" => $request->is_active,
        ]);

        return redirect()->route('customers.index');
    }

    public function edit($id) {
        $customer = DB::table('customers')->where('id', $id)->first();

        if (!$customer) {
            return redirect()->route('customers.index')->with('error', 'Customer not found.');
        }

        return view('modules.master.customer.edit', compact('customer'));
    }

    public function update(Request $request) {

        DB::table('customers')
            ->where('id', $request->id)
            ->update([
                'name' => $request->name,
                'ktp_number' => $request->ktp_number,
                'phone_number' => $request->phone_number,
                'type' => $request->type,
                "address" => $request->address,
                "transaction_notes" => $request->transaction_notes,
                "is_active" => $request->is_active,
            ]);

        return redirect()->route('customers.index');
    }

    public function getListFiltered(Request $request) {
        $params = $request->q;

        $query = DB::table('customers');

        if($params != null) {
            $query->where('name', 'like', $params.'%');
        }

        $data = $query->orderBy('customers.id', 'desc')->get();

        $totalRecords = $query->count();
        $filteredRecords = $query->count();

        $data = $query->orderBy('customers.id', 'desc')->get();

        $response = [
            'draw' => $request->input('draw'),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $data
        ];

        return response()->json($response);
    }

    public function saveNewCustomerFromPOS(Request $request) {

        DB::table('customers')->insert([
            "name" => $request->name,
            "phone_number" => $request->phone_number,
            "transaction_notes" => $request->transaction_notes,
        ]);

        return response()->json([
            'message' => 'customer successfully created'
        ], 201);
    }

    public function creditPolicies($id) {
        $customer = DB::table('customers')
            ->select('customers.id','customers.name', 'customer_credit_policies.credit_limit', 'customer_credit_policies.due_date_interval')
            ->leftJoin('customer_credit_policies', 'customer_credit_policies.customer_id', '=', 'customers.id')
            ->where('customers.id', $id)->first();

        return view('modules.master.customer.credit-policies', compact('customer'));
    }

    public function creditPoliciesSave(Request $request) {

        DB::table('customer_credit_policies')->updateOrInsert(
            ['customer_id' => $request->customer_id],
            [
                "credit_limit" => $request->credit_limit,
                "due_date_interval" => $request->due_date_interval,
            ]
        );

        return redirect()->route('customers.index');
    }

    public function productDiscounts($id) {
        $customer = DB::table('customers')
            ->select('customers.id','customers.name')
            ->where('customers.id', $id)->first();

        $products = DB::table('products')->orderBy('sort_order', 'asc')->get();
        $productDiscounts = DB::table('customer_product_discounts')
            ->join('products', 'products.id', '=', 'customer_product_discounts.product_id')
            ->where('customer_product_discounts.customer_id', $id)
            ->select(
                'customer_product_discounts.product_id',
                'products.name as product_name',
                DB::raw("
                    TO_CHAR(
                        customer_product_discounts.discount,
                        'FM999,999,999'
                    ) as discount
                ")
            )
            ->get();

        return view('modules.master.customer.product-discounts', compact('customer', 'products', 'productDiscounts'));
    }

    public function productDiscountsSave(Request $request) {
        $products = $request->input('products', []);

        DB::beginTransaction();
        try {

            DB::table('customer_product_discounts')
                ->where('customer_id', $request->input('customer_id'))
                ->delete();

            foreach ($products as $item) {
                DB::table('customer_product_discounts')->insert([
                    'customer_id' => $request->input('customer_id'),
                    'product_id' => $item['product_id'],
                    'discount' => $item['discount']
                ]);
            }
            DB::commit();
            return response()->json(['message' => 'Success']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Failed to create transaction',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    public function customerNotes($id) {
        $customer = DB::table('customers')
            ->where('id', $id)
            ->first();

        return response()->json([
            'data' => $customer->transaction_notes
        ], 200);
    }

}
