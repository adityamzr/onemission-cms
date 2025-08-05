<?php

namespace App\Livewire\Products;

use App\Models\Product;
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
}
