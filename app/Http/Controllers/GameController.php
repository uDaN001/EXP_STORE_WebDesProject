<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;

class GameController extends Controller
{
    /**
     * Display a listing of all games.
     */
    public function index()
    {
        $query = Game::query();
        
        if (request('category')) {
            $query->where('genre', request('category'));
        }
        
        if (request('q')) {
            $query->where('title', 'like', '%' . request('q') . '%')
                  ->orWhere('description', 'like', '%' . request('q') . '%');
        }
        
        $games = $query->paginate(12);
        
        return view('games.index', compact('games'));
    }
    
    /**
     * Show the form for creating a new game.
     */
    public function create()
    {
        return view('games.create');
    }
    
    /**
     * Search games.
     */
    public function search(Request $request)
    {
        return $this->index();
    }

    /**
     * Store a newly created game in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'genre' => 'nullable|string|max:100',
            'platform' => 'nullable|string|max:100',
            'developer' => 'nullable|string|max:255',
            'publisher' => 'nullable|string|max:255',
            'release_date' => 'nullable|date',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image_url' => 'nullable|url',
            'rating' => 'nullable|numeric|min:0|max:10',
        ]);

        $game = Game::create($validated);

        return redirect()->route('games.show', $game->id)
            ->with('success', 'Game created successfully.');
    }

    /**
     * Display the specified game.
     */
    public function show(Game $game)
    {
        return view('games.show', compact('game'));
    }
    
    /**
     * Show the form for editing the specified game.
     */
    public function edit(Game $game)
    {
        return view('games.edit', compact('game'));
    }

    /**
     * Update the specified game in storage.
     */
    public function update(Request $request, Game $game)
    {
        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'genre' => 'sometimes|string|max:100',
            'platform' => 'sometimes|string|max:100',
            'developer' => 'sometimes|string|max:255',
            'publisher' => 'sometimes|string|max:255',
            'release_date' => 'sometimes|date',
            'price' => 'sometimes|numeric|min:0',
            'stock' => 'sometimes|integer|min:0',
            'description' => 'nullable|string',
            'image_url' => 'nullable|url',
            'rating' => 'nullable|numeric|min:0|max:10',
        ]);

        $game->update($validated);

        return redirect()->route('games.show', $game->id)
            ->with('success', 'Game updated successfully.');
    }

    /**
     * Remove the specified game from storage.
     */
    public function destroy(Game $game)
    {
        $game->delete();

        return redirect()->route('games.index')
            ->with('success', 'Game deleted successfully.');
    }
}
