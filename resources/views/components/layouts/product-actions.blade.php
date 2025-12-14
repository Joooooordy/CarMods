<div class="flex items-center gap-2">
    {{-- Add to cart --}}
    <flux:button
        wire:click="addToCart({{ $product->id }})"
        variant="primary"
        size="sm"
        class="flex items-center gap-2 px-3 py-2 rounded-lg shadow-sm
               hover:bg-yellow-500 hover:text-black transition cursor-pointer">

        <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none"
             viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993
                     1.263 12c.07.665-.45 1.243-1.119 1.243H4.25
                     a1.125 1.125 0 0 1-1.12-1.243l1.264-12
                     A1.125 1.125 0 0 1 5.513 7.5h12.974
                     c.576 0 1.059.435 1.119 1.007Z"/>
        </svg>
    </flux:button>

    {{-- Wishlist --}}
    <flux:button
        wire:click="addToWishlist({{ $product->id }})"
        variant="ghost"
        size="sm"
        class="p-2 rounded-lg border border-gray-300 dark:border-gray-700
               hover:bg-red-50 dark:hover:bg-gray-800 transition cursor-pointer">

        <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-red-500"
             fill="none" viewBox="0 0 24 24" stroke-width="1.5"
             stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5
                     -1.935 0-3.597 1.126-4.312 2.733
                     -.715-1.607-2.377-2.733-4.313-2.733
                     C5.1 3.75 3 5.765 3 8.25
                     c0 7.22 9 12 9 12s9-4.78 9-12Z"/>
        </svg>
    </flux:button>
</div>
