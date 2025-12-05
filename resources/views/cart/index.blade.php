@extends('layouts.app')

@section('title', 'EXP Game Store - Purchase')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/storefront.css') }}">
    <link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endpush

@section('content')
<section class="purchase-page">
    <h2 class="section-title">YOUR CART</h2>

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
                <!-- Cart Item Panel -->
                <div class="cart-item">
                    <div class="cart-item-panel">
                        <!-- Game Poster -->
                        @php
                            $consoleIcon = asset('css/assets/console_icon.jpg');
                            $gameImage = $game->poster_url ?: ($game->image_url ?: $consoleIcon);
                        @endphp
                        <img src="{{ $gameImage }}"
                            onerror="this.onerror=null; this.src='{{ $consoleIcon }}';" 
                             alt="{{ $game->title }}" class="game-poster">

                        <!-- Game Details -->
                        <div class="game-details">
                            <div class="title-row">
                                <h3 class="game-title">{{ $game->title }}</h3>

                                <div class="platform-icons">
                                    @if($game->platform)
                                        @php
                                            $platforms = explode(',', $game->platform);
                                        @endphp
                                        @foreach($platforms as $platform)
                                            @if(stripos(trim($platform), 'windows') !== false || stripos(trim($platform), 'Windows') !== false)
                                                <img src="{{ asset('css/assets/windows.png') }}" alt="Windows" class="platform">
                                            @endif
                                            @if(stripos(trim($platform), 'mac') !== false || stripos(trim($platform), 'apple') !== false || stripos(trim($platform), 'Apple') !== false || stripos(trim($platform), 'macOS') !== false)
                                                <img src="{{ asset('css/assets/apple.png') }}" alt="Apple" class="platform">
                                            @endif
                                        @endforeach
                                    @else
                                        <!-- Default platforms if none specified -->
                                        <img src="{{ asset('css/assets/windows.png') }}" alt="Windows" class="platform">
                                        <img src="{{ asset('css/assets/apple.png') }}" alt="Apple" class="platform">
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <!-- Price and Remove Button -->
                        <div class="price-controls">
                            <p class="price">${{ number_format($item['price'], 0) }}</p>
                            
                            <div class="remove-controls">
                                <a href="{{ route('cart.remove', $game->id) }}" style="text-decoration: none; color: white;">
                                    <button class="remove" type="button">Remove</button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach

        @php
            $vat = $subtotal * 0.10; // 10% VAT
            $total = $subtotal + $vat;
        @endphp

        <!-- Subtotal & Total -->
        <div class="totals">
            <div class="subtotal-row">
                <span>Subtotal:</span>
                <span>${{ number_format($subtotal, 0) }}</span>
            </div>

            <div class="totals-divider"></div>

            <div class="total-row">
                <span>Total (incl. VAT):</span>
                <span>${{ number_format($total, 0) }}</span>
            </div>
            <!-- VAT note under the total, left aligned -->
            <div class="vat-note">All prices include VAT where applicable</div>
        </div>

        <!-- Purchase Button -->
        @if(session('customer_id'))
            <form action="{{ route('orders.store') }}" method="POST" style="display: inline;">
                @csrf
                <input type="hidden" name="total_amount" value="{{ $total }}">
                <button type="submit" class="purchase-btn">Purchase</button>
            </form>
        @else
            <a href="{{ route('customers.login') }}" class="purchase-btn">Login to Purchase</a>
        @endif
    @else
        <div style="text-align: center; padding: 3rem; color: white; font-family: 'Orbitron', sans-serif;">
            <p style="font-size: 1.5rem;">Your cart is empty.</p>
            <a href="{{ route('home') }}" class="purchase-btn" style="margin-top: 1rem;">Continue Shopping</a>
        </div>
    @endif
</section>
@endsection
