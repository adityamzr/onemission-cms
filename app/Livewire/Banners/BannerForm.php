<?php

namespace App\Livewire\Banners;

use App\Models\Banner;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;

class BannerForm extends Component
{
    use WithFileUploads;

    public $title = 'Banners';
    public $url, $bannerId;

    protected $listeners = ['openModal', 'destroy'];

    public function render()
    {
        return view('livewire.banners.banner-form');
    }

    public function openModal($id = null)
    {
        $this->dispatch('showModal');

        if ($id) {
            $this->title = 'Edit Banner';
            $banner = Banner::find($id);
            if ($banner) {
                $this->bannerId = $banner->id;
                $this->url = $banner->url;
            }
        } else {
            $this->title = 'Add Banner';
            $this->reset(['url', 'bannerId']);
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

            if ($this->bannerId) {
                $banner = Banner::find($this->bannerId);
                if ($banner && Storage::disk('public')->exists($banner->url)) {
                    Storage::disk('public')->delete($banner->url);
                    $path = $this->url->storeAs('banners', $filename, 'public');
                    $banner->url = $path;
                    $banner->save();
                }
            } else {
                $path = $this->url->storeAs('banners', $filename, 'public');
                Banner::create(['url' => $path]);
            }

            DB::commit();
            $this->dispatch('hideModal');
            session()->flash('success', 'Banner saved successfully.');
            return $this->redirect('/banners');
        } catch (\Exception $e) {
            DB::rollback();
            session()->flash('error', 'An error occurred: ' . $e->getMessage());
            return $this->redirect('/banners');
        }
    }
}
