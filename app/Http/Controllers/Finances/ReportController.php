<?php

namespace App\Http\Controllers\Finances;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DB;

class ReportController extends Controller
{
    public function index() {
        return view('modules.finances.report.index');
    }

    public function getReportSummary(Request $request){
        $totalIncome = DB::table('general_ledger')
            ->leftJoin('accounts', 'accounts.id', '=', 'general_ledger.account_id')
            ->leftJoin('account_types', 'account_types.id', '=', 'accounts.type_id')
            ->leftJoin('account_categories', 'account_categories.id', '=', 'account_types.category_id')
            ->where('account_categories.id', 4) // 4 = Kategori Pendapatan
            ->select(DB::raw('COALESCE(SUM(general_ledger.credit) - SUM(general_ledger.debit), 0) as amount'))
            ->first()->amount;

        $totalExpense = DB::table('general_ledger')
            ->leftJoin('accounts', 'accounts.id', '=', 'general_ledger.account_id')
            ->leftJoin('account_types', 'account_types.id', '=', 'accounts.type_id')
            ->leftJoin('account_categories', 'account_categories.id', '=', 'account_types.category_id')
            ->where('account_categories.id', 5) // 5 = Kategori Beban
            ->select(DB::raw('COALESCE(SUM(general_ledger.debit) - SUM(general_ledger.credit), 0) as amount'))
            ->first()->amount;

        $summary = [
            'totalIncomes' => $totalIncome,
            'totalExpenses' => $totalExpense,
            'totalNetProfit' => $totalIncome - $totalExpense,

            'totalAssets' => DB::table('general_ledger')
                ->leftJoin('accounts', 'accounts.id', '=', 'general_ledger.account_id')
                ->leftJoin('account_types', 'account_types.id', '=', 'accounts.type_id')
                ->leftJoin('account_categories', 'account_categories.id', '=', 'account_types.category_id')
                ->where('account_categories.id', 1) // Kategori Aset (Lancar, Tetap, Lainnya)
                ->select(DB::raw('COALESCE(SUM(general_ledger.debit) - SUM(general_ledger.credit), 0) as amount'))
                ->first()->amount,

            'totalReceivables' => DB::table('general_ledger')
                ->leftJoin('accounts', 'accounts.id', '=', 'general_ledger.account_id')
                ->leftJoin('account_types', 'account_types.id', '=', 'accounts.type_id')
                ->leftJoin('account_categories', 'account_categories.id', '=', 'account_types.category_id')
                ->where('accounts.id', 3) // ID Account Type untuk Piutang
                ->select(DB::raw('COALESCE(SUM(general_ledger.debit) - SUM(general_ledger.credit), 0) as amount'))
                ->first()->amount,

            'totalPayables' => DB::table('general_ledger')
                ->leftJoin('accounts', 'accounts.id', '=', 'general_ledger.account_id')
                ->leftJoin('account_types', 'account_types.id', '=', 'accounts.type_id')
                ->leftJoin('account_categories', 'account_categories.id', '=', 'account_types.category_id')
                ->where('account_types.id', 18) // ID Account Type untuk Utang
                ->select(DB::raw('COALESCE(SUM(general_ledger.credit) - SUM(general_ledger.debit), 0) as amount'))
                ->first()->amount,
        ];

        return response()->json([
            'message' => 'Success',
            'statusCode' => 200,
            'data' => $summary,
        ], 200);
    }


    public function getBalanceSheets(Request $request) {
        $balanceSheet = [
            'assets' => DB::table('general_ledger')
                ->leftJoin('accounts', 'accounts.id', '=', 'general_ledger.account_id')
                ->leftJoin('account_types', 'account_types.id', '=', 'accounts.type_id')
                ->leftJoin('account_categories', 'account_categories.id', '=', 'account_types.category_id')
                ->select('accounts.name', DB::raw('SUM(general_ledger.debit) - SUM(general_ledger.credit) as amount'))
                ->where('account_categories.id', 1)
                ->groupBy('accounts.name')
                ->get(),

            'liabilities' => DB::table('general_ledger')
                ->leftJoin('accounts', 'accounts.id', '=', 'general_ledger.account_id')
                ->leftJoin('account_types', 'account_types.id', '=', 'accounts.type_id')
                ->leftJoin('account_categories', 'account_categories.id', '=', 'account_types.category_id')
                ->select('accounts.name', DB::raw('SUM(general_ledger.credit) - SUM(general_ledger.debit) as amount'))
                ->where('account_categories.id', 2)
                ->groupBy('accounts.name')
                ->get(),

            'equity' => DB::table('general_ledger')
                ->leftJoin('accounts', 'accounts.id', '=', 'general_ledger.account_id')
                ->leftJoin('account_types', 'account_types.id', '=', 'accounts.type_id')
                ->leftJoin('account_categories', 'account_categories.id', '=', 'account_types.category_id')
                ->select('accounts.name', DB::raw('SUM(general_ledger.credit) - SUM(general_ledger.debit) as amount'))
                ->where('account_categories.id', 3)
                ->groupBy('accounts.name')
                ->get(),
        ];

        return response()->json([
            'message' => 'Success',
            'statusCode' => 200,
            'data' => $balanceSheet,
        ], 200);
    }

