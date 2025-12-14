<?php
namespace App\Livewire\Cart;

use Illuminate\View\View;
use Livewire\Component;

class CartBadge extends Component
{
    public int $cartCount = 0;

    protected $listeners = ['cartUpdated' => 'updateCartCount'];

    public function mount(): void
    {
        $this->updateCartCount();
    }

    public function updateCartCount(): void
    {
        $this->cartCount = collect(session('cart', []))->sum('quantity');
    }

    public function render(): View
    {
        return view('livewire.cart.cart-badge');
    }
}
