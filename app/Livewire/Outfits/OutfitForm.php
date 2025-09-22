<?php

namespace App\Livewire\Outfits;

use App\Models\Outfit;
use App\Models\OutfitImage;
use App\Models\OutfitVariants;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class OutfitForm extends Component
{
    use WithFileUploads, WithPagination;

    public $title = 'Outfit';
    public $id, $modelName, $modelHeight, $modelSize, $status, $search;
    public $perpage = 5;
    public $images = [];
    public $newImages = [];

    protected $queryString = ['perpage', 'search'];

    public function updatingPerpage()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.outfits.outfit-form', [
            'outfitItems' => OutfitVariants::with('variant.sizes', 'variant.images')->where('outfit_id', $this->id)
                ->whereHas('variant', function ($query) {
                    $query->where('slug', 'LIKE', '%' . $this->search . '%')
                        ->orWhere('color', 'LIKE', '%' . $this->search . '%');
                })
                ->orderBy('id', 'ASC')
                ->paginate($this->perpage)
        ]);
    }

    public function mount()
    {
        if ($this->id) {
            $outfit = Outfit::with('images')->where('id', $this->id)->first();
            $this->modelName = $outfit->model_name;
            $this->modelHeight = $outfit->model_height;
            $this->modelSize = $outfit->model_size;
            $this->status = $outfit->is_shown ? 'true' : 'false';
            $this->images = $outfit->images->map(function ($image) {
                return [
                    'id' => $image->id,
                    'url' => $image->url
                ];
            })->toArray();
        }
    }

    public function updatedNewImages()
    {
        $this->validate(
            [
                'newImages.*' => 'image|mimes:jpg,jpeg,png,webp,aviff|max:5120',
            ],
            [
                'newImages.*.image' => 'The file must be an image.',
                'newImages.*.mimes' => 'Only JPG, JPEG, PNG, WEBP and AVIFF files are allowed.',
                'newImages.*.max'   => 'Each image must not exceed 5MB.',
            ]
        );

        $this->images = array_merge($this->images, $this->newImages);
        $this->reset('newImages');
    }

    public function removeImage($index, $imageId = '', $variantId = null)
    {
        if ($imageId !== '' && $variantId !== null) {
            $image = OutfitImage::find($imageId);
            if ($image && Storage::disk('public')->exists($image->url)) {
                Storage::disk('public')->delete($image->url);
                $image->delete();
            }
        }
        unset($this->images[$index]);
        $this->images = array_values($this->images);
    }

    public function resetImages()
    {
        $this->reset('images');
    }

    public function cancel()
    {
        return redirect()->route('outfits');
    }

    public function removeOutfitItem($id)
    {
        $outfitItem = OutfitVariants::where('variant_id', $id)->where('outfit_id', $this->id)->first();

        if ($outfitItem) {
            $outfitItem->delete();
            session()->flash('success', 'Variant removed from outfit successfully.');
        } else {
            session()->flash('error', 'Outfit item not found.');
        }
    }

    public function save()
    {
        $this->status = $this->status === 'true' ? 1 : 0;

        $this->validate([
            'modelName' => 'required|max:255',
            'modelHeight' => 'required|max:255',
            'modelSize' => 'required|max:255',
        ]);

        DB::beginTransaction();
        try {
            if ($this->id) {
                $outfit = Outfit::findOrFail($this->id);
                $outfit->fill([
                    'model_name' => $this->modelName,
                    'model_height' => $this->modelHeight,
                    'model_size' => $this->modelSize,
                    'is_shown' => $this->status ?? false,
                ]);
                $outfit->save();

                if (isset($this->images)) {
                    foreach ($this->images as $key => $image) {
                        if (
                            !$image instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile &&
                            is_array($image) &&
                            Storage::disk('public')->exists($image['url'])
                        ) {
                            continue;
                        } else {
                            $filename = $outfit->id . '-' . $key . '.' . $image->extension();
                            $path = $image->storeAs('outfits/' . $outfit->id, $filename, 'public');
                            OutfitImage::create([
                                'outfit_id' => $outfit->id,
                                'url' => $path
                            ]);
                        }
                    }
                }
            } else {
                $outfit = Outfit::create([
                    'model_name' => $this->modelName,
                    'model_height' => $this->modelHeight,
                    'model_size' => $this->modelSize,
                    'is_shown' => $this->status,
                ]);

                if ($outfit) {
                    if (isset($this->images)) {
                        foreach ($this->images as $key => $image) {
                            $filename = $outfit->id . '-' . $key . '.' . $image->extension();
                            $path = $image->storeAs('outfits/' . $outfit->id, $filename, 'public');
                            OutfitImage::create([
                                'outfit_id' => $outfit->id,
                                'url' => $path
                            ]);
                        }
                    }
                }
            }

            DB::commit();
            $message = 'Outfit ' . ($this->id ? 'updated' : 'created') . ' successfully.';
            session()->flash('success', $message);
            return $this->redirectRoute('outfits');
        } catch (\Exception $th) {
            DB::rollback();
            $message = 'Error to ' . ($this->id ? 'update' : 'create') . ' outfit.';
            session()->flash('error', $message);
            Log::error($th);
            return;
        }
    }
}
