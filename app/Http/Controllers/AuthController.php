<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('customers.login');
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $customer = Customer::where('username', $request->username)->first();

        if ($customer && Hash::check($request->password, $customer->password)) {
            session(['customer_id' => $customer->id]);
            session(['customer_name' => $customer->full_name ?? $customer->username]);
            
            return redirect()->route('home')->with('success', 'Welcome back, ' . ($customer->full_name ?? $customer->username) . '!');
        }

        return back()->with('error', 'Invalid credentials.')->withInput();
    }

    public function logout()
    {
        session()->forget(['customer_id', 'customer_name']);
        return redirect()->route('home')->with('success', 'You have been logged out.');
    }
}

