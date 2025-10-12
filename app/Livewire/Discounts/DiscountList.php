<?php

namespace App\Livewire\Discounts;

use App\Models\Discount;
use Livewire\Attributes\Title;
use Livewire\Component;

class DiscountList extends Component
{
    #[Title('Discounts')]
    public $title = 'Discounts';

    public $perpage = 5;
    public $search;

    protected $queryString = ['perpage', 'search'];

    public function updatingPerpage()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.discounts.discount-list', [
            'discounts' => Discount::where('code', 'LIKE', '%' . $this->search . '%')->orWhere('type', 'LIKE', '%' . $this->search . '%')->orderBy('created_at', 'DESC')->paginate($this->perpage)
        ]);
    }

    public function destroy($id)
    {
        try {
            $discount = Discount::find($id);
            if ($discount) {
                $discount->delete();
                session()->flash('success', 'Discount deleted successfully.');
            } else {
                session()->flash('error', 'Discount not found.');
            }
            return $this->redirect('/discounts');
        } catch (\Exception $th) {
            session()->flash('error', 'An error occurred while deleting the Discount: ' . $th->getMessage());
            return $this->redirect('/discounts');
        }
    }
}
