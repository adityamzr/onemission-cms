<?php

namespace App\Livewire\Orders;

use App\Models\Order;
use Livewire\Attributes\Title;
use Livewire\Component;

class OrderHistory extends Component
{
    #[Title('Order History')]
    public $title = 'Order History';

    public $perpage = 25;
    public $search;

    protected $queryString = ['perpage', 'search'];

    public function updatingPerpage()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.orders.order-history', [
            'orders' => Order::where('status', 'completed')->orderBy('created_at', 'DESC')->paginate($this->perpage)
        ]);
    }
}
