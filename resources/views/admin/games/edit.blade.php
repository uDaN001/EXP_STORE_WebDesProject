@extends('layouts.app')

@section('title', 'Edit Game - Admin')

@section('content')
<div class="container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h1 class="section-title">EDIT GAME</h1>
        <a href="{{ route('admin.games') }}" class="btn" style="background: #666; text-decoration: none;">Back to Games</a>
    </div>
    
    <form action="{{ route('admin.games.update', $game->id) }}" method="POST" style="max-width: 800px;">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label>Title *</label>
            <input type="text" name="title" value="{{ old('title', $game->title) }}" required>
        </div>
        
        <div class="form-group">
            <label>Genre</label>
            <input type="text" name="genre" value="{{ old('genre', $game->genre) }}" placeholder="e.g., Action, RPG, Strategy">
        </div>
        
        <div class="form-group">
            <label>Platform</label>
            <input type="text" name="platform" value="{{ old('platform', $game->platform) }}" placeholder="e.g., Windows, macOS, PlayStation (comma-separated)">
        </div>
        
        <div class="form-group">
            <label>Developer</label>
            <input type="text" name="developer" value="{{ old('developer', $game->developer) }}">
        </div>
        
        <div class="form-group">
            <label>Publisher</label>
            <input type="text" name="publisher" value="{{ old('publisher', $game->publisher) }}">
        </div>
        
        <div class="form-group">
            <label>Release Date</label>
            <input type="date" name="release_date" value="{{ old('release_date', $game->release_date) }}">
        </div>
        
        <div class="form-group">
            <label>Price *</label>
            <input type="number" name="price" step="0.01" min="0" value="{{ old('price', $game->price) }}" required>
        </div>
        
        <div class="form-group">
            <label style="display: flex; align-items: center; gap: 0.5rem;">
                <input type="checkbox" name="is_on_sale" value="1" {{ old('is_on_sale', $game->is_on_sale) ? 'checked' : '' }} style="width: auto;">
                <span>Put this game on sale</span>
            </label>
        </div>
        
        <div class="form-group">
            <label>Sale Percentage (%)</label>
            <input type="number" name="sale_percentage" step="0.01" min="0" max="100" value="{{ old('sale_percentage', $game->sale_percentage) }}" placeholder="e.g., 25 for 25% off">
            <small style="color: #ccc; font-size: 0.875rem;">Enter a percentage (0-100). Only applies if "Put this game on sale" is checked.</small>
        </div>
        
        <div class="form-group">
            <label>Stock *</label>
            <input type="number" name="stock" min="0" value="{{ old('stock', $game->stock) }}" required>
        </div>
        
        <div class="form-group">
            <label>Description</label>
            <textarea name="description" rows="5">{{ old('description', $game->description) }}</textarea>
        </div>
        
        <div class="form-group">
            <label>Image URL</label>
            <input type="url" name="image_url" value="{{ old('image_url', $game->image_url) }}" placeholder="https://example.com/image.jpg">
        </div>
        
        <div class="form-group">
            <label>Rating (0-10)</label>
            <input type="number" name="rating" step="0.1" min="0" max="10" value="{{ old('rating', $game->rating) }}">
        </div>
        
        <div style="display: flex; gap: 1rem;">
            <button type="submit" class="btn btn-primary">Update Game</button>
            <a href="{{ route('admin.games') }}" class="btn" style="background: #666; text-decoration: none;">Cancel</a>
        </div>
    </form>
</div>
@endsection

