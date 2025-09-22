<?php

namespace App\Livewire\Tags;

use App\Models\Tag;
use Livewire\Component;

class TagForm extends Component
{
    public $title = 'Tags';
    public $name, $info, $tagId;

    protected $listeners = ['openModal', 'destroy'];

    public function render()
    {
        return view('livewire.tags.tag-form');
    }

    public function openModal($id = null)
    {
        $this->dispatch('showModal');

        if ($id) {
            $this->title = 'Edit Tags';
            $tag = Tag::find($id);
            if ($tag) {
                $this->tagId = $tag->id;
                $this->name = $tag->name;
                $this->info = $tag->info;
            }
        } else {
            $this->title = 'Create Tag';
            $this->reset(['name', 'info', 'tagId']);
        }
    }

    public function save()
    {
        try {
            $this->validate([
                'name' => 'required|string|max:255',
                'info' => 'required|string',
            ]);

            $existingTag = Tag::where('name', $this->name)->first();
            if ($existingTag && $existingTag->id !== $this->tagId) {
                session()->flash('error', 'Tag with this name already exists.');
                return $this->redirect('/tags');
            }

            if ($this->tagId) {
                $tag = Tag::find($this->tagId);
                $tag->name = $this->name;
                $tag->info = $this->info;
                $tag->save();
            } else {
                Tag::create(['name' => $this->name, 'info' => $this->info]);
            }

            $message = 'Tag ' . ($this->tagId ? 'updated' : 'created') . ' successfully.';

            $this->dispatch('hideModal');
            $this->reset(['name', 'tagId']);
            session()->flash('success', $message);
            return $this->redirect('/tags');
        } catch (\Exception $th) {
            session()->flash('error', 'An error occurred while saving the tag: ' . $th->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $tag = Tag::find($id);
            if ($tag) {
                $tag->delete();
                session()->flash('success', 'Tag deleted successfully.');
            } else {
                session()->flash('error', 'Tag not found.');
            }
            return $this->redirect('/tags');
        } catch (\Exception $th) {
            session()->flash('error', 'An error occurred while deleting the tag: ' . $th->getMessage());
        }
    }
}
