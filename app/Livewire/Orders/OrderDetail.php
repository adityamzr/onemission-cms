<?php

namespace App\Livewire\Orders;

use App\Models\Order;
use App\Models\ShipmentTracking;
use App\Models\VariantSize;
use Illuminate\Support\Facades\Request;
use Livewire\Component;

class OrderDetail extends Component
{
    public $title = 'Order Detail';
    public $order, $orderQty, $address, $tracking_number;

    protected $listeners = ['openModal'];

    public function render()
    {
        return view('livewire.orders.order-detail');
    }

    public function openModal($id = null)
    {
        $this->dispatch('showModal');

        $this->order = Order::with('orderItems', 'shippingAddress', 'shipmentTracking', 'payment')->find($id);
        $this->orderQty = 0;
        foreach ($this->order?->orderItems ?? [] as $item) {
            $this->orderQty += $item->quantity;
        }
        $this->address = $this->order->shippingAddress->address . ', ' .
            ($this->order->shippingAddress->district ?? '') . ', ' .
            ($this->order->shippingAddress->city ?? '') . ', ' .
            ($this->order->shippingAddress->province ?? '') . ($this->order->shippingAddress->postal_code ? ', ' : '') .
            ($this->order->shippingAddress->postal_code ?? '');
    }

    public function showModalTracking()
    {
        $this->dispatch('showModalTracking');
    }

    public function cancelOrder($id)
    {
        try {
            $order = Order::find($id);

            if (!$order) {
                session()->flash('error', 'Order not found.');
            } else {
                foreach ($order->orderItems as $item) {
                    // Restore stock
                    $variantSize = VariantSize::find($item->size_id);
                    if ($variantSize) {
                        $variantSize->reserved_stock -= $item->quantity;
                        $variantSize->stock += $item->quantity;
                        $variantSize->save();
                    }
                }

                $order->status = 'cancelled';
                $order->save();
                session()->flash('success', 'Order cancelled successfully.');
            }

            return $this->redirect('/orders');
        } catch (\Exception $th) {
            session()->flash('error', 'An error occurred while updating order: ' . $th->getMessage());
            return $this->redirect('/orders');
        }
    }

    public function processOrder($id)
    {
        try {
            $order = Order::find($id);

            if (!$order) {
                session()->flash('error', 'Order not found.');
            } else {
                $order->status = 'processing';
                $order->save();
                session()->flash('success', 'Order status updated to processing.');
            }

            return $this->redirect('/orders');
        } catch (\Exception $th) {
            session()->flash('error', 'An error occurred while updating order: ' . $th->getMessage());
            return $this->redirect('/orders');
        }
    }

    public function shipOrder($id)
    {
        try {
            $this->validate([
                'tracking_number' => 'required|string|max:255',
            ]);

            $order = Order::find($id);

            if (!$order) {
                session()->flash('error', 'Order not found.');
            } else {
                ShipmentTracking::create([
                    'order_id' => $order->id,
                    'tracking_number' => $this->tracking_number,
                    'shipping_provider' => $order->shipping_provider,
                    'status' => 'shipped',
                ]);

                $order->status = 'shipped';
                $order->save();
                session()->flash('success', 'Order status updated to shipped.');
            }

            return $this->redirect('/orders');
        } catch (\Exception $th) {
            session()->flash('error', 'An error occurred while updating order: ' . $th->getMessage());
            return $this->redirect('/orders');
        }
    }

    public function completeOrder($id)
    {
        try {
            $order = Order::find($id);

            if (!$order) {
                session()->flash('error', 'Order not found.');
            } else {
                $order->status = 'completed';
                $order->save();
                session()->flash('success', 'Order status updated to completed.');
            }

            return $this->redirect('/orders');
        } catch (\Exception $th) {
            session()->flash('error', 'An error occurred while updating order: ' . $th->getMessage());
            return $this->redirect('/orders');
        }
    }
}
