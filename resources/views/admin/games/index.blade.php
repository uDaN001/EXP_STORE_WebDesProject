@extends('layouts.app')

@section('title', 'Manage Games - Admin')

@section('content')
<div class="container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h1 class="section-title">MANAGE GAMES</h1>
        <div style="display: flex; gap: 1rem;">
            <a href="{{ route('admin.dashboard') }}" class="btn" style="background: #666; text-decoration: none;">Dashboard</a>
            <a href="{{ route('admin.games.create') }}" class="btn btn-primary">Add New Game</a>
        </div>
    </div>
    
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Title</th>
                <th>Price</th>
                <th>Sale</th>
                <th>Stock</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($games as $game)
                <tr>
                    <td>{{ $game->id }}</td>
                    <td>
                        @if($game->image_url)
                            <img src="{{ $game->image_url }}" alt="{{ $game->title }}" style="width: 60px; height: 80px; object-fit: cover; border-radius: 4px;">
                        @else
                            <div style="width: 60px; height: 80px; background: #333; border-radius: 4px; display: flex; align-items: center; justify-content: center; font-size: 0.75rem;">No Image</div>
                        @endif
                    </td>
                    <td>{{ $game->title }}</td>
                    <td>
                        @if($game->is_on_sale && $game->sale_percentage)
                            <div style="text-decoration: line-through; color: #999;">₱ {{ number_format($game->price, 2) }}</div>
                            <div style="color: #ff6b6b; font-weight: 700;">₱ {{ number_format($game->sale_price, 2) }}</div>
                            <div style="font-size: 0.875rem; color: #ff6b6b;">{{ $game->sale_percentage }}% OFF</div>
                        @else
                            <div>₱ {{ number_format($game->price, 2) }}</div>
                        @endif
                    </td>
                    <td>
                        @if($game->is_on_sale)
                            <span style="color: #4ade80;">✓ On Sale</span>
                        @else
                            <span style="color: #999;">Not on Sale</span>
                        @endif
                    </td>
                    <td>{{ $game->stock }}</td>
                    <td>
                        <div style="display: flex; gap: 0.5rem;">
                            <a href="{{ route('admin.games.edit', $game->id) }}" class="btn btn-primary" style="padding: 0.5rem 1rem; font-size: 0.875rem; text-decoration: none;">Edit</a>
                            <form action="{{ route('admin.games.delete', $game->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" style="padding: 0.5rem 1rem; font-size: 0.875rem;" onclick="return confirm('Are you sure you want to delete this game?')">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center;">No games found. <a href="{{ route('admin.games.create') }}">Add your first game</a></td>
                </tr>
            @endforelse
        </tbody>
    </table>
    
    {{ $games->links() }}
</div>
@endsection

