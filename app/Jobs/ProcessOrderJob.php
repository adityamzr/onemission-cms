<?php

namespace App\Jobs;

use App\Models\Discount;
use App\Models\Order;
use App\Models\Product;
use App\Models\VariantSize;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessOrderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $order;
    protected $validated;
    /**
     * Create a new job instance.
     */
    public function __construct(Order $order, array $validated)
    {
        $this->order = $order;
        $this->validated = $validated;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            DB::transaction(function () {
                Log::info('[OrderJob] Starting process', ['data' => $this->validated]);

                //Reserve Stock & Calculate Total Amount
                Log::info('[OrderJob] Reserving stock', ['order_number' => $this->order->order_number]);
                $subtotal = 0;
                foreach ($this->validated['order_items'] as $item) {
                    $product = Product::with(['variants.images', 'variants.sizes'])->findOrFail($item['product_id']);
                    $variant = $product->variants->where('id', $item['variant_id'])->first();
                    $variantStock = VariantSize::where('id', $item['size_id'])->lockForUpdate()->first();

                    if (!$variantStock) {
                        throw new \Exception("Variant size not found for ID {$item['size_id']}");
                    }

                    if ($variantStock->stock < $item['quantity']) {
                        throw new \Exception("Insufficient stock for Variant: {$variant->slug}");
                    }

                    $variantStock->reserved_stock += $item['quantity'];
                    $variantStock->stock -= $item['quantity'];
                    $variantStock->save();
                    $subtotal += ($variant->price ?? $product->price) * $item['quantity'];

                    // Create Order Item
                    $this->order->orderItems()->create([
                        'product_id' => $item['product_id'],
                        'variant_id' => $item['variant_id'],
                        'size_id' => $item['size_id'],
                        'product_name' => $product->name,
                        'variant_slug' => $variant->slug,
                        'size' => $variantStock->size,
                        'color' => $variant->color,
                        'quantity' => $item['quantity'],
                        'price' => $variant->price ?? $product->price,
                        'subtotal' => ($variant->price ?? $product->price) * $item['quantity'],
                        'image_url' => $variant->images->first()->image_url ?? $product->image_url,
                    ]);
                }

                $totalDiscount = 0;
                //Check Discount Voucher
                Log::info('[OrderJob] Applying discount', ['discount_id' => $this->validated['discount_id'] ?? null]);
                if (!empty($this->validated['discount_id'])) {
                    $discount = Discount::find($this->validated['discount_id']);
                    if (!$discount) {
                        return response()->json(['message' => 'Discount not found'], 404);
                    }

                    if ($discount->type == 'Percentage') {
                        $totalDiscount = ($discount->value / 100) * $subtotal;
                    } else {
                        $totalDiscount = $discount->value;
                    }
                }

                $totalAmount = ($subtotal - $totalDiscount) + $this->validated['shipping_cost'];

                // Create Shipping Address
                Log::info('[OrderJob] Creating shipping address', ['order_number' => $this->order->order_number]);
                $this->order->shippingAddress()->create([
                    'country' => $this->validated['shipping_address']['country'] ?? null,
                    'province' => $this->validated['shipping_address']['province'],
                    'city' => $this->validated['shipping_address']['city'],
                    'district' => $this->validated['shipping_address']['district'],
                    'postal_code' => $this->validated['shipping_address']['postal_code'] ?? null,
                    'address' => $this->validated['shipping_address']['address'],
                ]);

                $this->order->payment()->create([
                    'order_id' => $this->order->id,
                    'payment_method' => $this->validated['payment_method'],
                ]);

                $this->order->update([
                    'subtotal' => $subtotal,
                    'total_discount' => $totalDiscount,
                    'total_amount' => $totalAmount,
                    'status' => 'waiting payment',
                    'payment_url' => 'https://your-domain.com/api/payments/initiate?order_id=' . $this->order->id
                ]);
            });

            Log::info("Order #{$this->order->order_number} processed successfully.");
        } catch (\Throwable $th) {
            Log::error("Order #{$this->order->order_number} failed: " . $th->getMessage());
            $this->order->update(['status' => 'failed']);
            throw $th;
        }
    }
}
