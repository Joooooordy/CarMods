<?php

namespace App\Livewire\Settings\Order;

use App\Models\Order;
use App\Models\User;
use Livewire\Component;

class UserOrder extends Component
{

    public function getOrders(User $user)
    {
        $user = auth()->user();

        return $user->orders()->orderBy('created_at', 'desc')->get();
    }

    public function viewOrder(Order $order)
    {
        return redirect()->route('settings.user-order-details', $order);
    }


    public function render()
    {
        $orders = $this->getOrders(auth()->user());
        return view('livewire.settings.order.user-order', compact('orders'));
    }
}