    public function getIncomeStatements(Request $request) {
        $incomeStatement = [
            'revenues' => DB::table('general_ledger')
                ->leftJoin('accounts', 'accounts.id', '=', 'general_ledger.account_id')
                ->leftJoin('account_types', 'account_types.id', '=', 'accounts.type_id')
                ->leftJoin('account_categories', 'account_categories.id', '=', 'account_types.category_id')
                ->select('accounts.name', DB::raw('SUM(general_ledger.credit) - SUM(general_ledger.debit) as amount'))
                ->where('account_categories.id', 4)
                ->groupBy('accounts.name')
                ->get(),

            'expenses' => DB::table('general_ledger')
                ->leftJoin('accounts', 'accounts.id', '=', 'general_ledger.account_id')
                ->leftJoin('account_types', 'account_types.id', '=', 'accounts.type_id')
                ->leftJoin('account_categories', 'account_categories.id', '=', 'account_types.category_id')
                ->select('accounts.name', DB::raw('SUM(general_ledger.debit) - SUM(general_ledger.credit) as amount'))
                ->where('account_categories.id', 5)
                ->groupBy('accounts.name')
                ->get(),
        ];

        $totalRevenue = $incomeStatement['revenues']->sum('amount');
        $totalExpense = $incomeStatement['expenses']->sum('amount');
        $netProfit = $totalRevenue - $totalExpense;

        $incomeStatement['net_profit'] = [
            'name' => 'Laba Bersih',
            'amount' => $netProfit
        ];

        return response()->json([
            'message' => 'Success',
            'statusCode' => 200,
            'data' => $incomeStatement,
        ], 200);
    }

    public function getCashflowStatements(Request $request){
        $cashflows = DB::table('general_ledger as gl')
            ->join('accounts as a', 'gl.account_id', '=', 'a.id')
            ->join('account_types as at', 'a.type_id', '=', 'at.id')
            ->join('account_categories as ac', 'at.category_id', '=', 'ac.id')
            ->select(
                'ac.id as kategori_cash_flow_id',
                'ac.name as kategori_cash_flow',
                DB::raw("
                    CASE
                        WHEN ac.id IN (4, 5, 9, 10, 11, 12) THEN 'Operating Cash Flow'
                        WHEN ac.id IN (2, 3) THEN 'Investing Cash Flow'
                        WHEN ac.id IN (1, 6, 7, 8) THEN 'Financing Cash Flow'
                        ELSE 'Other'
                    END AS category_type
                "),
                'a.name as nama_akun',
                'gl.description as deskripsi_transaksi',
                DB::raw('SUM(gl.debit) as kas_masuk'),
                DB::raw('SUM(gl.credit) as kas_keluar'),
                DB::raw('(SUM(gl.debit) - SUM(gl.credit)) as saldo')
            )
            ->groupBy('ac.id', 'ac.name', 'a.name', 'gl.description')
            ->orderByRaw("
                CASE
                    WHEN ac.id IN (4, 5, 9, 10, 11, 12) THEN 1
                    WHEN ac.id IN (2, 3) THEN 2
                    WHEN ac.id IN (1, 6, 7, 8) THEN 3
                    ELSE 4
                END
            ")
            ->orderBy('ac.id')
            ->orderBy('a.name')
            ->get();

        return response()->json([
            'message' => 'Success',
            'statusCode' => 200,
            'data' => $cashflows,
        ], 200);
    }

}
