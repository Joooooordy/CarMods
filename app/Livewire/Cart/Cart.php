<?php

namespace App\Livewire\Cart;

use App\Models\Product;
use Illuminate\View\View;
use Livewire\Component;

class Cart extends Component
{
    public array $cart = [];

    /**
     * Mounts the component and initializes the cart property
     * using session data.
     */
    public function mount(): void
    {
        $this->cart = session()->get('cart', []);
    }

    /**
     * Removes a product from the cart by its ID, updates the cart
     * property and persists changes to the session. Dispatches a
     * cart update event after the removal.
     *
     * @param int $productId The ID of the product to remove from the cart.
     */
    public function removeFromCart(int $productId): void
    {
        $cart = $this->cart;
        unset($cart[$productId]);
        $this->cart = $cart;
        $this->dispatch('cartUpdated');
        session()->put('cart', $cart);
    }

    /**
     * Updates the quantity of a specific product in the cart.
     *
     * If the specified quantity is less than or equal to zero, the product
     * is removed from the cart. Otherwise, the product quantity is updated
     * and the updated cart data is stored in the session.
     *
     * @param int $productId The ID of the product to update.
     * @param int $quantity The new quantity of the product.
     */
    public function updateQuantity(int $productId, int $quantity): void
    {
        if ($quantity <= 0) {
            $this->removeFromCart($productId);
            return;
        }

        $this->cart[$productId]['quantity'] = $quantity;
        session()->put('cart', $this->cart);
    }

    /**
     * Retrieves a collection of related products, limiting the results to 5.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getRelatedProductsProperty()
    {
        return $products = Product::limit(5)->get();
    }

    /**
     * Calculates the total shipping cost for the cart items.
     *
     * Iterates through the cart to retrieve and sum up the shipping cost
     * of each item. Logs the shipping cost details for every product
     * processed.
     *
     * @return float The total shipping cost.
     */
    public function getShippingTotalProperty(): float
    {
        $collection = collect($this->cart);

        $shippingCosts = $collection->map(function ($item, $productId) {
            return $item['shipping_cost'] ?? 0;
        });

        $total = $shippingCosts->sum();

        return $total;
    }

    /**
     * Render the cart view with the calculated total cost.
     *
     * This method calculates the total cost of the items
     * in the cart, including the price, quantity, and
     * optional shipping cost for each item. The total
     * cost is then passed to the view.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function render(): View
    {
        $total = collect($this->cart)->sum(fn($item) => $item['price'] * $item['quantity'] + ($item['shipping_cost'] ?? 0));

        return view('livewire.cart.cart', [
            'total' => $total,
        ]);
    }
}

