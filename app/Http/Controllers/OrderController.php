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
        // Get all orders with relationships
        $orders = Order::with(['customer', 'orderItems.game', 'payment'])->get();

        return response()->json([
            'success' => true,
            'data' => $orders
        ]);
    }

    /**
     * Store a newly created order in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|exists:customers,id',
            'total_amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string|max:50',
            'status' => 'required|in:pending,completed,cancelled',
            'items' => 'required|array|min:1',
            'items.*.game_id' => 'required|exists:games,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        // Create Order
        $order = Order::create([
            'customer_id' => $request->customer_id,
            'total_amount' => $request->total_amount,
            'payment_method' => $request->payment_method,
            'status' => $request->status,
        ]);

        // Create Order Items
        foreach ($request->items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'game_id' => $item['game_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Order created successfully.',
            'data' => $order->load(['orderItems', 'customer']),
        ], 201);
    }

    /**
     * Display the specified order.
     */
    public function show($id)
    {
        $order = Order::with(['customer', 'orderItems.game', 'payment'])->find($id);

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $order,
        ]);
    }

    /**
     * Update the specified order.
     */
    public function update(Request $request, $id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found.',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'total_amount' => 'sometimes|numeric|min:0',
            'payment_method' => 'sometimes|string|max:50',
            'status' => 'sometimes|in:pending,completed,cancelled',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $order->update($request->only(['total_amount', 'payment_method', 'status']));

        return response()->json([
            'success' => true,
            'message' => 'Order updated successfully.',
            'data' => $order->load(['orderItems', 'customer', 'payment']),
        ]);
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

        return response()->json([
            'success' => true,
            'message' => 'Order deleted successfully.',
        ]);
    }
}
