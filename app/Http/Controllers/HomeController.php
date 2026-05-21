<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class HomeController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();

        if($user->group_id == 1){
            return view('modules.dashboards.management');
        } elseif ($user->group_id == 10) {
            return view('modules.dashboards.store');
        } else {
            return view('modules.dashboards.store');
        }
    }
}
