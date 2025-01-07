<?php

namespace App\Http\Controllers\Procurements;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DB;

class PurchaseOrderController extends Controller
{
    public function index() {
        return view('modules.procurements.purchase-order.index');
    }
}
