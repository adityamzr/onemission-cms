<?php

namespace App\Livewire\Galleries;

use App\Models\Gallery;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;

class GalleryForm extends Component
{
    use WithFileUploads;

    public $title = 'Galleries';
    public $url, $photoId;

    protected $listeners = ['openModal', 'destroy'];

    public function render()
    {
        return view('livewire.galleries.gallery-form');
    }

    public function openModal($id = null)
    {
        $this->dispatch('showModal');

        if ($id) {
            $this->title = 'Edit Photo';
            $photo = Gallery::find($id);
            if ($photo) {
                $this->photoId = $photo->id;
                $this->url = $photo->url;
            }
        } else {
            $this->title = 'Add Photo';
            $this->reset(['url', 'photoId']);
        }
    }

    public function save()
    {
        DB::beginTransaction();
        try {
            $this->validate([
                'url' => 'required|image',
            ]);

            $random = Str::random(10);
            $filename = $random . '.' . $this->url->extension();

            if ($this->photoId) {
                $photo = Gallery::find($this->photoId);
                if ($photo && Storage::disk('public')->exists($photo->url)) {
                    Storage::disk('public')->delete($photo->url);
                    $path = $this->url->storeAs('galleries', $filename, 'public');
                    $photo->url = $path;
                    $photo->save();
                }
            } else {
                $path = $this->url->storeAs('galleries', $filename, 'public');
                Gallery::create(['url' => $path]);
            }

            DB::commit();
            $this->dispatch('hideModal');
            session()->flash('success', 'Gallery saved successfully.');
            return $this->redirect('/galleries');
        } catch (\Exception $e) {
            DB::rollback();
            session()->flash('error', 'An error occurred: ' . $e->getMessage());
            return $this->redirect('/galleries');
        }
    }
}
