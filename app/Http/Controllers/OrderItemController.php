<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use App\Models\Order;
use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderItemController extends Controller
{
    /**
     * Display a listing of the order items.
     */
    public function index()
    {
        $orderItems = OrderItem::with(['order.customer', 'game'])->get();

        return response()->json([
            'success' => true,
            'data' => $orderItems
        ]);
    }

    /**
     * Store a newly created order item in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|exists:orders,id',
            'game_id' => 'required|exists:games,id',
            'quantity' => 'required|integer|min:1',
            'price_each' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $orderItem = OrderItem::create($validator->validated());

        return response()->json([
            'success' => true,
            'message' => 'Order item created successfully.',
            'data' => $orderItem->load(['order', 'game']),
        ], 201);
    }

    /**
     * Display the specified order item.
     */
    public function show($id)
    {
        $orderItem = OrderItem::with(['order.customer', 'game'])->find($id);

        if (!$orderItem) {
            return response()->json([
                'success' => false,
                'message' => 'Order item not found.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $orderItem,
        ]);
    }

    /**
     * Update the specified order item in storage.
     */
    public function update(Request $request, $id)
    {
        $orderItem = OrderItem::find($id);

        if (!$orderItem) {
            return response()->json([
                'success' => false,
                'message' => 'Order item not found.',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'quantity' => 'sometimes|integer|min:1',
            'price_each' => 'sometimes|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $orderItem->update($validator->validated());

        return response()->json([
            'success' => true,
            'message' => 'Order item updated successfully.',
            'data' => $orderItem->load(['order', 'game']),
        ]);
    }

    /**
     * Remove the specified order item from storage.
     */
    public function destroy($id)
    {
        $orderItem = OrderItem::find($id);

        if (!$orderItem) {
            return response()->json([
                'success' => false,
                'message' => 'Order item not found.',
            ], 404);
        }

        $orderItem->delete();

        return response()->json([
            'success' => true,
            'message' => 'Order item deleted successfully.',
        ]);
    }
}
