<?php

namespace App\Livewire\Orders;

use App\Models\Order;
use Livewire\Attributes\Title;
use Livewire\Component;

class OrderList extends Component
{
    #[Title('Incoming Orders')]
    public $title = 'Incoming Orders';

    public $perpage = 25;
    public $search;

    protected $queryString = ['perpage', 'search'];

    public function updatingPerpage()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.orders.order-list', [
            'orders' => Order::where('status', 'pending')
                ->orWhere('status', 'waiting payment')
                ->orWhere('status', 'paid')
                ->orWhere('status', 'processing')
                ->orWhere('status', 'shipped')
                ->orWhere('status', 'delivered')
                ->orWhere(function ($query) {
                    $query->where('status', 'cancelling')
                        ->where('payment_status', '!=', 'paid');
                })
                ->orderBy('created_at', 'DESC')->paginate($this->perpage)
        ]);
    }
}
