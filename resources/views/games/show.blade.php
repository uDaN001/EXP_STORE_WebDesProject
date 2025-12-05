@extends('layouts.app')

@section('title', $game->title . ' - EXP GAME STORE')

@section('content')
<div class="container">
    <div style="display: flex; gap: 2rem; margin-bottom: 2rem;">
        <div style="flex-shrink: 0;">
            @php
                $consoleIcon = asset('css/assets/console_icon.jpg');
                $gameImage = !empty($game->image_url) ? $game->image_url : $consoleIcon;
            @endphp
            <img src="{{ $gameImage }}" alt="{{ $game->title }}" 
                style="width: 300px; height: 400px; object-fit: cover; border-radius: 10px;"
                onerror="this.onerror=null; this.src='{{ $consoleIcon }}';">
        </div>
        
        <div style="flex: 1;">
            <h1 style="font-size: 2.5rem; font-weight: 700; margin-bottom: 1rem;">{{ $game->title }}</h1>
            
            @if($game->platform)
                <div style="display: flex; gap: 0.5rem; margin-bottom: 1rem;">
                    @foreach(explode(',', $game->platform) as $platform)
                        <span style="background: rgba(255,255,255,0.2); padding: 0.5rem 1rem; border-radius: 8px;">{{ trim($platform) }}</span>
                    @endforeach
                </div>
            @endif
            
            <div style="margin: 1.5rem 0;">
                @if($game->is_on_sale && $game->sale_percentage)
                    <div style="text-decoration: line-through; color: #999; font-size: 1.2rem;">$ {{ number_format($game->price, 2) }}</div>
                    <div style="font-size: 2rem; font-weight: 700; color: #ff6b6b;">$ {{ number_format($game->sale_price, 2) }}</div>
                    <div style="color: #ff6b6b; font-size: 1rem; font-weight: 600; margin-top: 0.5rem;">{{ $game->sale_percentage }}% OFF</div>
                @else
                    <div style="font-size: 2rem; font-weight: 700;">$ {{ number_format($game->price, 2) }}</div>
                @endif
            </div>
            
            @if($game->description)
                <div style="margin: 1.5rem 0; line-height: 1.6;">
                    <h3 style="margin-bottom: 0.5rem;">Description</h3>
                    <p>{{ $game->description }}</p>
                </div>
            @endif
            
            <div style="margin: 1.5rem 0;">
                @if($game->genre)
                    <p><strong>Genre:</strong> {{ $game->genre }}</p>
                @endif
                @if($game->developer)
                    <p><strong>Developer:</strong> {{ $game->developer }}</p>
                @endif
                @if($game->publisher)
                    <p><strong>Publisher:</strong> {{ $game->publisher }}</p>
                @endif
                @if($game->release_date)
                    <p><strong>Release Date:</strong> {{ \Carbon\Carbon::parse($game->release_date)->format('F d, Y') }}</p>
                @endif
                @if($game->rating)
                    <p><strong>Rating:</strong> {{ $game->rating }}/10</p>
                @endif
                <p><strong>Stock:</strong> {{ $game->stock }}</p>
            </div>
            
            <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                @if($game->stock > 0)
                    <a href="{{ route('cart.add', $game->id) }}" class="btn btn-primary">Add to Cart</a>
                @else
                    <button class="btn" style="background: #666; cursor: not-allowed;" disabled>Out of Stock</button>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

