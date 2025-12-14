<section class="w-full">
    @include('partials.settings-heading')

    <x-settings.layout
        :heading="__('My Orders')"
        :subheading="__('View your orders here')"
        content-class="w-full"
    >
        @if($orders->isEmpty())
            <p class="text-gray-500 dark:text-gray-400">{{ __('No orders found.') }}</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($orders as $order)
                    <div class="bg-white dark:bg-gray-800 shadow-md rounded-xl p-6 border border-gray-200 dark:border-gray-700 transition-transform transform hover:scale-105">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-lg font-bold text-gray-800 dark:text-gray-100">
                                {{ __('Order #:') }} {{ $order->order_number }}
                            </h2>
                            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>

                        <div class="space-y-2">
                            <p>
                                <span class="font-semibold">{{ __('Total:') }}</span>
                                €{{ number_format($order->total, 2) }}
                            </p>
                            @if($order->payment)
                                <p>
                                    <span class="font-semibold">{{ __('Payment:') }}</span>
                                    {{ ucfirst($order->payment->status) }}
                                </p>
                                <p>
                                    <span class="font-semibold">{{ __('Method:') }}</span>
                                    {{ ucfirst(str_replace('_', ' ', $order->payment->payment_method)) }}
                                </p>
                            @endif
                        </div>

                        <div class="mt-4">
                            <flux:button
                                variant="primary"
                                wire:click="viewOrder({{ $order->id }})"
                                class="w-full justify-center py-2 px-4"
                            >
                                {{ __('View Details') }}
                            </flux:button>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </x-settings.layout>
</section>
