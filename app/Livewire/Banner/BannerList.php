<?php

namespace App\Livewire\Banner;

use App\Models\Banner;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Title;
use Livewire\Component;

class BannerList extends Component
{
    #[Title('Banners')]
    public $title = 'Banners';

    public $perpage = 20;
    public $search;

    protected $queryString = ['perpage', 'search'];

    public function updatingPerpage()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.banners.banner-list', [
            'banners' => Banner::orderBy('created_at', 'DESC')->paginate($this->perpage)
        ]);
    }

    public function toggleActive($id)
    {
        $banner = Banner::find($id);
        if ($banner) {
            $banner->is_active = !$banner->is_active;
            $banner->save();
            session()->flash('success', 'Banner status updated successfully.');
        } else {
            session()->flash('error', 'Banner not found.');
        }
    }

    public function togglePrimary($id)
    {
        $banner = Banner::find($id);
        if ($banner) {
            Banner::where('is_primary', true)->update(['is_primary' => false]);

            $banner->is_primary = true;
            $banner->save();

            session()->flash('success', 'Banner set as primary successfully.');
        } else {
            session()->flash('error', 'Banner not found.');
        }
    }

    public function destroy($id)
    {
        $banner = Banner::find($id);
        if ($banner) {
            if ($banner && Storage::disk('public')->exists($banner->url)) {
                Storage::disk('public')->delete($banner->url);
                $banner->delete();
            }
            session()->flash('success', 'Banner deleted successfully.');
        } else {
            session()->flash('error', 'Banner not found.');
        }
        return $this->redirect('/banners');
    }
}
