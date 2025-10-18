<?php

namespace App\Livewire\Orders;

use App\Models\Order;
use Livewire\Attributes\Title;
use Livewire\Component;

class CancelList extends Component
{
    #[Title('Cancel & Refunds')]
    public $title = 'Cancel & Refunds';

    public $perpage = 25;
    public $search;

    protected $queryString = ['perpage', 'search'];

    public function updatingPerpage()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.orders.cancel-list', [
            'orders' => Order::where('status', 'cancelling')->where('payment_status', 'paid')->orderBy('created_at', 'DESC')->paginate($this->perpage)
        ]);
    }
}
