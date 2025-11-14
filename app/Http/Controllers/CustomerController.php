<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        return response()->json(Customer::all());
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

        return response()->json($customer, 201);
    }

    public function show(Customer $customer)
    {
        return response()->json($customer);
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

        return response()->json($customer);
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();
        return response()->json(['message' => 'Customer deleted successfully']);
    }
}
