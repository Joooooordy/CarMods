<?php

namespace App\Livewire\Settings\Order;

use App\Models\Order;
use Livewire\Component;

class OrderDetails extends Component
{
    public Order $order;
    public int $totalDiscount;

    public function mount(Order $order)
    {
        $this->order = $order;

        // calculeer korting
        $this->totalDiscount = $order->products->sum(fn($product) => $product->pivot->discount_amount ?? 0);
    }

    public function render()
    {
        return view('livewire.settings.order.order-details');
    }
}
