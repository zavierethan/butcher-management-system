<?php

namespace App\Http\Controllers\Procurements;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DB;

class GoodsReceiveController extends Controller
{
    public function index() {
        return view('modules.procurements.goods-receive.index');
    }

    public function create() {
        $purchaseOrders = DB::table('purchase_orders')->where('status', 'pending')->get();
        return view('modules.procurements.goods-receive.create', compact('purchaseOrders'));
    }
}
