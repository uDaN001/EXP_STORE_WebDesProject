<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function showLogin()
    {
        return view('admin.login');
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard')->with('success', 'Welcome, Admin!');
        }

        return back()->with('error', 'Invalid credentials.')->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login')->with('success', 'You have been logged out.');
    }

    public function dashboard()
    {
        $totalGames = Game::count();
        $totalOrders = \App\Models\Order::count();
        $totalCustomers = \App\Models\Customer::count();
        $gamesOnSale = Game::where('is_on_sale', true)->count();
        
        return view('admin.dashboard', compact('totalGames', 'totalOrders', 'totalCustomers', 'gamesOnSale'));
    }

    public function games()
    {
        $games = Game::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.games.index', compact('games'));
    }

    public function createGame()
    {
        return view('admin.games.create');
    }

    public function storeGame(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'genre' => 'nullable|string|max:100',
            'platform' => 'nullable|string|max:100',
            'developer' => 'nullable|string|max:255',
            'publisher' => 'nullable|string|max:255',
            'release_date' => 'nullable|date',
            'price' => 'required|numeric|min:0',
            'is_on_sale' => 'boolean',
            'sale_percentage' => 'nullable|numeric|min:0|max:100',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image_url' => 'nullable|url',
            'rating' => 'nullable|numeric|min:0|max:10',
        ]);

        // Convert checkbox to boolean
        $validated['is_on_sale'] = $request->has('is_on_sale');

        Game::create($validated);

        return redirect()->route('admin.games')->with('success', 'Game created successfully.');
    }

    public function editGame(Game $game)
    {
        return view('admin.games.edit', compact('game'));
    }

    public function updateGame(Request $request, Game $game)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'genre' => 'nullable|string|max:100',
            'platform' => 'nullable|string|max:100',
            'developer' => 'nullable|string|max:255',
            'publisher' => 'nullable|string|max:255',
            'release_date' => 'nullable|date',
            'price' => 'required|numeric|min:0',
            'is_on_sale' => 'boolean',
            'sale_percentage' => 'nullable|numeric|min:0|max:100',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image_url' => 'nullable|url',
            'rating' => 'nullable|numeric|min:0|max:10',
        ]);

        // Convert checkbox to boolean
        $validated['is_on_sale'] = $request->has('is_on_sale');

        $game->update($validated);

        return redirect()->route('admin.games')->with('success', 'Game updated successfully.');
    }

    public function deleteGame(Game $game)
    {
        $game->delete();
        return redirect()->route('admin.games')->with('success', 'Game deleted successfully.');
    }
}

