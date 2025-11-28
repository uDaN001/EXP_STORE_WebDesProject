@extends('layouts.app')

@section('title', 'Admin Dashboard - EXP GAME STORE')

@section('content')
<div class="container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h1 class="section-title">ADMIN DASHBOARD</h1>
        <div style="display: flex; gap: 1rem;">
            <a href="{{ route('admin.games') }}" class="btn btn-primary">Manage Games</a>
            <a href="{{ route('admin.logout') }}" class="btn btn-danger">Logout</a>
        </div>
    </div>
    
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
        <div style="background: rgba(0,0,0,0.3); padding: 1.5rem; border-radius: 10px;">
            <h3 style="font-size: 0.875rem; color: #ccc; margin-bottom: 0.5rem;">Total Games</h3>
            <div style="font-size: 2.5rem; font-weight: 700;">{{ $totalGames }}</div>
        </div>
        
        <div style="background: rgba(0,0,0,0.3); padding: 1.5rem; border-radius: 10px;">
            <h3 style="font-size: 0.875rem; color: #ccc; margin-bottom: 0.5rem;">Total Orders</h3>
            <div style="font-size: 2.5rem; font-weight: 700;">{{ $totalOrders }}</div>
        </div>
        
        <div style="background: rgba(0,0,0,0.3); padding: 1.5rem; border-radius: 10px;">
            <h3 style="font-size: 0.875rem; color: #ccc; margin-bottom: 0.5rem;">Total Customers</h3>
            <div style="font-size: 2.5rem; font-weight: 700;">{{ $totalCustomers }}</div>
        </div>
        
        <div style="background: rgba(0,0,0,0.3); padding: 1.5rem; border-radius: 10px;">
            <h3 style="font-size: 0.875rem; color: #ccc; margin-bottom: 0.5rem;">Games on Sale</h3>
            <div style="font-size: 2.5rem; font-weight: 700;">{{ $gamesOnSale }}</div>
        </div>
    </div>
    
    <div style="text-align: center; margin-top: 2rem;">
        <a href="{{ route('admin.games') }}" class="btn btn-primary" style="font-size: 1.2rem; padding: 1rem 2rem;">Manage Games</a>
    </div>
</div>
@endsection

