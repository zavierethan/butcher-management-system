<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected function redirectTo()
    {
        $groupId = Auth::user()->group_id;

        switch ($groupId) {
            case 1:
                return '/dashboards/store'; // Redirect for group_id = 1
            case 2:
                return '/dashboards/store'; // Redirect for group_id = 2
            case 3:
                return '/dashboards/store'; // Redirect for group_id = 3
            default:
                return '/dashboards/store'; // Default redirect for other group_ids
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * Override the username method to use 'name' instead of 'email'.
     *
     * @return string
     */
    public function username()
    {
        return 'name';
    }
}
