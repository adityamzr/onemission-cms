<?php

namespace App\Livewire\Products;

use App\Models\Category;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;

class ProductForm extends Component
{
    use WithFileUploads;

    public $title = 'Product';
    public $id;
    public $form = [
        'name',
        'categoryId',
        'price',
        'originalPrice',
        'image',
        'description',
        'usage',
        'technology',
        'features',
        'composition',
        'sustainability',
        'warranty'
    ];
    public $selectedTags = [];

    public function render()
    {
        return view('livewire.products.product-form', [
            'categories' => Category::select('id', 'name')->get(),
            'tags' => Tag::select('id', 'name')->get()
        ]);
    }

    public function mount($id = null)
    {
        if ($id) {
            $product = Product::with('category', 'tags')->where('id', $id)->first();
            $this->id = $product->id;
            $this->form['name'] = $product->name;
            $this->form['categoryId'] = $product->category->id;
            $this->form['description'] = $product->description;
            $this->form['price'] = floor($product->price);
            $this->form['originalPrice'] = floor($product->originalPrice);
            $this->form['usage'] = $product->usage;
            $this->form['technology'] = $product->technology;
            $this->form['features'] = $product->features;
            $this->form['composition'] = $product->composition;
            $this->form['sustainability'] = $product->sustainability;
            $this->form['warranty'] = $product->warranty;
            $this->selectedTags = $product->tags->pluck('id')->toArray();
        }
    }

    public function save()
    {
        $this->validate([
            'form.name' => 'required|string|max:255',
            'form.categoryId' => 'required',
            'form.price' => 'required|numeric',
            'form.image' => $this->id
                ? 'nullable|mimes:jpg,jpeg,webp,png'
                : 'required|mimes:jpg,jpeg,webp,png',
        ]);

        if (isset($this->form['image'])) {
            $random = uniqid();
            $filename = $random . '.' . $this->form['image']->extension();
            $path = $this->form['image']->storeAs('products', $filename, 'public');
        }

        if ($this->id) {
            $product = Product::findOrFail($this->id);
            $product->fill([
                'name' => $this->form['name'],
                'category_id' => $this->form['categoryId'],
                'price' => $this->form['price'],
                'originalPrice' => $this->form['originalPrice'],
                'image' => $path ?? $product->image,
                'description' => $this->form['description'] ?? null,
                'usage' => $this->form['usage'] ?? null,
                'technology' => $this->form['technology'] ?? null,
                'features' => $this->form['features'] ?? null,
                'composition' => $this->form['composition'] ?? null,
                'sustainability' => $this->form['sustainability'] ?? null,
                'warranty' => $this->form['warranty'] ?? null,
            ]);
            $product->save();

            if (isset($this->form['image']) && $product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
        } else {
            $product = Product::create([
                'name' => $this->form['name'],
                'category_id' => $this->form['categoryId'],
                'price' => $this->form['price'],
                'originalPrice' => $this->form['originalPrice'] ?? 0,
                'image' => $path,
                'description' => $this->form['description'] ?? null,
                'usage' => $this->form['usage'] ?? null,
                'technology' => $this->form['technology'] ?? null,
                'features' => $this->form['features'] ?? null,
                'composition' => $this->form['composition'] ?? null,
                'sustainability' => $this->form['sustainability'] ?? null,
                'warranty' => $this->form['warranty'] ?? null,
            ]);
        }

        if (!empty($this->selectedTags)) {
            $product->tags()->sync($this->selectedTags);
        } else {
            $product->tags()->detach();
        }

        $message = 'Product ' . ($this->id ? 'updated' : 'created') . ' successfully.';
        session()->flash('success', $message);
        return $this->redirect('products/' . $product->id . '/show');
    }
}
