<?php

namespace App\Http\Controllers\Finances;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DB;
use Auth;

class GeneralLedgerController extends Controller
{
    public function index() {
        $accounts = DB::table('accounts')->get();
        return view('modules.finances.general-ledger.index', compact('accounts'));
    }

    public function getLists(Request $request){
        $params = $request->all();

        // Query General Ledger dengan Join ke Accounts
        $query = DB::table('general_ledger')
            ->leftJoin('journals', 'journals.id', '=', 'general_ledger.journal_id')
            ->leftJoin('accounts', 'accounts.id', '=', 'general_ledger.account_id')
            ->select(
                DB::raw("TO_CHAR(general_ledger.date, 'DD/MM/YYYY') as date"),
                'general_ledger.journal_id',
                'general_ledger.account_id',
                'accounts.name as account_name', // Ambil nama akun dari tabel accounts
                'journals.description',
                'general_ledger.reference',
                'general_ledger.debit',
                'general_ledger.credit',
                DB::raw("TO_CHAR(general_ledger.debit, 'FM999,999,999') as debit_formated"),
                DB::raw("TO_CHAR(general_ledger.credit, 'FM999,999,999') as credit_formated")
            );

        // Filter berdasarkan tanggal
        if (!empty($params['start_date']) && !empty($params['end_date'])) {
            $query->whereBetween('general_ledger.date', [
                $params['start_date'],
                $params['end_date']
            ]);
        }

        // Filter berdasarkan account_id
        if (!empty($params['account_id'])) {
            $query->where('general_ledger.account_id', $params['account_id']);
        }

        // Pagination
        $start = $request->input('start', 0);
        $length = $request->input('length', 10);

        // Hitung total dan filtered records
        $totalRecords = DB::table('general_ledger')->count();
        $filteredRecords = $query->count();

        // Ambil data setelah filtering & sorting
        $data = $query->orderBy('general_ledger.date', 'asc')
            ->orderBy('general_ledger.journal_id', 'asc')
            ->skip($start)
            ->take($length)
            ->get();

        // Hitung saldo berjalan (Running Balance)
        $balances = [];
        foreach ($data as $ledger) {
            if (!isset($balances[$ledger->account_id])) {
                $balances[$ledger->account_id] = 0;
            }

            // Perhitungan saldo berjalan
            $balances[$ledger->account_id] += ($ledger->debit - $ledger->credit);
            $ledger->running_balance = number_format($balances[$ledger->account_id], 0, ',', '.'); // Tambahkan saldo berjalan
        }

        return response()->json([
            'draw' => $request->input('draw'),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $data
        ]);
    }

}
