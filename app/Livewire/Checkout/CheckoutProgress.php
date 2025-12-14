<?php

namespace App\Livewire\Checkout;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class CheckoutProgress extends Component
{
    public int $currentStep;

    public function mount(): void
    {
        $this->currentStep = match(request()->route()->getName()) {
            'checkout.shipping' => 2,
            'checkout.payment' => 3,
            'checkout.overview' => 4,
            default => 1,
        };
    }

    public function render(): View
    {
        return view('livewire.checkout.checkout-progress');
    }
}
