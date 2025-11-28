@extends('layouts.app')

@section('title', 'Customer Details - EXP GAME STORE')

@section('content')
<div class="container">
    <h1 class="section-title">Customer Details</h1>
    
    <div style="background: rgba(0,0,0,0.3); padding: 2rem; border-radius: 10px; max-width: 600px;">
        <div style="margin-bottom: 1rem;">
            <strong>ID:</strong> {{ $customer->id }}
        </div>
        <div style="margin-bottom: 1rem;">
            <strong>Username:</strong> {{ $customer->username }}
        </div>
        <div style="margin-bottom: 1rem;">
            <strong>Full Name:</strong> {{ $customer->full_name }}
        </div>
        <div style="margin-bottom: 1rem;">
            <strong>Email:</strong> {{ $customer->email }}
        </div>
        @if($customer->phone)
            <div style="margin-bottom: 1rem;">
                <strong>Phone:</strong> {{ $customer->phone }}
            </div>
        @endif
        @if($customer->address)
            <div style="margin-bottom: 1rem;">
                <strong>Address:</strong> {{ $customer->address }}
            </div>
        @endif
        
        <div style="margin-top: 2rem; display: flex; gap: 1rem;">
            <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-primary" style="text-decoration: none;">Edit</a>
            <a href="{{ route('customers.index') }}" class="btn" style="background: #666; text-decoration: none;">Back to List</a>
        </div>
    </div>
</div>
@endsection

