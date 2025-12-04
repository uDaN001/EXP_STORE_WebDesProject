@extends('layouts.app')

@section('title', 'Orders - EXP GAME STORE')

@section('content')
    <div class="container">
        <h1 class="section-title">ORDERS</h1>

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Customer</th>
                    <th>Total Amount</th>
                    <th>Payment Method</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->customer->full_name ?? $order->customer->username }}</td>
                        <td>₱ {{ number_format($order->total_amount, 2) }}</td>
                        <td>{{ $order->payment_method ?? 'N/A' }}</td>
                        <td>
                            <span style="padding: 0.25rem 0.5rem; border-radius: 4px; background: 
                                    @if($order->status == 'completed') rgba(0,255,0,0.2)
                                    @elseif($order->status == 'cancelled') rgba(255,0,0,0.2)
                                    @else rgba(255,255,0,0.2)
                                    @endif">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td>{{ $order->created_at->format('M d, Y') }}</td>
                        <td>
                            <div style="display: flex; gap: 0.5rem;">
                                <a href="{{ route('orders.show', $order->id) }}" class="btn btn-primary"
                                    style="padding: 0.5rem 1rem; font-size: 0.875rem; text-decoration: none;">View</a>
                                @if(auth()->check())
                                    <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-primary"
                                        style="padding: 0.5rem 1rem; font-size: 0.875rem; text-decoration: none;">Edit</a>
                                    <form action="{{ route('orders.destroy', $order->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger"
                                            style="padding: 0.5rem 1rem; font-size: 0.875rem;"
                                            onclick="return confirm('Are you sure you want to delete this order?')">Delete</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center;">No orders found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $orders->links() }}
    </div>
@endsection