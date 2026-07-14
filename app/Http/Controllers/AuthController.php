<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Show registration form
    public function showRegister()
    {
        return view('auth.register');
    }

    // Handle registration request
    public function register(Request $request)
    {
        $credentials = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        // Create the user (defaults to 'customer' role based on our migration)
        $user = User::create([
            'name' => $credentials['name'],
            'email' => $credentials['email'],
            'password' => Hash::make($credentials['password']),
        ]);

        // Log the new user in instantly
        Auth::login($user);
        $request->session()->regenerate();
        return redirect()->route('shop.index')->with('success', 'Welcome to CozyCart! 🧸');
       
    }

    // Show login form
    public function showLogin()
    {
        return view('auth.login');
    }

    // Handle login request
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Dynamic redirect based on our flexible role column 🎯
            if (Auth::user()->role === 'admin') {
                return redirect()->intended('/admin/dashboard');
            }

           return redirect()->route('shop.index');
        }

        // If credentials don't match
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    // Handle logout request
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

         return redirect('/')->with('success', 'Logged out successfully. See you soon!');
 
       // return redirect('/login')->with('success', 'Logged out successfully. See you soon!');
    }
}