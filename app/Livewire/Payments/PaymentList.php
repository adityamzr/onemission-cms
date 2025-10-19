<?php

namespace App\Livewire\Payments;

use App\Models\Payment;
use Livewire\Attributes\Title;
use Livewire\Component;

class PaymentList extends Component
{
    #[Title('Paymnets')]
    public $title = 'Payments';

    public $perpage = 25;
    public $search;

    protected $queryString = ['perpage', 'search'];

    public function updatingPerpage()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.payments.payment-list', [
            'payments' => Payment::with('order')->whereIn('payment_status', ['paid', 'failed'])->orderBy('created_at', 'DESC')->paginate($this->perpage)
        ]);
    }
}
