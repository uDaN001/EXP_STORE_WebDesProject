@extends('layouts.app')

@section('title', 'Edit Customer - EXP GAME STORE')

@section('content')
<div class="container">
    <h1 class="section-title">Edit Customer</h1>
    
    <form action="{{ route('customers.update', $customer->id) }}" method="POST" style="max-width: 600px;">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label>Username *</label>
            <input type="text" name="username" value="{{ old('username', $customer->username) }}" required>
        </div>
        
        <div class="form-group">
            <label>Full Name *</label>
            <input type="text" name="full_name" value="{{ old('full_name', $customer->full_name) }}" required>
        </div>
        
        <div class="form-group">
            <label>Email *</label>
            <input type="email" name="email" value="{{ old('email', $customer->email) }}" required>
        </div>
        
        <div class="form-group">
            <label>Password (leave blank to keep current)</label>
            <input type="password" name="password">
        </div>
        
        <div class="form-group">
            <label>Phone</label>
            <input type="text" name="phone" value="{{ old('phone', $customer->phone) }}">
        </div>
        
        <div class="form-group">
            <label>Address</label>
            <textarea name="address" rows="3">{{ old('address', $customer->address) }}</textarea>
        </div>
        
        <div style="display: flex; gap: 1rem;">
            <button type="submit" class="btn btn-primary">Update Customer</button>
            <a href="{{ route('customers.index') }}" class="btn" style="background: #666; text-decoration: none;">Cancel</a>
        </div>
    </form>
</div>
@endsection

