@extends('layouts.app')

@section('title', 'EXP GAME STORE - Home')

@section('content')
<div class="container">
    <h1 class="section-title">POPULAR GAMES</h1>
    <div class="games-grid">
        @forelse($popularGames as $game)
            <div class="game-card" onclick="window.location='{{ route('games.show', $game->id) }}'">
                @if($game->image_url)
                    <img src="{{ $game->image_url }}" alt="{{ $game->title }}">
                @else
                    <img src="https://via.placeholder.com/200x250?text={{ urlencode($game->title) }}" alt="{{ $game->title }}">
                @endif
                <div class="game-card-info">
                    <div class="game-card-title">{{ $game->title }}</div>
                    @if($game->is_on_sale && $game->sale_percentage)
                        <div style="text-decoration: line-through; color: #999; font-size: 0.875rem;">₱ {{ number_format($game->price, 2) }}</div>
                        <div class="game-card-price" style="color: #ff6b6b;">₱ {{ number_format($game->sale_price, 2) }}</div>
                        <div style="color: #ff6b6b; font-size: 0.875rem; font-weight: 600;">{{ $game->sale_percentage }}% OFF</div>
                    @else
                        <div class="game-card-price">₱ {{ number_format($game->price, 2) }}</div>
                    @endif
                </div>
            </div>
        @empty
            <p>No popular games available.</p>
        @endforelse
    </div>

    <h1 class="section-title">BROWSE BY CATEGORY</h1>
    <div class="category-buttons">
        @foreach($categories as $category)
            <a href="{{ route('games.index', ['category' => $category]) }}" class="category-btn">
                {{ $category }}
            </a>
        @endforeach
    </div>

    <h1 class="section-title">GAMES ON SALE</h1>
    <div class="games-grid">
        @forelse($saleGames as $game)
            <div class="game-card" onclick="window.location='{{ route('games.show', $game->id) }}'">
                @if($game->image_url)
                    <img src="{{ $game->image_url }}" alt="{{ $game->title }}">
                @else
                    <img src="https://via.placeholder.com/200x250?text={{ urlencode($game->title) }}" alt="{{ $game->title }}">
                @endif
                <div class="game-card-info">
                    <div class="game-card-title">{{ $game->title }}</div>
                    @if($game->is_on_sale && $game->sale_percentage)
                        <div style="text-decoration: line-through; color: #999; font-size: 0.875rem;">₱ {{ number_format($game->price, 2) }}</div>
                        <div class="game-card-price" style="color: #ff6b6b;">₱ {{ number_format($game->sale_price, 2) }}</div>
                        <div style="color: #ff6b6b; font-size: 0.875rem; font-weight: 600;">{{ $game->sale_percentage }}% OFF</div>
                    @else
                        <div class="game-card-price">₱ {{ number_format($game->price, 2) }}</div>
                    @endif
                </div>
            </div>
        @empty
            <p>No games on sale at the moment.</p>
        @endforelse
    </div>
</div>
@endsection

