<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of all orders.
     */
    public function index()
    {
        $query = Order::with(['customer', 'orderItems.game', 'payment']);

        // If customer is logged in, show only their orders
        if (session('customer_id')) {
            $query->where('customer_id', session('customer_id'));
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('orders.index', compact('orders'));
    }

    /**
     * Show the form for editing the specified order.
     */
    public function edit($id)
    {
        // Only allow admin (authenticated users) to edit orders
        if (!Auth::check()) {
            abort(403, 'Unauthorized access.');
        }

        $order = Order::with(['customer', 'orderItems.game', 'payment'])->findOrFail($id);
        return view('orders.edit', compact('order'));
    }

    /**
     * Store a newly created order in storage.
     */
    public function store(Request $request)
    {
        // Handle cart-based order creation
        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty.');
        }

        // Recalculate total server-side to avoid client manipulation and ensure prices exist
        $recalculatedTotal = 0;
        foreach ($cart as $cItem) {
            // Determine price for this item: prefer session price, fallback to current game price
            $priceEach = $cItem['price'] ?? null;
            if ($priceEach === null) {
                $gameForPrice = \App\Models\Game::find($cItem['game_id']);
                $priceEach = $gameForPrice ? $gameForPrice->sale_price : 0;
            }

            $qty = isset($cItem['quantity']) ? (int)$cItem['quantity'] : 1;
            $recalculatedTotal += ($priceEach * $qty);
        }

        // 10% VAT applied later in cart view; here we expect total_amount to be provided
        // but we will trust our recalculated total. If client submitted total_amount, ignore it.
        $totalAmount = $recalculatedTotal;

        // Get customer ID from session
        $customerId = session('customer_id');
        if (!$customerId) {
            return redirect()->route('customers.login')
                ->with('error', 'Please login to place an order.');
        }

        // Create Order using server-side computed total
        $order = Order::create([
            'customer_id' => $customerId,
            'total_amount' => $totalAmount,
            'payment_method' => 'Online',
            'status' => 'pending',
        ]);

        // Create Order Items from cart (ensure price_each is present)
        foreach ($cart as $item) {
            $priceEach = $item['price'] ?? null;
            if ($priceEach === null) {
                $gameForPrice = \App\Models\Game::find($item['game_id']);
                $priceEach = $gameForPrice ? $gameForPrice->sale_price : 0;
            }

            OrderItem::create([
                'order_id' => $order->id,
                'game_id' => $item['game_id'],
                'quantity' => $item['quantity'],
                'price_each' => $priceEach,
            ]);
        }

        // Clear cart
        session(['cart' => []]);

        // Mark order as paid/completed
        $order->update([
            'status' => 'completed',
            'payment_method' => 'Online',
        ]);

        // Create payment record
        \App\Models\Payment::create([
            'order_id' => $order->id,
            'amount' => $order->total_amount,
            'method' => 'Online',
            'status' => 'successful',
        ]);

        return redirect()->route('orders.complete', $order->id)
            ->with('success', 'Purchase complete!');
    }

    /**
     * Display purchase complete page.
     */
    public function complete($id)
    {
        $order = Order::with(['customer', 'orderItems.game', 'payment'])->findOrFail($id);

        // Check if customer owns this order (if logged in as customer)
        if (session('customer_id') && $order->customer_id != session('customer_id')) {
            abort(403, 'Unauthorized access.');
        }

        return view('orders.complete', compact('order'));
    }

    /**
     * Display the specified order.
     */
    public function show($id)
    {
        $order = Order::with(['customer', 'orderItems.game', 'payment'])->findOrFail($id);

        // Check if customer owns this order (if logged in as customer)
        if (session('customer_id') && $order->customer_id != session('customer_id')) {
            abort(403, 'Unauthorized access.');
        }

        return view('orders.show', compact('order'));
    }

    /**
     * Update the specified order.
     */
    public function update(Request $request, $id)
    {
        // Only allow admin (authenticated users) to update orders
        if (!Auth::check()) {
            abort(403, 'Unauthorized access.');
        }

        $order = Order::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'total_amount' => 'sometimes|numeric|min:0',
            'payment_method' => 'sometimes|string|max:50',
            'status' => 'sometimes|in:pending,paid,shipped,completed,cancelled',
        ]);

        if ($validator->fails()) {
            return redirect()->route('orders.edit', $order->id)
                ->withErrors($validator)
                ->withInput();
        }

        $order->update($request->only(['total_amount', 'payment_method', 'status']));

        return redirect()->route('orders.show', $order->id)
            ->with('success', 'Order updated successfully.');
    }

    /**
     * Remove the specified order from storage.
     */
    public function destroy($id)
    {
        // Only allow admin (authenticated users) to delete orders
        if (!Auth::check()) {
            abort(403, 'Unauthorized access.');
        }

        $order = Order::find($id);

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found.',
            ], 404);
        }

        $order->delete();

        return redirect()->route('orders.index')
            ->with('success', 'Order deleted successfully.');
    }
}
