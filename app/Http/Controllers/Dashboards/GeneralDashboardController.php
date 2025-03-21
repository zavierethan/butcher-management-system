<?php

namespace App\Http\Controllers\Dashborads;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GeneralDashboardController extends Controller
{
    public function index(){
        return view('home');
    }
}
