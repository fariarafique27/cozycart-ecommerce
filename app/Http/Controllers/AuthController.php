<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;

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

        // Retrieve only the validated, clean data
        $validated = $request->validated();

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
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
        if (Auth::attempt($request->validated())) {
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