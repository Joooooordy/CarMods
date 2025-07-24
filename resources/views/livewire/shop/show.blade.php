<div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-bold mb-8">Products</h1>

    <div class="space-y-6">
        @php
            $max = $products->count();
            $premiumCount = rand(1, $max);
            $premiumIndexes = $products->keys()->shuffle()->take($premiumCount)->toArray();
        @endphp
        @foreach($products  as $index => $product)
            <div class="flex border-b border-gray-300 dark:border-gray-700 pb-6">
                <!-- Afbeelding -->
                <div class="flex-shrink-0 w-32 h-48 mr-6">
                    <img
                        src="{{ image_url($product->id) }}"
                        alt="{{ $product->name }}"
                        class="object-cover w-full h-full rounded"
                    />
                </div>

                <!-- Midden: Product info -->
                <div class="flex-grow max-w-4xl">

                    <h2 class="font-bold text-lg text-black dark:text-white mb-1">
                        {{ $product->name }}
                    </h2>

                    <div class="text-xs text-gray-500 dark:text-gray-400">
                        {{--                       TODO category implementation--}}Category
                    </div>

                    <div class="flex items-center text-yellow-400 mt-3 mb-3">
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
                        <span class="ml-1 text-gray-700 dark:text-gray-300">({{ rand(1, 999) }})</span>
                    </div>

                    <p class="text-gray-600 dark:text-gray-400 text-sm mb-1 line-clamp-3 max-w-3xl">
                        {{ $product->description }}
                    </p>
                </div>

                <!-- Rechts: Prijs & buttons -->
                <div class="flex flex-col items-start justify-between ml-6 min-w-[120px]">
                    <div>
                        <span class="text-2xl font-extrabold text-yellow-600">
                          {{ number_format($product->price, 2, ',', '.') }}
                        </span>

                        <div class="flex justify-start space-x-4 mt-4 items-center">
                            <span class="text-sm text-green-700 font-semibold border border-green-700 px-2 py-0.5 rounded">
                                In Stock
                            </span>

                            @if (in_array($index, $premiumIndexes))
                                <svg xmlns="http://www.w3.org/2000/svg" width="100" height="32" viewBox="0 0 120 32" class="rounded-md">
                                    <rect x="0" y="0" width="120" height="32" rx="6" fill="#e6c200"/>
                                    <text x="60" y="21" font-size="16" font-family="Arial, sans-serif" fill="#000"
                                          text-anchor="middle" font-weight="bold">
                                        Premium+
                                    </text>
                                </svg>
                            @endif
                        </div>

                        <span class="text-xs text-black dark:text-black mt-1">
                          Order by today 23:59, get it tomorrow
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                 stroke="currentColor" class="size-6"> <path stroke-linecap="round"
                                                                             stroke-linejoin="round"
                                                                             d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z"/>
                            </svg>
                        </span>
                    </div>

                    <div class="flex space-x-2 mt-4">
                        <button
                            wire:click="addToCart({{ $product->id }})"
                            class="flex items-center gap-x-2 bg-yellow-400 p-3 rounded-md shadow hover:bg-yellow-500 transition cursor-pointer text-black">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                 stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                 stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z"/>
                            </svg>
                        </button>
                        <button
                            wire:click="addToWishlist"
                            class="p-3 rounded-md border border-gray-300 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer transition">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                 stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
        <div id="pagination" class="mt-8">
            {{ $products->links() }}
        </div>

    </div>
</div>
