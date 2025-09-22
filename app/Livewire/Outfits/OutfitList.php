<?php

namespace App\Livewire\Outfits;

use App\Models\Outfit;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Title;
use Livewire\Component;

class OutfitList extends Component
{
    #[Title('Outfits')]
    public $title = 'Outfits';

    public $perpage = 5;
    public $search;

    protected $queryString = ['perpage', 'search'];

    public function updatingPerpage()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.outfits.outfit-list', [
            'outfits' => Outfit::with('images')->where('model_name', 'LIKE', '%' . $this->search . '%')->paginate($this->perpage)
        ]);
    }

    public function updateStatus($id)
    {
        $outfit = Outfit::find($id);
        $outfit->update([
            "is_shown" => $outfit->is_shown ? false : true
        ]);
    }

    public function delete($id)
    {
        $outfit = Outfit::with('images')->find($id);

        if (!$outfit) {
            session()->flash('error', 'Outfit not found');
            return redirect()->route('outfits');
        }

        if ($outfit->images->isNotEmpty()) {
            $firstImagePath = $outfit->images->first()->url;
            $folderPath = dirname($firstImagePath);

            Storage::disk('public')->deleteDirectory($folderPath);
        }

        $outfit->images()->delete();
        $outfit->delete();

        session()->flash('success', 'Deleted outfit successfully');
        return $this->redirect('/outfits');
    }
}
