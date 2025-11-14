<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    /**
     * Display a listing of the payments.
     */
    public function index()
    {
        $payments = Payment::with('order.customer')->get();

        return response()->json([
            'success' => true,
            'data' => $payments
        ]);
    }

    /**
     * Store a newly created payment in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|exists:orders,id',
            'amount' => 'required|numeric|min:0',
            'method' => 'required|string|max:255',
            'status' => 'required|in:successful,failed,pending',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $payment = Payment::create($validator->validated());

        // Optionally update order status if payment succeeds
        if ($payment->status === 'successful') {
            $payment->order->update(['status' => 'paid']);
        }

        return response()->json([
            'success' => true,
            'message' => 'Payment created successfully.',
            'data' => $payment->load('order.customer'),
        ], 201);
    }

    /**
     * Display the specified payment.
     */
    public function show($id)
    {
        $payment = Payment::with('order.customer')->find($id);

        if (!$payment) {
            return response()->json([
                'success' => false,
                'message' => 'Payment not found.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $payment,
        ]);
    }

    /**
     * Update the specified payment in storage.
     */
    public function update(Request $request, $id)
    {
        $payment = Payment::find($id);

        if (!$payment) {
            return response()->json([
                'success' => false,
                'message' => 'Payment not found.',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'amount' => 'sometimes|numeric|min:0',
            'method' => 'sometimes|string|max:255',
            'status' => 'sometimes|in:successful,failed,pending',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $payment->update($validator->validated());

        // Auto-update order status if payment changes
        if ($payment->status === 'successful') {
            $payment->order->update(['status' => 'paid']);
        } elseif ($payment->status === 'failed') {
            $payment->order->update(['status' => 'cancelled']);
        }

        return response()->json([
            'success' => true,
            'message' => 'Payment updated successfully.',
            'data' => $payment->load('order.customer'),
        ]);
    }

    /**
     * Remove the specified payment from storage.
     */
    public function destroy($id)
    {
        $payment = Payment::find($id);

        if (!$payment) {
            return response()->json([
                'success' => false,
                'message' => 'Payment not found.',
            ], 404);
        }

        $payment->delete();

        return response()->json([
            'success' => true,
            'message' => 'Payment deleted successfully.',
        ]);
    }
}
