@extends('layouts.app')

@section('title', 'Purchase Complete - EXP GAME STORE')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endpush

@section('content')
    <div
        style="min-height: calc(100vh - 200px); display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 40px; text-align: center;">
        <div style="background: rgba(217, 217, 217, 0.4); border-radius: 15px; padding: 60px 80px; max-width: 800px;">
            <h1
                style="font-family: 'Orbitron', sans-serif; font-size: 72px; font-weight: 700; color: #DB0000; margin-bottom: 30px;">
                PURCHASE COMPLETE
            </h1>

            <div style="font-family: 'Orbitron', sans-serif; font-size: 24px; color: white; margin-bottom: 40px;">
                <p>Thank you for your purchase!</p>
                <p style="margin-top: 20px;">Order #{{ $order->id }}</p>
                <p style="margin-top: 10px;">Total: ${{ number_format($order->total_amount, 2) }}</p>
            </div>

            <div style="margin-top: 40px;">
                <a href="{{ route('home') }}" class="purchase-btn"
                    style="text-decoration: none; display: inline-block; padding: 15px 40px; font-size: 36px; font-weight: 700; font-family: 'Orbitron', sans-serif; border-radius: 15px; background: white; color: #DB0000; border: none; cursor: pointer; transition: all 0.3s ease;">
                    Return to Home
                </a>
                <a href="{{ route('orders.index') }}" class="purchase-btn"
                    style="text-decoration: none; display: inline-block; padding: 15px 40px; font-size: 36px; font-weight: 700; font-family: 'Orbitron', sans-serif; border-radius: 15px; background: #DB0000; color: white; border: none; cursor: pointer; transition: all 0.3s ease; margin-left: 20px;">
                    View Your Orders
                </a>
            </div>
        </div>
    </div>
@endsection