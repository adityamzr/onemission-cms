<?php

namespace App\Livewire\Products\Variants;

use App\Models\Product;
use App\Models\Variant;
use App\Models\VariantSize;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class VariantList extends Component
{
    public $title = 'Product';
    public $subtitle = 'Detail';
    public $childtitle = 'Variant';
    public $id, $search;
    public $perpage = 5;

    public function render()
    {
        return view('livewire.products.variants.variant-list', [
            'product' => Product::with('category', 'tags')->where('id', $this->id)->first(),
            'variants' => Variant::with('sizes', 'images')->where('product_id', $this->id)->paginate($this->perpage)
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

    public function deleteVariant($id)
    {
        $variant = Variant::with('sizes', 'images', 'details')->find($id);

        if (!$variant) {
            session()->flash('error', 'Variant not found');
            return redirect()->route('products');
        }

        if ($variant->images->isNotEmpty()) {
            $firstImagePath = $variant->images->first()->image_url;
            $folderPath = dirname($firstImagePath);

            Storage::disk('public')->deleteDirectory($folderPath);
        }

        if ($variant->details->isNotEmpty()) {
            $firstImagePath = $variant->details->first()->image_url;
            $folderPath = dirname($firstImagePath);

            Storage::disk('public')->deleteDirectory($folderPath);
        }

        $variant->sizes()->delete();
        $variant->images()->delete();
        $variant->details()->delete();

        $variant->delete();

        session()->flash('success', 'Deleted variant successfully');
        return redirect()->route('products.show', [$this->id]);
    }
}
