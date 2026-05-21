<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;

class HomeController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        $branches = DB::table('branches')->get();

        if($user->group_id == 1){
            return view('modules.dashboards.management', compact('branches'));
        } elseif ($user->group_id == 10) {
            return view('modules.dashboards.store', compact('branches'));
        } else {
            return view('modules.dashboards.store', compact('branches'));
        }
    }
}
