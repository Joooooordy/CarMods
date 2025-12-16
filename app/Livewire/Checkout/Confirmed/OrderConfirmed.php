<?php

namespace App\Livewire\Checkout\Confirmed;

use App\Models\User;
use Livewire\Component;

class OrderConfirmed extends Component
{

    public function getOrder(User $user)
    {
        // return laatst geplaatste order door user
        return $user->orders()->latest()->first();
    }

    public function render()
    {
        $order = $this->getOrder(auth()->user());
        return view('livewire.checkout.confirmed.order-confirmed', compact('order'));
    }
}
