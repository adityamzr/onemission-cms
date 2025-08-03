<?php

namespace App\Livewire\Tags;

use App\Models\Tag;
use Livewire\Attributes\Title;
use Livewire\Component;

class TagList extends Component
{
    #[Title('Tags')]
    public $title = 'Tags';

    public $perpage = 5;
    public $search;

    protected $queryString = ['perpage', 'search'];

    public function updatingPerpage()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.tags.tag-list', [
            'tags' => Tag::where('name', 'LIKE', '%' . $this->search . '%')->paginate($this->perpage)
        ]);
    }
}
