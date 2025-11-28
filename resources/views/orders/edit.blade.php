@extends('layouts.app')

@section('title', 'Edit Order - EXP GAME STORE')

@section('content')
<div class="container">
    <h1 class="section-title">Edit Order</h1>
    
    <form action="{{ route('orders.update', $order->id) }}" method="POST" style="max-width: 600px;">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label>Total Amount *</label>
            <input type="number" name="total_amount" step="0.01" min="0" value="{{ old('total_amount', $order->total_amount) }}" required>
        </div>
        
        <div class="form-group">
            <label>Payment Method</label>
            <input type="text" name="payment_method" value="{{ old('payment_method', $order->payment_method) }}">
        </div>
        
        <div class="form-group">
            <label>Status *</label>
            <select name="status" required>
                <option value="pending" {{ old('status', $order->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="paid" {{ old('status', $order->status) == 'paid' ? 'selected' : '' }}>Paid</option>
                <option value="shipped" {{ old('status', $order->status) == 'shipped' ? 'selected' : '' }}>Shipped</option>
                <option value="completed" {{ old('status', $order->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="cancelled" {{ old('status', $order->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
        </div>
        
        <div style="display: flex; gap: 1rem;">
            <button type="submit" class="btn btn-primary">Update Order</button>
            <a href="{{ route('orders.show', $order->id) }}" class="btn" style="background: #666; text-decoration: none;">Cancel</a>
        </div>
    </form>
</div>
@endsection

