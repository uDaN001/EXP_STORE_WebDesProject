<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::paginate(15);
        return view('customers.index', compact('customers'));
    }
    
    /**
     * Show the form for creating a new customer.
     */
    public function create()
    {
        return view('customers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:255|unique:customers',
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers',
            'password' => 'required|string|min:6',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
        ]);

        $validated['password'] = bcrypt($validated['password']);
        $customer = Customer::create($validated);

        // If coming from signup form on login page, auto-login
        if ($request->has('from_signup') && $request->from_signup == '1') {
            session(['customer_id' => $customer->id]);
            session(['customer_name' => $customer->full_name ?? $customer->username]);
            return redirect()->route('home')->with('success', 'Account created successfully! Welcome, ' . ($customer->full_name ?? $customer->username) . '!');
        }

        return redirect()->route('customers.show', $customer->id)
            ->with('success', 'Customer created successfully.');
    }

    public function show(Customer $customer)
    {
        return view('customers.show', compact('customer'));
    }
    
    /**
     * Show the form for editing the specified customer.
     */
    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'username' => 'sometimes|string|max:255|unique:customers,username,' . $customer->id,
            'full_name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:customers,email,' . $customer->id,
            'password' => 'nullable|string|min:6',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
        ]);

        if (isset($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        }

        $customer->update($validated);

        return redirect()->route('customers.show', $customer->id)
            ->with('success', 'Customer updated successfully.');
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();
        return redirect()->route('customers.index')
            ->with('success', 'Customer deleted successfully.');
    }
}
