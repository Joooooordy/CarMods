<?php
namespace App\Http\Livewire;

use Livewire\Component;

class Cart extends Component
{
    public $cart = [];

    public function mount()
    {
        $this->cart = session()->get('cart', []);
    }

    public function removeFromCart($productId)
    {
        $cart = $this->cart;
        unset($cart[$productId]);
        $this->cart = $cart;
        $this->dispatch('cartUpdated');
        session()->put('cart', $cart);
    }

    public function updateQuantity($productId, $quantity)
    {
        if ($quantity <= 0) {
            $this->removeFromCart($productId);
            return;
        }

        $this->cart[$productId]['quantity'] = $quantity;
        session()->put('cart', $this->cart);
    }

    public function render()
    {
        return view('livewire.cart.show', [
            'total' => collect($this->cart)->sum(fn ($item) => $item['price'] * $item['quantity']),
        ]);
    }
}

