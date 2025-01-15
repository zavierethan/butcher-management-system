<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;

class AuthController extends Controller
{
    // public function login(Request $request) {

    //     $credentials = $request->only('email', 'password');
    //     if (Auth::attempt($credentials)) {
    //         // Authentication passed, send JSON response
    //         return response()->json(['message' => 'Login successful']);
    //     }

    //     // Authentication failed
    //     return response()->json(['error' => 'Invalid credentials'], 401);
    // }

    // public function logout() {
    //     Auth::logout();
    //     return redirect('/login');
    // }

    public function login(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('name', 'password');

        // Fetch the user with the provided name
        $user = User::where('name', $credentials['name'])->first();

        if (!$user) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        // Check if the user is active
        if ($user->is_active === 0) {
            return response()->json(['error' => 'Your account is inactive. Please contact support.'], 403);
        }

        // Attempt authentication using name
        if (Auth::attempt($credentials)) {
            // return response()->json(['message' => 'Login successful']);
            return redirect()->route('home');
        }

        return response()->json(['error' => 'Invalid credentials'], 401);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
