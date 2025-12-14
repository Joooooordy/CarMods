<section class="w-full">
    <x-settings.layout :heading="__('Order Details')" :subheading="__('Review your order and details below')"
                       content-class="w-full">

        @if(!$order)
            <p class="text-gray-500">{{ __('No order found.') }}</p>
        @else
            {{-- Order Info --}}
            <div class="mb-8 border rounded-lg shadow p-6 bg-white dark:bg-gray-800">
                <h2 class="text-xl font-bold mb-4">{{ __('Order Information') }}</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p><span class="font-semibold">{{ __('Order Number:') }}</span> {{ $order->order_number }}</p>
                        <p><span class="font-semibold">{{ __('Status:') }}</span> {{ ucfirst($order->status) }}</p>
                        <p><span class="font-semibold">{{ __('Placed on:') }}</span> {{ $order->created_at->format('d M Y H:i') }}</p>
                        <p><span class="font-semibold">{{ __('Total:') }}</span> € {{ number_format($order->total, 2) }}</p>
                    </div>
                    <div>
                        <p><span class="font-semibold">{{ __('Payment Method:') }}</span> {{ strtoupper($order->payment->payment_method ?? 'N/A') }}</p>
                        <p><span class="font-semibold">{{ __('Payment Status:') }}</span> {{ ucfirst($order->payment->status ?? 'N/A') }}</p>
                        <p><span class="font-semibold">{{ __('Paid at:') }}</span> {{ optional($order->payment->paid_at)->format('d M Y H:i') ?? 'N/A' }}</p>
                        <p><span class="font-semibold">{{ __('Currency:') }}</span> {{ $order->payment->currency ?? 'EUR' }}</p>
                    </div>
                </div>
            </div>

            {{-- User Info --}}
            <div class="mb-8 border rounded-lg shadow p-6 bg-white dark:bg-gray-800">
                <h2 class="text-xl font-bold mb-4">{{ __('Customer Information') }}</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p><span class="font-semibold">{{ __('Name:') }}</span> {{ $order->user->name }}</p>
                        <p><span class="font-semibold">{{ __('Email:') }}</span> {{ $order->user->email }}</p>
                        <p><span class="font-semibold">{{ __('Phone:') }}</span> {{ $order->user->phone_number ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p><span class="font-semibold">{{ __('Address:') }}</span></p>
                        @if($order->user->address)
                            <p class="">{{ $order->user->address->street }} {{ $order->user->address->house_nr ?? '' }}</p>
                            <p class="">{{ $order->user->address->zipcode }} {{ $order->user->address->city }}</p>
                            <p class="">{{ $order->user->address->state }}, {{ $order->user->address->country }}</p>
                        @else
                            <p class="ml-4">{{ __('N/A') }}</p>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Cart / Products --}}
            <div class="mb-8 border rounded-lg shadow p-6 bg-white dark:bg-gray-800">
                <h2 class="text-xl font-bold mb-4">{{ __('Ordered Products') }}</h2>
                <div class="space-y-4">
                    @foreach($order->products ?? [] as $item)
                        <div class="flex items-center justify-between border-b pb-2">
                            <div class="flex items-center gap-4">
                                <img src="{{ image_url($item->id) ?? 'https://via.placeholder.com/80' }}" alt="{{ $item['name'] }}" class="w-16 h-16 object-cover rounded-md">
                                <div>
                                    <p class="font-semibold">{{ $item['name'] }}</p>
                                    <p class="text-gray-500 text-sm">Qty: {{ $item['quantity'] }}</p>
                                </div>
                            </div>
                            <div>
                                <p class="font-semibold">€ {{ number_format($item['price'], 2) }}</p>
                                @if(isset($item['shipping_cost']))
                                    <p class="text-sm text-gray-500">{{ __('Shipping: €') }}{{ number_format($item['shipping_cost'], 2) }}</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Totals --}}
                <div class="mt-6 border-t pt-4 space-y-2 text-right">
                    <p>{{ __('Subtotal:') }} € {{ $order->subtotal }}</p>
                    <p>{{ __('Shipping:') }} € {{ number_format($order->products->sum(fn($product) => $product->pivot->shipping_cost) ?? 0, 2) }}</p>
                    @if($totalDiscount > 0)
                        <p>{{ __('Discount:') }} - € {{ number_format($order->products->sum(fn($product) => $product->pivot->discount_amount ?? 0), 2) }}</p>
                    @endif
                    <p class="font-bold text-lg">{{ __('Total:') }} € {{ number_format($order->total, 2) }}</p>
                </div>
            </div>

            <div class="text-center mt-6">
                <flux:button
                    href="{{ route('home') }}"
                    variant="primary"
                    class="px-6 py-3">
                    {{ __('Back to Shop') }}
                </flux:button>

                <flux:button
                    variant="primary"
                    href="{{ route('settings.user-orders') }}"
                    class="w-full md:w-auto">
                    {{ __('Back to My Orders') }}
                </flux:button>
            </div>

        @endif

    </x-settings.layout>
</section>
