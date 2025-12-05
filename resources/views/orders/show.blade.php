@extends('layouts.app')

@section('title', 'Order Details - EXP GAME STORE')

@section('content')
<div class="container">
    <h1 class="section-title">Order Details</h1>
    
    <div style="background: rgba(0,0,0,0.3); padding: 2rem; border-radius: 10px; margin-bottom: 2rem;">
        <h2 style="margin-bottom: 1rem;">Order #{{ $order->id }}</h2>
        <div style="margin-bottom: 0.5rem;"><strong>Customer:</strong> {{ $order->customer->full_name ?? $order->customer->username }}</div>
        <div style="margin-bottom: 0.5rem;"><strong>Total Amount:</strong> $ {{ number_format($order->total_amount, 2) }}</div>
        <div style="margin-bottom: 0.5rem;"><strong>Payment Method:</strong> {{ $order->payment_method ?? 'N/A' }}</div>
        <div style="margin-bottom: 0.5rem;"><strong>Status:</strong> {{ ucfirst($order->status) }}</div>
        <div style="margin-bottom: 0.5rem;"><strong>Date:</strong> {{ $order->created_at->format('F d, Y h:i A') }}</div>
    </div>
    
    <h2 style="margin-bottom: 1rem;">Order Items</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Game</th>
                <th>Quantity</th>
                <th>Price Each</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->orderItems as $item)
                <tr>
                    <td>{{ $item->game->title }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>$ {{ number_format($item->price_each, 2) }}</td>
                    <td>$ {{ number_format($item->quantity * $item->price_each, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
    <div style="margin-top: 2rem; display: flex; gap: 1rem;">
        <a href="{{ route('orders.index') }}" class="btn" style="background: #666; text-decoration: none;">Back to List</a>
    </div>
</div>
@endsection

