<?php

namespace App\Http\Livewire\Checkout;

use Livewire\Component;

class CheckoutProgress extends Component
{
    public int $currentStep;

    public function mount()
    {
        $this->currentStep = match(request()->route()->getName()) {
            'checkout.billing' => 1,
            'checkout.shipping' => 2,
            'checkout.payment' => 3,
            'checkout.overview' => 4,
            default => 1,
        };
    }

    public function render()
    {
        return view('livewire.checkout.checkout-progress');
    }
}
