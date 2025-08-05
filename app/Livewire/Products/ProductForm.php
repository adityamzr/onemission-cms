<?php

namespace App\Livewire\Products;

use App\Models\Category;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Support\Facades\DB;
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

    public function save()
    {
        $this->validate([
            'form.name' => 'required|string|max:255',
            'form.categoryId' => 'required',
            'form.price' => 'required|numeric',
            'form.originalPrice' => 'required|numeric',
            'form.image' => 'required|mimes:jpg,jpeg,webp,png',
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
                'image' => $path,
                'description' => $this->form['description'] ?? null,
                'usage' => $this->form['usage'] ?? null,
                'technology' => $this->form['technology'] ?? null,
                'features' => $this->form['features'] ?? null,
                'composition' => $this->form['composition'] ?? null,
                'sustainability' => $this->form['sustainability'] ?? null,
                'warranty' => $this->form['warranty'] ?? null,
            ]);
            $product->save();
        } else {
            $product = Product::create([
                'name' => $this->form['name'],
                'category_id' => $this->form['categoryId'],
                'price' => $this->form['price'],
                'originalPrice' => $this->form['originalPrice'],
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
        return $this->redirect('/products', navigate: true);
    }
}
