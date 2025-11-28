@extends('layouts.app')

@section('title', 'Add New Game - EXP GAME STORE')

@section('content')
<div class="container">
    <h1 class="section-title">Add New Game</h1>
    
    <form action="{{ route('games.store') }}" method="POST" style="max-width: 800px;">
        @csrf
        
        <div class="form-group">
            <label>Title *</label>
            <input type="text" name="title" value="{{ old('title') }}" required>
        </div>
        
        <div class="form-group">
            <label>Genre</label>
            <input type="text" name="genre" value="{{ old('genre') }}" placeholder="e.g., Action, RPG, Strategy">
        </div>
        
        <div class="form-group">
            <label>Platform</label>
            <input type="text" name="platform" value="{{ old('platform') }}" placeholder="e.g., Windows, macOS, PlayStation (comma-separated)">
        </div>
        
        <div class="form-group">
            <label>Developer</label>
            <input type="text" name="developer" value="{{ old('developer') }}">
        </div>
        
        <div class="form-group">
            <label>Publisher</label>
            <input type="text" name="publisher" value="{{ old('publisher') }}">
        </div>
        
        <div class="form-group">
            <label>Release Date</label>
            <input type="date" name="release_date" value="{{ old('release_date') }}">
        </div>
        
        <div class="form-group">
            <label>Price *</label>
            <input type="number" name="price" step="0.01" min="0" value="{{ old('price') }}" required>
        </div>
        
        <div class="form-group">
            <label>Stock *</label>
            <input type="number" name="stock" min="0" value="{{ old('stock', 0) }}" required>
        </div>
        
        <div class="form-group">
            <label>Description</label>
            <textarea name="description" rows="5">{{ old('description') }}</textarea>
        </div>
        
        <div class="form-group">
            <label>Image URL</label>
            <input type="url" name="image_url" value="{{ old('image_url') }}" placeholder="https://example.com/image.jpg">
        </div>
        
        <div class="form-group">
            <label>Rating (0-10)</label>
            <input type="number" name="rating" step="0.1" min="0" max="10" value="{{ old('rating') }}">
        </div>
        
        <div style="display: flex; gap: 1rem;">
            <button type="submit" class="btn btn-primary">Create Game</button>
            <a href="{{ route('games.index') }}" class="btn" style="background: #666; text-decoration: none;">Cancel</a>
        </div>
    </form>
</div>
@endsection

