<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.checkout')]

class CheckoutComponent extends Component
{
    public $method = 'card';
    public $card_number = '';
    public $name_on_card = '';
    public $expiry = '';
    public $cvv = '';
    public $remember = false;
    public $amount = 0;

     public function mount()
    {
        $this->amount = session('cart_total', 0);
    }

    public function processPayment()
    {
         if ($this->method === 'card') {
            $this->validate([
                'card_number' => 'required|numeric|min:12',
                'name_on_card' => 'required|string|min:3',
                'expiry' => 'required|string',
                'cvv' => 'required|numeric|min:3|max_digits:4',
            ]);
        }

        session([
            'payment_method' => $this->method,
            'payer_name' => $this->name_on_card,
            'amount' => $this->amount,
        ]);

        return redirect()->route('payment.success', ['amount' => $this->amount]);
    }

    public function render()
    {
        return view('livewire.checkout-component');
    }
}


