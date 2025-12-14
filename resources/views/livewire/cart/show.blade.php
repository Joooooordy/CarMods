<div class="max-w-7xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">{{ __('Cart') }}</h1>

    <div class="flex flex-col lg:flex-row gap-8">
        {{-- Linkerkant: Productenlijst --}}
        <div class="flex-1 space-y-6">
            @forelse($cart as $item)
                <div class="flex border rounded-lg p-4 shadow-sm items-start gap-4">
                    <img src="{{ image_url($item['id']) }}" alt="{{ $item['name'] }}"
                         class="w-24 h-24 object-cover rounded-md">

                    <div class="flex-1">
                        <div class="flex justify-between">
                            <h2 class="font-semibold text-lg">{{ $item['name'] }}</h2>
                            <div class="flex flex-col items-end gap-2">
                                <span
                                    class="font-semibold text-lg">€ {{ number_format($item['price'], 2, ',', '.') }}</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-4 mt-1">
                            {{-- Rating stars voorbeeld --}}
                            <div class="flex items-center space-x-1 text-yellow-400">
                                @php $rating = rand(2,5); @endphp
                                @for ($i = 1; $i <= 5; $i++)
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         fill="{{ $i <= $rating ? 'currentColor' : 'none' }}"
                                         viewBox="0 0 24 24"
                                         stroke-width="1.5"
                                         stroke="currentColor"
                                         class="size-4">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557L2.04 10.387a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z"/>
                                    </svg>
                                @endfor
                                <span class="text-sm text-gray-600">(137)</span>
                            </div>
                        </div>
                        <div class="mt-3 flex justify-start gap-2 h-12">
                            <select id="quantity-{{ $item['id'] }}"
                                    wire:change="updateQuantity({{ $item['id'] }}, $event.target.value)"
                                    class="mt-1 block w-20 rounded-md border-2 border-black shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-300">
                                @for ($i = 1; $i <= 10; $i++)
                                    <option
                                        value="{{ $i }}" {{ $i == $item['quantity'] ? 'selected' : '' }}>{{ $i }}</option>
                                @endfor
                            </select>

                            <button wire:click="toggleFavorite({{ $item['id'] }})" title="{{ __('Favoriet') }}"
                                    class="text-yellow-500 hover:text-yellow-800 border-2 border-transparent hover:border-yellow-500 p-2 rounded cursor-pointer transition">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z"/>
                                </svg>
                            </button>

                            <button wire:click="removeFromCart({{ $item['id'] }})" title="{{ __('Verwijder') }}"
                                    class="text-red-600 hover:text-red-800 border-2 border-transparent hover:border-red-900 p-2 rounded cursor-pointer transition">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                                </svg>

                            </button>
                        </div>

                        <div class="flex justify-start space-x-4 mt-4 items-center">
                            <span
                                class="text-sm text-green-700 font-semibold border border-green-700 px-2 py-0.5 rounded mr-2">
                                {{ __('In Stock') }}
                            </span>

                            +

                            {{--                            @if (in_array($index, $premiumIndexes))--}}
                            {{--                                <svg xmlns="http://www.w3.org/2000/svg" width="100" height="32" viewBox="0 0 120 32" class="rounded-md">--}}
                            {{--                                    <rect x="0" y="0" width="120" height="32" rx="6" fill="#e6c200"/>--}}
                            {{--                                    <text x="60" y="21" font-size="16" font-family="Arial, sans-serif" fill="#000"--}}
                            {{--                                          text-anchor="middle" font-weight="bold">--}}
                            {{--                                        Premium+--}}
                            {{--                                    </text>--}}
                            {{--                                </svg>--}}
                            {{--                            @endif--}}
                        </div>

                        <span class="text-xs text-black dark:text-black mt-1">
                          {{ __('Order by today 23:59, get it tomorrow') }}
                        </span>

                    </div>
                </div>
            @empty
                <div class="flex justify-center items-center bg-yellow-50 rounded-2xl mt-3 w-full h-[17rem]">
                    <img src="{{ asset('img/CarMods.svg') }}"
                         alt="{{ __('CarMods Logo') }}"
                         class="h-25 w-25 sm:h-50 sm:w-50 object-contain drop-shadow-md"/>
                </div>

                <div class="flex justify-center items-center mt-4 mb-2 w-full text-center">
                    <div>
                        <h1 class="text-2xl font-bold mb-2 mr-auto mb-none ml-auto w-full text-28 text-brand-text-high">
                            {{ __('Are you sure you put some products in?') }}
                        </h1>
                        <p class="mt-none text-18 text-neutral-text-high">{{ __('Looking for ideas?') }}</p>
                        <div class="flex flex-wrap justify-center gap-4 mt-none mb-18 w-full">
                            <a href="{{ route('shop') }}"
                               class="inline-flex items-center gap-2 bg-yellow-500 hover:bg-yellow-600 text-white font-semibold px-6 py-3 rounded-xl shadow transition duration-200 mt-8">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                                     stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M15.75 19.5 8.25 12l7.5-7.5"/>
                                </svg>
                                {{ __('Continue Shopping') }}
                            </a>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    {{ __('There are still :count products on your', ['count' => count($cart)]) }} <a href="{{route('cart')}}">{{ __('wishlist') }}</a>
                </div>
            @endforelse
        </div>

        @if (!empty($cart))
            <aside class="w-full lg:w-96 bg-white border rounded-lg p-6 shadow-sm">
                <h2 class="font-bold text-xl mb-4">{{ __('Overview') }}</h2>

                <div class="mb-2">
                    <div class="flex gap-2 justify-between">
                        <span>{{ __('Total Products (:count)', ['count' => count($cart)]) }}</span>
                        <span
                            class="font-semibold">€ {{ number_format(collect($cart)->sum(fn($i) => $i['price'] * $i['quantity']), 2, ',', '.') }}</span>
                    </div>
                </div>

                <div class="flex justify-between mb-2">
                    <span>{{ __('Shipping') }}</span>
                    <span class="text-green-600 font-semibold">€ 0,00</span>
                </div>

                <hr class="my-4"/>

                <div class="mb-6">
                    {{ __('Do you have a discount code? Add it in the next step.') }}
                </div>

                <div class="bg-yellow-100 p-3 rounded-md flex justify-between items-center mb-6">
                    <span class="font-semibold text-lg">{{ __('Total to pay:') }}</span>
                    <span
                        class="font-bold text-xl">€ {{ number_format(collect($cart)->sum(fn($i) => $i['price'] * $i['quantity']), 2, ',', '.') }}</span>
                </div>

                <a href="{{ route('checkout.billing') }}" class="block w-full max-w-md mx-auto bg-yellow-500 hover:bg-yellow-600 text-white text-center py-3 px-6 rounded-lg font-semibold shadow-md transition duration-200 ease-in-out mb-4">
                    {{ __('Go to Checkout') }}
                </a>


                <div class="flex justify-center gap-4 py-4">
                    <svg class="w-12 h-12">
                        <use xlink:href="img/sprite.svg#paypal-svgrepo-com"></use>
                    </svg>
                    <svg class="w-12 h-12">
                        <use xlink:href="img/sprite.svg#ideal-svgrepo-com"></use>
                    </svg>
                    <svg class="w-12 h-12">
                        <use xlink:href="img/sprite.svg#visa-classic-svgrepo-com"></use>
                    </svg>
                    <svg class="w-12 h-12">
                        <use xlink:href="img/sprite.svg#mastercard-full-svgrepo-com"></use>
                    </svg>
                    <svg class="w-12 h-12">
                        <use xlink:href="img/sprite.svg#amex-svgrepo-com"></use>
                    </svg>
                    <svg class="w-12 h-12">
                        <use xlink:href="img/sprite.svg#apple-pay-svgrepo-com"></use>
                    </svg>
                    <svg class="w-12 h-12">
                        <use xlink:href="img/sprite.svg#google-pay-svgrepo-com"></use>
                    </svg>
                </div>

                <div class="text-center text-gray-500 text-sm mb-2">
                    {{ __('or choose for comfort with') }}
                </div>

                <div class="flex justify-center gap-4">
                    <svg class="w-12 h-12">
                        <use xlink:href="img/sprite.svg#klarna-svgrepo-com"></use>
                    </svg>
                </div>
            </aside>
        @endif
    </div>

    {{-- Vaak samen gekocht sectie --}}
    @if (!empty($cart))
        <section class="mt-16">
            <h2 class="text-2xl font-bold mb-6">{{ __('Often bought together') }}</h2>
            <div class="flex gap-4 overflow-x-auto">
                {{--            @foreach($relatedProducts as $product)--}}
                {{--                <div class="w-24 flex-shrink-0">--}}
                {{--                    <img src="{{ $product->image_url ?? 'https://via.placeholder.com/96' }}" alt="{{ $product->name }}" class="rounded-md object-cover w-full h-24">--}}
                {{--                    <p class="text-center text-sm mt-2 font-semibold truncate">{{ $product->name }}</p>--}}
                {{--                </div>--}}
                {{--            @endforeach--}}
            </div>
        </section>
    @endif
</div>
