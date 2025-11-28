@extends('layouts.app')

@section('title', 'Admin Login - EXP GAME STORE')

@section('content')
<div style="display: flex; justify-content: center; align-items: center; min-height: calc(100vh - 80px);">
    <div style="background: var(--primary-red); padding: 3rem; border-radius: 10px; max-width: 400px; width: 100%;">
        <h1 style="font-size: 2.5rem; font-weight: 700; margin-bottom: 2rem; text-align: center;">ADMIN LOGIN</h1>
        
        <form action="{{ route('admin.authenticate') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required>
            </div>
            
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            
            <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 1rem;">Login</button>
        </form>
        
        <div style="text-align: center; margin-top: 1.5rem;">
            <a href="{{ route('home') }}" style="color: white; text-decoration: underline;">Back to Store</a>
        </div>
    </div>
</div>
@endsection

