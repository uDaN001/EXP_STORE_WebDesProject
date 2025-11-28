@extends('layouts.app')

@section('title', 'Customers - EXP GAME STORE')

@section('content')
<div class="container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h1 class="section-title">CUSTOMERS</h1>
        <a href="{{ route('customers.create') }}" class="btn btn-primary">Add New Customer</a>
    </div>
    
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($customers as $customer)
                <tr>
                    <td>{{ $customer->id }}</td>
                    <td>{{ $customer->username }}</td>
                    <td>{{ $customer->full_name }}</td>
                    <td>{{ $customer->email }}</td>
                    <td>{{ $customer->phone ?? 'N/A' }}</td>
                    <td>
                        <div style="display: flex; gap: 0.5rem;">
                            <a href="{{ route('customers.show', $customer->id) }}" class="btn btn-primary" style="padding: 0.5rem 1rem; font-size: 0.875rem; text-decoration: none;">View</a>
                            <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-primary" style="padding: 0.5rem 1rem; font-size: 0.875rem; text-decoration: none;">Edit</a>
                            <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" style="padding: 0.5rem 1rem; font-size: 0.875rem;" onclick="return confirm('Are you sure you want to delete this customer?')">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center;">No customers found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    
    {{ $customers->links() }}
</div>
@endsection

