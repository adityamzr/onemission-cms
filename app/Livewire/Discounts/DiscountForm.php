<?php

namespace App\Livewire\Discounts;

use App\Models\Discount;
use Livewire\Component;

class DiscountForm extends Component
{
    public $title = 'Discounts';
    public $code, $type, $value, $min_purchase, $expires_at, $discountId;

    protected $listeners = ['openModal', 'destroy'];

    public function render()
    {
        return view('livewire.discounts.discount-form');
    }

    public function openModal($id = null)
    {
        $this->dispatch('showModal');

        if ($id) {
            $this->title = 'Edit Discount';
            $discount = Discount::find($id);
            if ($discount) {
                $this->discountId = $discount->id;
                $this->code = $discount->code;
                $this->type = $discount->type;
                $this->value = (int) $discount->value;
                $this->min_purchase = (int) $discount->min_purchase;
                $this->expires_at = $discount->expires_at;
            }
        } else {
            $this->title = 'Add Discount';
            $this->reset(['code', 'type', 'value', 'min_purchase', 'expires_at', 'discountId']);
        }
    }

    public function save()
    {
        try {
            $this->validate([
                'code' => 'required|string|max:255',
                'type' => 'required|in:Percentage,Fixed',
                'value' => 'required|numeric|min:0',
                'min_purchase' => 'nullable|numeric|min:0',
                'expires_at' => 'required|date|after:today'
            ]);

            $existingDiscount = Discount::where('code', $this->code)->first();
            if ($existingDiscount && $existingDiscount->id !== $this->discountId) {
                session()->flash('error', 'Discount with this code already exists.');
                return $this->redirect('/discounts');
            }

            if ($this->discountId) {
                $discount = Discount::find($this->discountId);
                $discount->code = $this->code;
                $discount->type = $this->type;
                $discount->value = $this->value;
                $discount->min_purchase = $this->min_purchase;
                $discount->expires_at = $this->expires_at;
                $discount->save();
            } else {
                Discount::create([
                    'code' => $this->code,
                    'type' => $this->type,
                    'value' => $this->value,
                    'min_purchase' => $this->min_purchase,
                    'expires_at' => $this->expires_at
                ]);
            }

            $message = 'Discount ' . ($this->discountId ? 'updated' : 'created') . ' successfully.';

            $this->dispatch('hideModal');
            $this->reset(['code', 'type', 'value', 'min_purchase', 'expires_at', 'discountId']);
            session()->flash('success', $message);
            return $this->redirect('/discounts');
        } catch (\Exception $th) {
            session()->flash('error', 'An error occurred while saving the discount: ' . $th->getMessage());
            return $this->redirect('/discounts');
        }
    }
}
