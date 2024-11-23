<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class AuthController extends Controller
{
    public function login(Request $request) {

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            // Authentication passed, send JSON response
            return response()->json(['message' => 'Login successful']);
        }

        // Authentication failed
        return response()->json(['error' => 'Invalid credentials'], 401);
    }

    public function logout() {
        Auth::logout();
        return redirect('/login');
    }
}
