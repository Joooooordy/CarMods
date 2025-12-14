<?php

namespace App\Livewire;

use App\Models\Product;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class Shop extends Component
{
    public array $cart = [];
    public bool $showModal = false;
    public array $relatedProducts = [];
    protected $listeners = ['closeModal'];

    public function mount(): void
    {
        $this->cart = session()->get('cart', []);
    }


    public function addToCart(int $productId): void
    {
        $product = \App\Models\Product::findOrFail($productId);

        $cart = $this->cart;

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += 1;
        } else {
            $cart[$productId] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->image,
                'quantity' => 1,
                'shipping_cost' => $product->shipping_cost,
            ];
        }

        $this->cart = $cart;
        $this->dispatch('cartUpdated');
        $this->dispatch('product-added', [
            'name' => $product->name,
        ]);
        session()->put('cart', $cart);
    }

    public function render(): View
    {
        return view('livewire.shop.shop', [
            'products' => Product::paginate(16),
        ]);
    }
}
