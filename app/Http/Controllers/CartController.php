<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);
        return view('cart.index', compact('cart'));
    }

    public function add($gameId)
    {
        $game = Game::findOrFail($gameId);
        
        if ($game->stock <= 0) {
            return redirect()->back()->with('error', 'This game is out of stock.');
        }

        $cart = session('cart', []);
        
        // Check if game already in cart
        $found = false;
        foreach ($cart as $key => $item) {
            if ($item['game_id'] == $gameId) {
                $cart[$key]['quantity']++;
                $found = true;
                break;
            }
        }
        
        // If not found, add new item
        if (!$found) {
            $cart[] = [
                'game_id' => $game->id,
                'quantity' => 1,
                'price' => $game->sale_price, // Use sale price if on sale
            ];
        }
        
        session(['cart' => $cart]);
        
        return redirect()->back()->with('success', 'Game added to cart!');
    }

    public function remove($gameId)
    {
        $cart = session('cart', []);
        
        foreach ($cart as $key => $item) {
            if ($item['game_id'] == $gameId) {
                if ($item['quantity'] > 1) {
                    $cart[$key]['quantity']--;
                } else {
                    unset($cart[$key]);
                }
                break;
            }
        }
        
        // Re-index array
        $cart = array_values($cart);
        
        session(['cart' => $cart]);
        
        return redirect()->route('cart.index')->with('success', 'Item updated in cart.');
    }

    public function clear()
    {
        session(['cart' => []]);
        return redirect()->route('cart.index')->with('success', 'Cart cleared.');
    }
}

