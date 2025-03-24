<?php

namespace App\Http\Controllers\Dashboards;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DB;

class GeneralDashboardController extends Controller
{
    public function index(){
        return view('home');
    }

    public function getTransactionSummary(Request $request){
        $summary = DB::select("
            SELECT
                COUNT(DISTINCT transactions.id) AS total_transactions,
                COALESCE(SUM(transactions.total_amount), 0) AS total_omzet
            FROM transactions
            WHERE DATE_TRUNC('month', transactions.transaction_date) = DATE_TRUNC('month', CURRENT_DATE)
        ");

        // Format angka ke ribuan
        $formattedSummary = [
            'total_transactions' => number_format($summary[0]->total_transactions, 0, '.', ','),
            'total_omzet' => number_format($summary[0]->total_omzet, 0, '.', ',')
        ];

        return response()->json($formattedSummary);
    }

    public function getWeeklySales(Request $request)
    {
        $sales = DB::select("
            SELECT
                branches.name AS branch_name,
                week_numbers.week_number,
                COALESCE(SUM(transactions.total_amount), 0) AS total_sales
            FROM branches
            CROSS JOIN (
                SELECT 1 AS week_number UNION ALL
                SELECT 2 UNION ALL
                SELECT 3 UNION ALL
                SELECT 4
            ) AS week_numbers
            LEFT JOIN transactions
                ON branches.id = transactions.branch_id
                AND EXTRACT(WEEK FROM transactions.transaction_date) - EXTRACT(WEEK FROM DATE_TRUNC('month', transactions.transaction_date)) + 1 = week_numbers.week_number
                AND DATE_TRUNC('month', transactions.transaction_date) = DATE_TRUNC('month', CURRENT_DATE)
            GROUP BY branches.name, week_numbers.week_number
            ORDER BY branches.name, week_numbers.week_number
        ");

        $formattedData = [];
        foreach ($sales as $row) {
            if (!isset($formattedData[$row->branch_name])) {
                $formattedData[$row->branch_name] = [0, 0, 0, 0];
            }
            $formattedData[$row->branch_name][$row->week_number - 1] = (int) $row->total_sales;
        }

        $seriesData = [];
        foreach ($formattedData as $branch => $data) {
            $seriesData[] = [
                'name' => $branch,
                'data' => $data
            ];
        }

        return response()->json($seriesData);
    }

    public function topSellingProducts(Request $request){
        $topProducts = DB::select("
            SELECT
                products.id,
                products.name,
                SUM(transaction_items.quantity) AS sold_qty
            FROM transaction_items
            JOIN products ON products.id = transaction_items.product_id
            JOIN transactions ON transactions.id = transaction_items.transaction_id
            WHERE DATE_TRUNC('month', transactions.transaction_date) = DATE_TRUNC('month', CURRENT_DATE)
            GROUP BY products.id, products.name
            ORDER BY sold_qty DESC
            LIMIT 10;
        ");

        $chartData = [
            "name" => "Produk",
            "colorByPoint" => true,
            "data" => array_map(function ($product) {
                return [
                    "name" => $product->name,
                    "y" => (int) $product->sold_qty
                ];
            }, $topProducts)
        ];

        return response()->json([$chartData]);
    }
}
