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
        $games = Game::all();

        return response()->json([
            'success' => true,
            'data' => $games
        ]);
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

        return response()->json([
            'success' => true,
            'message' => 'Game created successfully.',
            'data' => $game
        ], 201);
    }

    /**
     * Display the specified game.
     */
    public function show(Game $game)
    {
        return response()->json([
            'success' => true,
            'data' => $game
        ]);
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

        return response()->json([
            'success' => true,
            'message' => 'Game updated successfully.',
            'data' => $game
        ]);
    }

    /**
     * Remove the specified game from storage.
     */
    public function destroy(Game $game)
    {
        $game->delete();

        return response()->json([
            'success' => true,
            'message' => 'Game deleted successfully.'
        ]);
    }
}
