<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request){
        $request->validate([
            'name' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('name', 'password');

        // Fetch the user with the provided name
        $user = User::where('name', $credentials['name'])->first();

        if (!$user) {
            return redirect('/')->with('error', 'Invalid credentials');
        }

        // Check if the user is active
        if ($user->is_active === 0) {
            return redirect('/')->with('error', 'Your account is inactive. Please contact support.');
        }

        // Attempt authentication using name
        if (Auth::attempt($credentials)) {


            $user = Auth::user();

            if ($user->group_id == 10) {
                return redirect('/transactions');
            }

            return redirect()->route('dashboards.store');
        }

        return redirect('/')->with('error', 'Invalid credentials');
    }


    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
