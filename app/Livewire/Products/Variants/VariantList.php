<?php

namespace App\Livewire\Products\Variants;

use App\Models\Product;
use Livewire\Component;

class VariantList extends Component
{
    public $title = 'Product Detail';
    public $id;

    public function render()
    {
        return view('livewire.products.variants.variant-list', [
            'product' => Product::with('category', 'tags')->where('id', $this->id)->first()
        ]);
    }

    public function publish()
    {
        $product = Product::find($this->id);
        $update = $product->update([
            'is_active' => $product->is_active ? false : true
        ]);

        $message = 'Product ' . ($product->is_active ? 'published' : 'unpublished');

        if ($update) {
            session()->flash('success', $message);
        } else {
            session()->flash('error', 'Failed to update product status');
        }
    }

    public function updateStatus($col)
    {
        $product = Product::find($this->id);
        $product->update([
            "$col" => $product->$col ? false : true
        ]);
    }
}
