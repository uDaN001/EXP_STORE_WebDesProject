<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        
        $validator = Validator::make($request->all(), [
            'total_amount' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->route('cart.index')
                ->withErrors($validator)
                ->withInput();
        }

        // Get customer ID from session
        $customerId = session('customer_id');
        if (!$customerId) {
            return redirect()->route('customers.login')
                ->with('error', 'Please login to place an order.');
        }

        // Create Order
        $order = Order::create([
            'customer_id' => $customerId,
            'total_amount' => $request->total_amount,
            'payment_method' => 'Online',
            'status' => 'pending',
        ]);

        // Create Order Items from cart
        foreach ($cart as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'game_id' => $item['game_id'],
                'quantity' => $item['quantity'],
                'price_each' => $item['price'],
            ]);
        }

        // Clear cart
        session(['cart' => []]);

        return redirect()->route('orders.show', $order->id)
            ->with('success', 'Order placed successfully!');
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
