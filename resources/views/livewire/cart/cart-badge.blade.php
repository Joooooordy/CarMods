<div>
    <flux:tooltip :content="__('Cart')" position="bottom">
        <flux:navbar.item class="!h-10 [&>div>svg]:size-5 relative" icon="shopping-cart" :href="route('cart')"
                          :label="__('Cart')" wire:navigate>
            @if ($cartCount > 0)
                <flux:badge variant="solid" color="yellow" inset="top bottom" class="absolute text-xs top-[0.1rem] right-[0.62rem] font-bold w-5 h-5 flex items-center justify-center">
                    {{ $cartCount }}
                </flux:badge>
            @endif
        </flux:navbar.item>
    </flux:tooltip>
</div>
