@extends('layouts.app')

@section('title', 'Games - EXP GAME STORE')

@section('content')
<div class="container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h1 class="section-title">GAMES</h1>
        <a href="{{ route('games.create') }}" class="btn btn-primary">Add New Game</a>
    </div>
    
    @if(request('category'))
        <p style="margin-bottom: 1rem;">Filtering by category: <strong>{{ request('category') }}</strong></p>
    @endif
    
    <div class="games-grid">
        @forelse($games as $game)
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
                    @if($game->genre)
                        <div style="font-size: 0.875rem; color: #ccc; margin-top: 0.5rem;">{{ $game->genre }}</div>
                    @endif
                </div>
            </div>
        @empty
            <p>No games found.</p>
        @endforelse
    </div>
    
    {{ $games->links() }}
</div>
@endsection

