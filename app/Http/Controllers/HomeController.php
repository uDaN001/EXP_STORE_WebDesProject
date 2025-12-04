<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Get popular games (you can customize this logic)
        $popularGames = Game::orderBy('rating', 'desc')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Get games on sale
        $saleGames = Game::where('is_on_sale', true)
            ->whereNotNull('sale_percentage')
            ->orderBy('sale_percentage', 'desc')
            ->take(6)
            ->get();

        // Get featured games (top rated)
        $featuredGames = Game::orderBy('rating', 'desc')
            ->orderBy('created_at', 'desc')
            ->take(6)
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
