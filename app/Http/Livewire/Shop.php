<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class Shop extends Component
{
    public $cart = [];
    public $showModal = false;
    public $relatedProducts = [];
    protected $listeners = ['closeModal'];

    public function mount()
    {
        $this->cart = session()->get('cart', []);
    }


    public function addToCart(int $productId)
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
            ];
        }
//
//        $this->relatedProducts = Product::where('category_id', $product->category_id)
//            ->where('id', '!=', $product->id)
//            ->take(6)
//            ->get();

        $this->cart = $cart;
        $this->dispatch('cartUpdated');
        $this->dispatch('product-added', [
            'name' => $product->name,
        ]);
        session()->put('cart', $cart);
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function render()
    {
        return view('livewire.shop.show', [
            'products' => Product::paginate(16),
        ]);
    }
}
