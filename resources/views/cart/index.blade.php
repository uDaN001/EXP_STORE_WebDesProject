@extends('layouts.app')

@section('title', 'Shopping Cart - EXP GAME STORE')

@section('content')
<div class="container">
    <h1 class="section-title">Shopping Cart</h1>
    
    @if(session('cart') && count(session('cart')) > 0)
        @php
            $cart = session('cart');
            $subtotal = 0;
        @endphp
        
        @foreach($cart as $item)
            @php
                $game = \App\Models\Game::find($item['game_id']);
                $itemTotal = $item['quantity'] * $item['price'];
                $subtotal += $itemTotal;
            @endphp
            
            @if($game)
                <div style="background: var(--light-red); padding: 1.5rem; border-radius: 10px; margin-bottom: 1rem; display: flex; gap: 1.5rem; align-items: center;">
                    <div style="flex-shrink: 0;">
                        @if($game->image_url)
                            <img src="{{ $game->image_url }}" alt="{{ $game->title }}" style="width: 150px; height: 200px; object-fit: cover; border-radius: 8px;">
                        @else
                            <img src="https://via.placeholder.com/150x200?text={{ urlencode($game->title) }}" alt="{{ $game->title }}" style="width: 150px; height: 200px; object-fit: cover; border-radius: 8px;">
                        @endif
                    </div>
                    
                    <div style="flex: 1;">
                        <h2 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 0.5rem;">{{ $game->title }}</h2>
                        <div style="display: flex; gap: 0.5rem; margin-bottom: 1rem;">
                            @if($game->platform)
                                @foreach(explode(',', $game->platform) as $platform)
                                    <span style="background: rgba(255,255,255,0.2); padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 0.875rem;">{{ trim($platform) }}</span>
                                @endforeach
                            @endif
                        </div>
                        <div style="display: flex; gap: 1rem; align-items: center;">
                            <a href="{{ route('cart.add', $game->id) }}" style="color: white; text-decoration: underline;">Add</a>
                            <span>|</span>
                            <a href="{{ route('cart.remove', $game->id) }}" style="color: white; text-decoration: underline;">Remove</a>
                        </div>
                    </div>
                    
                    <div style="text-align: right;">
                        <div style="font-size: 1.5rem; font-weight: 700; margin-bottom: 0.5rem;">₱ {{ number_format($item['price'], 2) }}</div>
                        <div style="color: #ccc;">Quantity: {{ $item['quantity'] }}</div>
                    </div>
                </div>
            @endif
        @endforeach
        
        <div style="margin-top: 2rem; padding: 1.5rem; background: rgba(0,0,0,0.3); border-radius: 10px;">
            <div style="display: flex; justify-content: space-between; padding: 0.5rem 0; border-bottom: 1px solid rgba(255,255,255,0.2);">
                <span>Subtotal:</span>
                <span>₱ {{ number_format($subtotal, 2) }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; padding: 0.5rem 0; font-size: 1.2rem; font-weight: 700;">
                <span>Total:</span>
                <span>₱ {{ number_format($subtotal, 2) }}</span>
            </div>
            <p style="margin-top: 1rem; font-size: 0.875rem; color: #ccc;">All prices include VAT where applicable</p>
            
            @if(session('customer_id'))
                <form action="{{ route('orders.store') }}" method="POST" style="margin-top: 1.5rem;">
                    @csrf
                    <input type="hidden" name="total_amount" value="{{ $subtotal }}">
                    <button type="submit" class="btn btn-primary" style="width: 100%; font-size: 1.1rem; padding: 1rem;">Purchase</button>
                </form>
            @else
                <a href="{{ route('customers.login') }}" class="btn btn-primary" style="width: 100%; font-size: 1.1rem; padding: 1rem; text-align: center; display: block; text-decoration: none;">Login to Purchase</a>
            @endif
        </div>
    @else
        <div style="text-align: center; padding: 3rem;">
            <p style="font-size: 1.5rem;">Your cart is empty.</p>
            <a href="{{ route('home') }}" class="btn btn-primary" style="margin-top: 1rem; text-decoration: none;">Continue Shopping</a>
        </div>
    @endif
</div>
@endsection

