<?php

namespace App\Livewire\Outfits;

use App\Models\Outfit;
use App\Models\OutfitVariants;
use App\Models\Variant;
use Livewire\Component;
use Livewire\WithPagination;

class VariantsModal extends Component
{
    use WithPagination;

    public $title = 'Select one or more variants to add to this outfit';
    public $perpage = 3;
    public $outfitId, $search;
    public $selectedVariants = [];

    protected $listeners = ['openModal'];

    protected $updatesQueryString = ['page', 'search'];

    public function mount()
    {
        $this->outfitId = request()->route('id');
    }

    public function updatingPerpage()
    {
        $this->resetPage();
    }

    public function updatingPage()
    {
        $this->dispatch('keepModalOpen');
    }

    public function render()
    {
        $variantId = OutfitVariants::where('outfit_id', $this->outfitId)->pluck('variant_id')->toArray();

        return view('livewire.outfits.variants-modal', [
            'variants' => Variant::with('sizes', 'images')
                ->whereNotIn('id', $variantId)
                ->when(
                    $this->search,
                    fn($query) =>
                    $query->where(function ($q) {
                        $q->where('slug', 'LIKE', '%' . $this->search . '%')
                            ->orWhere('color', 'LIKE', '%' . $this->search . '%');
                    })
                )
                ->paginate($this->perpage)
        ]);
    }

    public function openModal()
    {
        $this->dispatch('showModal');
    }

    public function save()
    {
        $outfit = Outfit::find($this->outfitId);

        if ($outfit) {
            $outfit->variants()->syncWithoutDetaching($this->selectedVariants);
            session()->flash('success', 'Variants added to outfit successfully.');
            return $this->redirectRoute('outfits.edit', $this->outfitId);
        } else {
            session()->flash('error', 'Outfit not found.');
        }
    }
}
