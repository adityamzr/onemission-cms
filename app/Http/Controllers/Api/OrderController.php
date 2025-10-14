<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Discount;
use App\Models\Order;
use App\Models\Product;
use App\Models\VariantSize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $validated = $request->validate([
                'user_id' => 'nullable|exists:users,id',
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'required|string|max:15',
                'shipping_provider' => 'required|string|max:255',
                'shipping_cost' => 'required|numeric|min:0',
                'shipping_address.country' => 'nullable|string|max:255',
                'shipping_address.province' => 'required|string|max:255',
                'shipping_address.city' => 'required|string|max:255',
                'shipping_address.district' => 'required|string|max:255',
                'shipping_address.postal_code' => 'nullable|string|max:10',
                'shipping_address.address' => 'required|string',
                'order_items.*.product_id' => 'required|exists:products,id',
                'order_items.*.variant_id' => 'required|exists:variants,id',
                'order_items.*.size_id' => 'required|exists:variant_sizes,id',
                'order_items.*.quantity' => 'required|integer|min:1',
                'discount_id' => 'nullable|exists:discounts,id',
                'notes' => 'nullable|string',
                'cancel_reason' => 'nullable|string'
            ]);

            //Reserve Stock & Calculate Total Amount
            $subtotal = 0;
            foreach ($validated['order_items'] as $item) {
                $product = Product::find($item['product_id']);
                $variant = $product->variants()->where('id', $item['variant_id'])->first();
                $variantStock = VariantSize::where('id', $item['size_id'])->first();
                if ($variantStock->stock < $item['quantity']) {
                    return response()->json(['message' => 'Insufficient stock for Variant: ' . $variant->slug], 400);
                }
                $variantStock->reserved_stock += $item['quantity'];
                $variantStock->stock -= $item['quantity'];
                $variantStock->save();
                $subtotal += $variant->price ?? $product->price * $item['quantity'];
            }

            //Check Discount Voucher
            if ($validated['discount_id']) {
                $discount = Discount::find($validated['discount_id']);
                if (!$discount) {
                    return response()->json(['message' => 'Discount not found'], 404);
                }

                if ($discount->type == 'Percentage') {
                    $totalDiscount = ($discount->value / 100) * $subtotal;
                } else {
                    $totalDiscount = $discount->value;
                }
                $subtotal -= $totalDiscount;
            }

            $totalAmount = $subtotal + $validated['shipping_cost'];
            // Create Order
            $timestamp = now()->format('YmdHis');
            $randomCode = str_pad(mt_rand(0, 99), 2, '0', STR_PAD_LEFT);
            $orderNumber = 'ORD' . $timestamp . $randomCode;

            $order = Order::create([
                'user_id' => $validated['user_id'] ?? null,
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'order_number' => $orderNumber,
                'status' => 'Pending',
                'payment_status' => 'Pending',
                'shipping_provider' => $validated['shipping_provider'],
                'shipping_cost' => $validated['shipping_cost'],
                'subtotal' => $subtotal,
                'total_discount' => $totalDiscount ?? 0,
                'total_amount' => $totalAmount,
                'discount_id' => $validated['discount_id'] ?? null,
                'notes' => $validated['notes'] ?? null,
                'cancel_reason' => $validated['cancel_reason'] ?? null,
                'expires_at' => now()->addMinutes(30),
            ]);

            // Create Order Items
            foreach ($validated['order_items'] as $item) {
                $product = Product::find($item['product_id']);
                $variant = $product->variants()->with('images')->where('id', $item['variant_id'])->first();
                $order->orderItems()->create([
                    'product_id' => $item['product_id'],
                    'variant_id' => $item['variant_id'],
                    'product_name' => $product->name,
                    'variant_slug' => $variant->slug,
                    'size' => VariantSize::find($item['size_id'])->size,
                    'color' => $variant->color,
                    'quantity' => $item['quantity'],
                    'price' => $variant->price ?? $product->price,
                    'subtotal' => ($variant->price ?? $product->price) * $item['quantity'],
                    'image_url' => $variant->images->first()->image_url ?? $product->image_url,
                ]);
            }

            // Create Shipping Address
            $order->shippingAddress()->create([
                'country' => $validated['shipping_address']['country'] ?? null,
                'province' => $validated['shipping_address']['province'],
                'city' => $validated['shipping_address']['city'],
                'district' => $validated['shipping_address']['district'],
                'postal_code' => $validated['shipping_address']['postal_code'] ?? null,
                'address' => $validated['shipping_address']['address'],
            ]);

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Order received waiting for payment',
                'order_id' => $order->id,
                'total_amount' => $totalAmount,
                'expires_at' => $order->expires_at,
                'payment_url' => 'https://your-domain.com/api/payments/initiate?order_id=' . $order->id
                // 'payment_url' => route('api.payments.initiate', ['order_id' => $order->id])
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Database error',
                'error_detail' => $e->getMessage(),
            ], 500);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong',
                'error_detail' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }
}
