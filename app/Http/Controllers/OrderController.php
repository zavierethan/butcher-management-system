<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\TransactionExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Services\JournalService;
use DB;
use PDF;
use Auth;

use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\EscposImage;

class OrderController extends Controller
{
    public function index() {
        $branches =  DB::table('branches')->where('is_active', 1)->get();
        $customers =  DB::table('customers')->orderBy('name', 'asc')->get();
        return view('modules.transactions.order.index', compact('branches', 'customers'));
    }

    public function getLists(Request $request){
        $params = $request->all();

        $query = DB::table('transactions')
                ->select(
                    'transactions.id',
                    'transactions.code',
                    DB::raw("TO_CHAR(transactions.transaction_date, 'dd/mm/YYYY HH24:MI:SS') as transaction_date"),
                    'transactions.payment_method',
                    DB::raw("TO_CHAR(transactions.total_amount, 'FM999,999,999') as total_amount"),
                    'transactions.status',
                    'customers.name as customer_name',
                    'users.name as created_by'
                )
                ->leftJoin('customers', 'customers.id', '=', 'transactions.customer_id')
                ->leftJoin('users', 'users.id', '=', 'transactions.created_by')
                ->leftJoin('branches', 'branches.id', '=', 'users.branch_id');

        if(Auth::user()->group_id != 1) {
            $query->where('transactions.branch_id', Auth::user()->branch_id);
        }

        if (!empty($params['start_date']) && !empty($params['end_date'])) {
            $query->whereBetween(DB::raw('DATE(transactions.transaction_date)'), [
                $params['start_date'],
                $params['end_date']
            ]);
        }

        if (!empty($params['customer'])) {
            $query->where('transactions.customer_id', $params['customer']);
        }

        if (!empty($params['payment_method'])) {
            $query->where('transactions.payment_method', $params['payment_method']);
        }

        if (!empty($params['status'])) {
            $query->where('transactions.status', $params['status']);
        }

        if (!empty($params['branch_id'])) {
            $query->where('transactions.branch_id', $params['branch_id']);
        }

        // Apply global search if provided
        $searchValue = $request->input('search.value'); // This is where DataTables sends the search input
        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('transactions.code', 'like', '%' . strtoupper($searchValue) . '%');
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

    public function edit($id) {
        $detailTransaction = DB::table('transactions')
                    ->select(
                        'transactions.id',
                        'transactions.code',
                        DB::raw("TO_CHAR(transactions.transaction_date, 'DD/MM/YYYY') as transaction_date"),
                        'transactions.payment_method',
                        'transactions.discount',
                        'transactions.shipping_cost',
                        'transactions.total_amount',
                        'transactions.status',
                        'customers.name as customer_name',
                        'transactions.butcher_name',
                        'users.name as created_by'
                    )
                    ->leftJoin('customers', 'customers.id', '=', 'transactions.customer_id')
                    ->leftJoin('users', 'users.id', '=', 'transactions.created_by')
                    ->where('transactions.id', $id)->first();

        $detailItems = DB::table('transaction_items')
                    ->select(
                        'products.id',
                        'products.code',
                        'products.name',
                        'products.url_path',
                        'transaction_items.quantity',
                        'transaction_items.base_price',
                        'transaction_items.unit_price as sell_price',
                        'transaction_items.discount'
                    )
                    ->leftJoin('products', 'products.id', '=', 'transaction_items.product_id')
                    ->where('transaction_id', $detailTransaction->id)->get();

        return view('modules.transactions.order.edit', compact('detailTransaction', 'detailItems'));
    }

    public function update(Request $request) {

        DB::table('transactions')->where('id', $request->transaction_id)->update([
            "status" => $request->status
        ]);

        return response()->json([
            'message' => 'Transaction successfully updated',
        ], 200);
    }

    public function export(Request $request) {

        $filters = [
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'branch_id' => $request->branch_id,
            'payment_method' => $request->payment_method,
            'status' => $request->status,
        ];

        // Generate raw Excel data
        $branch = DB::table('branches')->where('id', $request->branch_id)->first();

        $filters['branch_name'] = $branch->name ?? null;
        $filters['branch_code'] = $branch->code ?? null;

        $export = new TransactionExport($filters);
        $excelData = Excel::raw($export, \Maatwebsite\Excel\Excel::XLSX);

        // Return the data as a proper response
        return response($excelData, 200, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="transaction-reports.xlsx"',
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0',
        ]);
    }

