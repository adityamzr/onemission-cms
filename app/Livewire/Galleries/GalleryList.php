<?php

namespace App\Livewire\Galleries;

use App\Models\Gallery;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Title;
use Livewire\Component;

class GalleryList extends Component
{
    #[Title('Galleries')]
    public $title = 'Galleries';

    public $perpage = 20;
    public $search;

    protected $queryString = ['perpage', 'search'];

    public function updatingPerpage()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.galleries.gallery-list', [
            'galleries' => Gallery::orderBy('created_at', 'DESC')->paginate($this->perpage)
        ]);
    }

    public function toggleActive($id)
    {
        $photo = Gallery::find($id);
        if ($photo) {
            $photo->is_active = !$photo->is_active;
            $photo->save();
            session()->flash('success', 'Photo status updated successfully.');
        } else {
            session()->flash('error', 'Photo not found.');
        }
    }

    public function destroy($id)
    {
        $photo = Gallery::find($id);
        if ($photo) {
            if ($photo && Storage::disk('public')->exists($photo->url)) {
                Storage::disk('public')->delete($photo->url);
                $photo->delete();
            }
            session()->flash('success', 'Photo deleted successfully.');
        } else {
            session()->flash('error', 'Photo not found.');
        }
        return $this->redirect('/galleries');
    }
}
