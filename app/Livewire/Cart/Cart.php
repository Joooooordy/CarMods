<?php
namespace App\Livewire\Cart;

use Illuminate\View\View;
use Livewire\Component;

class Cart extends Component
{
    public array $cart = [];

    public function mount(): void
    {
        $this->cart = session()->get('cart', []);
    }

    public function removeFromCart(int $productId): void
    {
        $cart = $this->cart;
        unset($cart[$productId]);
        $this->cart = $cart;
        $this->dispatch('cartUpdated');
        session()->put('cart', $cart);
    }

    public function updateQuantity(int $productId, int $quantity): void
    {
        if ($quantity <= 0) {
            $this->removeFromCart($productId);
            return;
        }

        $this->cart[$productId]['quantity'] = $quantity;
        session()->put('cart', $this->cart);
    }

    public function render(): View
    {
        return view('livewire.cart.show', [
            'total' => collect($this->cart)->sum(fn ($item) => $item['price'] * $item['quantity']),
        ]);
    }
}

