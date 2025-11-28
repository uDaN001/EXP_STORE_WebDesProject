@extends('layouts.app')

@section('title', 'Add New Customer - EXP GAME STORE')

@section('content')
<div class="container">
    <h1 class="section-title">Add New Customer</h1>
    
    <form action="{{ route('customers.store') }}" method="POST" style="max-width: 600px;">
        @csrf
        
        <div class="form-group">
            <label>Username *</label>
            <input type="text" name="username" value="{{ old('username') }}" required>
        </div>
        
        <div class="form-group">
            <label>Full Name *</label>
            <input type="text" name="full_name" value="{{ old('full_name') }}" required>
        </div>
        
        <div class="form-group">
            <label>Email *</label>
            <input type="email" name="email" value="{{ old('email') }}" required>
        </div>
        
        <div class="form-group">
            <label>Password *</label>
            <input type="password" name="password" required>
        </div>
        
        <div class="form-group">
            <label>Phone</label>
            <input type="text" name="phone" value="{{ old('phone') }}">
        </div>
        
        <div class="form-group">
            <label>Address</label>
            <textarea name="address" rows="3">{{ old('address') }}</textarea>
        </div>
        
        <div style="display: flex; gap: 1rem;">
            <button type="submit" class="btn btn-primary">Create Customer</button>
            <a href="{{ route('customers.index') }}" class="btn" style="background: #666; text-decoration: none;">Cancel</a>
        </div>
    </form>
</div>
@endsection

