<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\ProcessOrderJob;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'nullable|exists:users,id',
            'name' => 'bail|required|string|max:255',
            'email' => 'bail|required|email|max:255',
            'phone' => 'bail|required|string|max:15',
            'shipping_provider' => 'bail|required|string|max:255',
            'shipping_cost' => 'bail|required|numeric|min:0',
            'shipping_address.country' => 'nullable|string|max:255',
            'shipping_address.province' => 'bail|required|string|max:255',
            'shipping_address.city' => 'bail|required|string|max:255',
            'shipping_address.district' => 'bail|required|string|max:255',
            'shipping_address.postal_code' => 'nullable|string|max:10',
            'shipping_address.address' => 'bail|required|string',
            'order_items' => 'bail|required|array|min:1',
            'order_items.*.product_id' => 'bail|required|exists:products,id',
            'order_items.*.variant_id' => 'bail|required|exists:variants,id',
            'order_items.*.size_id' => 'bail|required|exists:variant_sizes,id',
            'order_items.*.quantity' => 'bail|required|integer|min:1',
            'discount_id' => 'nullable|exists:discounts,id',
            'payment_method' => 'required|string',
            'notes' => 'nullable|string',
            'cancel_reason' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $validated = $validator->validated();

        // Create Order
        $orderNumber = 'ORD' . now()->format('ymdHis') . strtoupper(Str::random(3));
        try {
            $order = Order::create([
                'user_id' => $validated['user_id'] ?? null,
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'order_number' => $orderNumber,
                'status' => 'pending',
                'payment_status' => 'unpaid',
                'shipping_provider' => $validated['shipping_provider'],
                'shipping_cost' => $validated['shipping_cost'],
                'discount_id' => $validated['discount_id'] ?? null,
                'notes' => $validated['notes'] ?? null,
                'cancel_reason' => $validated['cancel_reason'] ?? null,
                'expires_at' => now()->addMinutes(30),
            ]);

            // Dispatch job ke queue
            ProcessOrderJob::dispatch($order, $validated);


            return response()->json([
                'success' => true,
                'message' => 'Order received waiting for payment',
                'data' => [
                    'order_id' => $order->id,
                ]
            ], 201);
        } catch (\Throwable $th) {
            Log::error('Failed to dispatch order job: ' . $th->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to process order, please try again later.',
            ], 500);
        }
    }

    public function cancel(Request $request, $orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)->first();

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        if (!in_array($order->status, ['pending', 'waiting payment', 'paid', 'processing'])) {
            return response()->json(['message' => 'Order cannot be cancelled'], 400);
        }

        $validator = Validator::make($request->all(), [
            'cancel_reason' => 'bail|required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $order->update([
            'status' => 'cancelling',
            'cancel_reason' => $validator->validated()['cancel_reason'],
        ]);

        return response()->json(['message' => 'Order cancelled successfully'], 200);
    }

    public function callback(Request $request)
    {
        // Here you would typically verify the callback data,
        // update the order status based on payment result, etc.

        try {
            DB::beginTransaction();
            $order = Order::where('id', $request->input('order_id'))->first();

            if (!$order) {
                return response()->json(['message' => 'Order not found'], 404);
            }

            $paymentStatus = $request->input('status') == 'success' ? 'paid' : 'failed';

            $order->update([
                'status' => $request->input('status'),
                'payment_status' => $paymentStatus,
            ]);

            if ($paymentStatus == 'paid') {
                // Reduce stock, send confirmation email, etc.
                foreach ($order->orderItems as $item) {
                    $variantSize = $item->variant->sizes()->where('id', $item->size_id)->first();
                    if ($variantSize) {
                        $variantSize->decrement('reserved_stock', $item->quantity);
                    }
                }
            } else {
                // Handle payment failure (e.g., release reserved stock)
                foreach ($order->orderItems as $item) {
                    $variantSize = $item->variant->sizes()->where('id', $item->size_id)->first();
                    if ($variantSize) {
                        $variantSize->increment('stock', $item->quantity);
                        $variantSize->decrement('reserved_stock', $item->quantity);
                    }
                }
            }

            $payid = 'PAY' . now()->format('ymdHis') . strtoupper(Str::random(3));
            Payment::where('order_id', $order->id)->update([
                'payment_id' => $payid,
                'payment_date' => now(),
                // 'payment_reference' => null,
                // 'payment_method' => '',
                'payment_status' => $paymentStatus,
                'amount' => $request->input('amount'),
            ]);

            DB::commit();
            return response()->json([
                'status' => $request->input('status'),
                'message' => 'Payment ' . ucfirst($request->input('status'))
            ], 200);
        } catch (\Throwable $th) {
            Log::error('Failed to process payment callback: ' . $th->getMessage());
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to process payment callback.',
            ], 500);
        }
    }

    public function received($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)->first();

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        if ($order->status != 'shipped') {
            return response()->json(['message' => 'Order cannot be marked as received'], 400);
        }

        $order->update([
            'status' => 'delivered',
        ]);

        return response()->json(['message' => 'Order marked as received successfully'], 200);
    }
}
