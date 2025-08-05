<?php

namespace App\Livewire\Categories;

use App\Models\Category;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class CategoryList extends Component
{
    use WithPagination;

    #[Title('Categories')]
    public $title = 'Categories';

    public $perpage = 5;
    public $search;

    protected $queryString = ['perpage', 'search'];

    public function updatingPerpage()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.categories.category-list', [
            'categories' => Category::where('name', 'LIKE', '%' . $this->search . '%')->paginate($this->perpage)
        ]);
    }
}
