<?php

namespace App\Livewire\Products\Variants;

use App\Models\Product;
use App\Models\Variant;
use App\Models\VariantImage;
use App\Models\VariantSize;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;

class VariantForm extends Component
{
    use WithFileUploads;

    public $title = 'Variant';
    public $id, $variantId, $slug, $color, $color_code, $price, $status, $inStock;
    public $sizes = [];
    public $images = [];
    public $newImages = [];

    public function render()
    {
        return view('livewire.products.variants.variant-form');
    }

    public function mount()
    {
        if ($this->variantId) {
            $variant = Variant::with('sizes', 'images')->where('id', $this->variantId)->first();
            $this->slug = $variant->slug;
            $this->color = $variant->color;
            $this->color_code = $variant->color_code;
            $this->price = $variant->price;
            $this->status = $variant->is_active;
            $this->inStock = $variant->in_stock;
            $this->sizes = $variant->sizes->map(function ($size) {
                return [
                    'id' => $size->id,
                    'size' => $size->size,
                    'stock' => $size->stock,
                ];
            })->toArray();
            $this->images = $variant->images->map(function ($image) {
                return [
                    'id' => $image->id,
                    'url' => $image->image_url
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

    public function removeImage($index)
    {
        unset($this->images[$index]);
        $this->images = array_values($this->images);
    }

    public function resetImages()
    {
        $this->reset('images');
    }

    public function addSize()
    {
        $this->sizes[] = ['size' => '', 'stock' => ''];
    }

    public function removeSize($index)
    {
        unset($this->sizes[$index]);
        $this->sizes = array_values($this->sizes);
    }

    public function cancel()
    {
        return redirect()->route('products.show', [$this->id]);
    }

    public function save()
    {
        $this->status = $this->status === 'true' ? 1 : 0;

        $this->validate([
            'color' => 'required|max:255',
            'color_code' => 'required|max:255',
            'status' => 'required|boolean',
        ]);

        $productName = Product::select('name')->where('id', $this->id)->pluck('name');
        $this->slug = Str::slug($productName . ' ' . $this->color, '-');

        $slugExists = Variant::where('slug', $this->slug)
            ->when($this->variantId, function ($query) {
                $query->where('id', '!=', $this->variantId);
            })
            ->exists();

        if ($slugExists) {
            $message = 'Slug Exists! Error to ' . ($this->variantId ? 'update' : 'create') . ' variant.';
            session()->flash('error', $message);

            return redirect()->route('variants.edit', [$this->id, $this->variantId]);
        }

        DB::beginTransaction();
        try {
            if ($this->variantId) {
                $variant = Variant::findOrFail($this->variantId);
                $variant->fill([
                    'product_id' => $this->id,
                    'outfit_id' => null,
                    'slug' => $this->slug,
                    'color' => $this->color,
                    'color_code' => $this->color_code,
                    'price' => $this->price ?? null,
                    'is_active' => $this->status,
                    'in_stock' => $this->inStock ?? false,
                ]);
                $variant->save();

                $totalStock = 0;
                foreach ($this->sizes as $item) {
                    VariantSize::updateOrCreate(
                        ['id' => $item['id'] ?? null],
                        [
                            'variant_id' => $variant->id,
                            'size'       => $item['size'],
                            'stock'      => $item['stock'],
                        ]
                    );
                    $totalStock += $item['stock'];
                }

                $variant->in_stock = $totalStock > 0;
                $variant->save();

                if (isset($this->images)) {
                    foreach ($this->images as $key => $image) {
                        if (
                            !$image instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile &&
                            is_array($image) &&
                            Storage::disk('public')->exists($image['url'])
                        ) {
                            continue;
                        } else {
                            $filename = $variant->id . '-' . $key . '.' . $image->extension();
                            $path = $image->storeAs('products/variants/' . $variant->id, $filename, 'public');
                            VariantImage::create([
                                'id' => Uuid::uuid4(),
                                'variant_id' => $variant->id,
                                'image_url' => $path
                            ]);
                        }
                    }
                }
            } else {
                $variant = Variant::create([
                    'product_id' => $this->id,
                    'outfit_id' => null,
                    'slug' => $this->slug,
                    'color' => $this->color,
                    'color_code' => $this->color_code,
                    'price' => $this->price ?? null,
                    'is_active' => $this->status,
                    'in_stock' => false,
                ]);

                if ($variant) {
                    $totalStock = 0;
                    foreach ($this->sizes as $item) {
                        VariantSize::insert([
                            'variant_id' => $variant->id,
                            'size' => $item['size'],
                            'stock' => $item['stock'],
                        ]);

                        $totalStock += $item['stock'];
                    }

                    $variant->in_stock = $totalStock > 0;
                    $variant->save();

                    if (isset($this->images)) {
                        foreach ($this->images as $key => $image) {
                            $filename = $variant->id . '-' . $key . '.' . $image->extension();
                            $path = $image->storeAs('products/variants/' . $variant->id, $filename, 'public');
                            VariantImage::create([
                                'id' => Uuid::uuid4(),
                                'variant_id' => $variant->id,
                                'image_url' => $path
                            ]);
                        }
                    }
                }
            }

            DB::commit();
            $message = 'Variant ' . ($this->variantId ? 'updated' : 'created') . ' successfully.';
            session()->flash('success', $message);
            return $this->redirectRoute('products.show', ['id' => $this->id]);
        } catch (\Exception $th) {
            DB::rollback();
            $message = 'Error to ' . ($this->variantId ? 'update' : 'create') . ' variant.';
            session()->flash('error', $message);
            Log::error($th);
            return;
        }
    }
}
