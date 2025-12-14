<?php

namespace App\Livewire\Settings;

use App\Models\User;
use Livewire\Component;

class Order extends Component
{
    public function getOrders(User $user)
    {
        $user = auth()->user();

        return $user->orders()->orderBy('created_at', 'desc')->get();
    }


    public function render()
    {
        $orders = $this->getOrders(auth()->user());
        return view('livewire.settings.order', compact('orders'));
    }
}
