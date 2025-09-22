<?php

namespace App\Livewire\Categories;

use App\Models\Category;
use Livewire\Component;

class CategoryForm extends Component
{
    public $title;
    public $name, $categoryId;

    protected $listeners = ['openModal', 'destroy'];

    public function render()
    {
        return view('livewire.categories.category-form');
    }

    public function openModal($id = null)
    {
        $this->dispatch('showModal');

        if ($id) {
            $this->title = 'Edit Category';
            $category = Category::find($id);
            if ($category) {
                $this->name = $category->name;
                $this->categoryId = $category->id;
            }
        } else {
            $this->title = 'Create Category';
            $this->reset(['name', 'categoryId']);
        }
    }

    public function save()
    {
        try {
            $this->validate([
                'name' => 'required|string|max:255',
            ]);

            $existingCategory = Category::where('name', $this->name)->first();
            if ($existingCategory && $existingCategory->id !== $this->categoryId) {
                session()->flash('error', 'Category with this name already exists.');
                return $this->redirect('/categories');
            }

            if ($this->categoryId) {
                $category = Category::find($this->categoryId);
                $category->name = $this->name;
                $category->save();
            } else {
                Category::create(['name' => $this->name]);
            }

            $message = 'Category ' . ($this->categoryId ? 'updated' : 'created') . ' successfully.';

            $this->dispatch('hideModal');
            $this->reset(['name', 'categoryId']);
            session()->flash('success', $message);
            return $this->redirect('/categories');
        } catch (\Exception $th) {
            session()->flash('error', 'An error occurred while saving the category: ' . $th->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $category = Category::find($id);
            if ($category) {
                $category->delete();
                session()->flash('success', 'Category deleted successfully.');
            } else {
                session()->flash('error', 'Category not found.');
            }
            return $this->redirect('/categories');
        } catch (\Exception $th) {
            session()->flash('error', 'An error occurred while deleting the category: ' . $th->getMessage());
        }
    }
}
