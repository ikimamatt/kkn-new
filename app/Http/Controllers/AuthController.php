<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    // Constructor to apply middleware
    // public function __construct()
    // {
    //     $this->middleware('guest')->except('logout');  // Only allow guests (unauthenticated users) to access login
    // }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Redirect based on user role
            if ($user->role === 'superadmin') {
                return redirect()->route('superadmin.dashboard');
            } elseif ($user->role === 'administrator') {
                return redirect()->route('administrator.dashboard');
            } elseif ($user->role === 'warga') {
                return redirect()->route('warga.dashboard');
            }

            // Default redirect if role is not recognized
            return redirect()->intended('/dashboard');
        }

        // If credentials are invalid, return with error
        return back()->withErrors(['email' => 'Invalid credentials']);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
