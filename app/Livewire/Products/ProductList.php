<?php

namespace App\Livewire\Products;

use App\Models\Product;
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
        return view('livewire.products.product-list', [
            'products' => Product::with('category')->where('name', 'LIKE', '%' . $this->search . '%')->paginate($this->perpage)
        ]);
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        if ($product) {
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $product->delete();
            session()->flash('success', 'Tag deleted successfully.');
        } else {
            session()->flash('error', 'Tag not found.');
        }
        return $this->redirect('/products', navigate: true);
    }
}