    public function printReceipt($id) {
        $detailTransaction = DB::table('transactions')
                    ->select(
                        'transactions.id',
                        'transactions.code',
                        DB::raw("TO_CHAR(transactions.transaction_date, 'dd/mm/YYYY') as transaction_date"),
                        DB::raw("
                            CASE
                                WHEN transactions.payment_method = '1' THEN 'TUNAI'
                                WHEN transactions.payment_method = '2' THEN 'PIUTANG'
                                WHEN transactions.payment_method = '3' THEN 'TRANSFER'
                            ELSE
                                '-'
                            END AS payment_method
                        "),
                        'transactions.discount',
                        'transactions.shipping_cost',
                        'transactions.total_amount',
                        'transactions.status',
                        'customers.name as customer_name',
                        'users.name as created_by',
                        'branches.name as branhces',
                        'branches.address',
                        'branches.phone_number'
                    )
                    ->leftJoin('customers', 'customers.id', '=', 'transactions.customer_id')
                    ->leftJoin('users', 'users.id', '=', 'transactions.created_by')
                    ->leftJoin('branches', 'branches.id', '=', 'users.branch_id')
                    ->where('transactions.id', $id)->first();

        $detailItems = DB::table('transaction_items')
                    ->select(
                        'products.id',
                        'products.code',
                        'products.name',
                        'transaction_items.quantity',
                        'transaction_items.base_price',
                        'transaction_items.discount',
                        'transaction_items.unit_price as sell_price'
                    )
                    ->join('transactions', 'transactions.id', '=', 'transaction_items.transaction_id')
                    ->leftJoin('products', 'products.id', '=', 'transaction_items.product_id')
                    ->where('transaction_items.transaction_id', $id)
                    ->get();

        $pdf = PDF::loadView('modules.transactions.order.receipt', [
            "info" => $detailTransaction,
            "items" => $detailItems
        ])->setPaper([0, 0, 330, 700]);

        return $pdf->stream('receipt.pdf'); // To display
    }

    public function printThermal($id) {
        try {

            $info = DB::table('transactions')
                    ->select(
                        'transactions.id',
                        'transactions.code',
                        DB::raw("TO_CHAR(transactions.transaction_date, 'dd/mm/YYYY HH24:MI:SS') as transaction_date"),
                        DB::raw("
                            CASE
                                WHEN transactions.payment_method = '1' THEN 'TUNAI'
                                WHEN transactions.payment_method = '2' THEN 'PIUTANG'
                                WHEN transactions.payment_method = '3' THEN 'TRANSFER'
                            ELSE
                                '-'
                            END AS payment_method
                        "),
                        'transactions.discount',
                        'transactions.shipping_cost',
                        DB::raw("TO_CHAR(transactions.total_amount, 'FM999,999,999') as total_amount"),
                        'transactions.status',
                        DB::raw("TO_CHAR(transactions.nominal_cash, 'FM999,999,999') as nominal_cash"),
                        DB::raw("TO_CHAR(transactions.nominal_return, 'FM999,999,999') as nominal_return"),
                        'customers.name as customer_name',
                        'users.name as created_by',
                        'branches.name as branhces',
                        'branches.address',
                        'branches.phone_number'
                    )
                    ->leftJoin('customers', 'customers.id', '=', 'transactions.customer_id')
                    ->leftJoin('users', 'users.id', '=', 'transactions.created_by')
                    ->leftJoin('branches', 'branches.id', '=', 'users.branch_id')
                    ->where('transactions.id', $id)->first();

        $items = DB::table('transaction_items')
                    ->select(
                        'products.id',
                        'products.code',
                        'products.name',
                        'transaction_items.quantity',
                        'transaction_items.base_price',
                        'transaction_items.discount',
                        'transaction_items.unit_price as sell_price'
                    )
                    ->leftJoin('products', 'products.id', '=', 'transaction_items.product_id')
                    ->where('transaction_id', $info->id)->get()->map(function ($item) {
                        // Format the prices using number_format
                        $item->base_price = number_format($item->base_price, 0, '.', ','); // Format for money
                        $item->sell_price = number_format($item->sell_price, 0, '.', ','); // Format for money
                        return $item;
                    });

            // Windows shared printer name
            // $printerName = "PRIYADIS-BUTCHERS"; // Change this to your actual printer share name

            // $connector = new WindowsPrintConnector($printerName);
            // $printer = new Printer($connector);

            // /// **Business Name (Larger Font)**
            // $printer->setJustification(Printer::JUSTIFY_CENTER);
            // $printer->setTextSize(1, 1); // (Width, Height)
            // $printer->text("Priyadis Butchers\n");
            // $printer->setTextSize(1, 1); // Reset size
            // $printer->text($info->address."\n");
            // $printer->setTextSize(1, 1); // Reset size
            // $printer->text("Telp:".$info->phone_number."\n");

            // $printer->text(str_repeat("-", 32) . "\n");

            // // **Transaction Details**
            // $printer->setJustification(Printer::JUSTIFY_LEFT);
            // $printer->text("No Transaksi : ".$info->code."\n");
            // $printer->text("Tanggal : ".$info->transaction_date."\n");
            // $printer->text("Kasir : ".$info->created_by."\n");

            // $printer->text(str_repeat("-", 32) . "\n");

            // foreach($items as $item) {
            //     // **First Item (DADA) with Discount**
            //     $printer->setJustification(Printer::JUSTIFY_LEFT);
            //     $printer->text($item->name."\n");

            //     if($item->discount > 0) {
            //         $printer->text($item->quantity." X ".$item->base_price." (Discount ".$item->discount.")\n");
            //     } else {
            //         $printer->text($item->quantity." X ".$item->base_price."\n");
            //     }

            //     $printer->setJustification(Printer::JUSTIFY_RIGHT);
            //     $printer->text("Rp. ".$item->sell_price."\n");
            // }

            // // **Separator**
            // $printer->text(str_repeat("-", 32) . "\n");

            // // **Total**
            // $printer->setJustification(Printer::JUSTIFY_RIGHT);
            // $printer->setEmphasis(true);
            // $printer->text("Total  Rp. ".number_format($info->total_amount, 0, '.', ',')."\n");
            // $printer->setEmphasis(false);

            // // **Payment (Cash)**
            // $printer->text("Bayar (Cash)  Rp. ".$info->nominal_cash."\n");

            // // **Change (Kembali)**
            // $printer->text("Kembali  Rp. ".$info->nominal_return."\n");

            // // **End Separator**
            // $printer->text(str_repeat("-", 32) . "\n");

            // // **Thank You Message (Centered)**
            // $printer->setJustification(Printer::JUSTIFY_CENTER);
            // $printer->feed(1);
            // $printer->text("Terimakasih atas Kepercayaan\n");
            // $printer->text("anda\n");
            // $printer->feed(2);

            // // **Finish Printing**
            // $printer->feed(2);
            // $printer->cut();
            // $printer->close();

            $data = [
                'header' => $info,
                'details' => $items
            ];

            return response()->json([
                'code' => 200,
                'status' => 'success',
                'data' => $data,
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }

    public function syncToJournal(Request $request) {
        return response()->json(['status' => 'Synchronization to journal was successful']);
    }
}
