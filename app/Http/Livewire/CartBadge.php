<?php
namespace App\Http\Livewire;

use Livewire\Component;

class CartBadge extends Component
{
    public $cartCount = 0;

    protected $listeners = ['cartUpdated' => 'updateCartCount'];

    public function mount()
    {
        $this->updateCartCount();
    }

    public function updateCartCount()
    {
        $this->cartCount = collect(session('cart', []))->sum('quantity');
    }

    public function render()
    {
        return view('livewire.cart-badge');
    }
}
