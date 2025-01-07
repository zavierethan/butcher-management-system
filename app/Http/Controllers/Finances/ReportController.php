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
}
