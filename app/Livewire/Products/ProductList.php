<?php

namespace App\Livewire\Products;

use App\Models\Product;
use App\Models\Variant;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Title;
use Livewire\Component;

class ProductList extends Component
{
    #[Title('Products')]
    public $title = 'Products';

    public $perpage = 12;
    public $search;

    protected $queryString = ['perpage', 'search'];

    public function updatingPerpage()
    {
        $this->resetPage();
    }

    public function render()
    {
        $products = Product::with('category', 'variants.sizes')->where('name', 'LIKE', '%' . $this->search . '%')->paginate($this->perpage);
        return view('livewire.products.product-list', [
            'products' => $products
        ]);
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        if ($product) {
            $variants = Variant::with('sizes', 'images')->where('product_id', $id)->get();
            foreach ($variants as $variant) {
                if ($variant->images->isNotEmpty()) {
                    $firstImagePath = $variant->images->first()->image_url;
                    $folderPath = dirname($firstImagePath);

                    Storage::disk('public')->deleteDirectory($folderPath);
                }

                $variant->sizes()->delete();
                $variant->images()->delete();

                $variant->delete();
            }

            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }

            $product->delete();
            session()->flash('success', 'Product deleted successfully.');
        } else {
            session()->flash('error', 'Product not found.');
        }
        return $this->redirect('/products', navigate: true);
    }
}
