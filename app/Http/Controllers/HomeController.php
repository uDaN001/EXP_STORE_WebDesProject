<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Get popular games - games 6, 7, 8, 9, 10
        $popularGameTitles = [
            'Clair Obscur: Expedition 33',
            'R.E.P.O.',
            'Peak',
            'The Elder Scrolls V: Skyrim',
            'BioShock'
        ];
        $popularGames = collect();
        foreach ($popularGameTitles as $title) {
            $game = Game::where('title', $title)->first();
            if ($game) {
                $popularGames->push($game);
            }
        }

        // Get games on sale - games 1, 2, 3, 4, 5, 6
        $saleGameTitles = [
            'Elden Ring',
            'Cyberpunk 2077',
            'Hollow Knight: Silksong',
            'Baldur\'s Gate 3',
            'Silent Hill f',
            'Clair Obscur: Expedition 33'
        ];
        $saleGames = collect();
        foreach ($saleGameTitles as $title) {
            $game = Game::where('title', $title)->first();
            if ($game) {
                $saleGames->push($game);
            }
        }

        // Get featured games (top rated) - get more to ensure we have enough
        $featuredGames = Game::orderBy('rating', 'desc')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // Get unique categories from games
        $categories = Game::whereNotNull('genre')
            ->distinct()
            ->pluck('genre')
            ->filter()
            ->unique()
            ->values()
            ->toArray();

        return view('home', compact('popularGames', 'saleGames', 'categories', 'featuredGames'));
    }
}
