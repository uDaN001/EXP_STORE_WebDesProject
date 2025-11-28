@extends('layouts.app')

@section('title', 'Login - EXP GAME STORE')

@section('content')
<div style="display: flex; min-height: calc(100vh - 80px);">
    <!-- Login Section -->
    <div style="flex: 2; padding: 3rem; background: var(--primary-red);">
        <h1 style="font-size: 3rem; font-weight: 700; margin-bottom: 2rem;">LOGIN</h1>
        <p style="color: #ccc; margin-bottom: 1rem; font-size: 0.875rem;">For admin access, please use the <a href="{{ route('admin.login') }}" style="color: white; text-decoration: underline;">Admin Login</a> page.</p>
        
        <form action="{{ route('customers.authenticate') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" value="{{ old('username') }}" required>
            </div>
            
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            
            <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 1rem;">Login</button>
        </form>
    </div>
    
    <!-- Sign Up Section -->
    <div style="flex: 1; padding: 3rem; background: var(--dark-red);">
        <h1 style="font-size: 2rem; font-weight: 700; margin-bottom: 1rem;">
            Join the <span style="color: var(--primary-red);">EXP</span> Family
        </h1>
        <p style="color: #ccc; margin-bottom: 2rem;">Leading games retailer in the Philippines!</p>
        
        <form action="{{ route('customers.store') }}" method="POST">
            @csrf
            <input type="hidden" name="from_signup" value="1">
            
            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="full_name" value="{{ old('full_name') }}" required>
            </div>
            
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" value="{{ old('username') }}" required>
            </div>
            
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required>
            </div>
            
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            
            <button type="submit" class="btn" style="width: 100%; background: white; color: var(--primary-red); border: 2px solid var(--primary-red);">Sign Up</button>
        </form>
    </div>
</div>
@endsection

