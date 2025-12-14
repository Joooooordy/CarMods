<section class="w-full max-w-3xl mx-auto mt-16 px-4">
    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-xl p-8 text-center space-y-6">
        <!-- Success Icon -->
        <div class="flex justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
            </svg>
        </div>

        <!-- Heading -->
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
            {{ __('Order Confirmed!') }}
        </h1>

        <!-- Subheading -->
        <p class="text-gray-600 dark:text-gray-300">
            {{ __('Thank you for your purchase. Your order has been successfully placed.') }}
        </p>

        <!-- Order Summary -->
        <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-6 space-y-4">
            <div class="flex justify-between text-gray-700 dark:text-gray-200 font-medium">
                <span>{{ __('Order Number') }}</span>
                <span class="font-semibold">{{ $order->order_number }}</span>
            </div>
            <div class="flex justify-between text-gray-700 dark:text-gray-200 font-medium">
                <span>{{ __('Total Paid') }}</span>
                <span class="font-semibold">€ {{ number_format($order->total, 2) }}</span>
            </div>
            <div class="flex justify-between text-gray-700 dark:text-gray-200 font-medium">
                <span>{{ __('Payment Method') }}</span>
                <span class="font-semibold">{{ strtoupper($order->payment->payment_method ?? 'N/A') }}</span>
            </div>
            <div class="flex justify-between text-gray-700 dark:text-gray-200 font-medium">
                <span>{{ __('Status') }}</span>
                <span class="font-semibold capitalize">{{ $order->status }}</span>
            </div>
        </div>

        <!-- Buttons -->
        <div class="flex flex-col md:flex-row justify-center gap-4 mt-6">
            <flux:button
                variant="primary"
                href="{{ route('shop') }}"
                class="w-full md:w-auto">
                {{ __('Continue Shopping') }}
            </flux:button>

            <flux:button
                variant="ghost"
                href="{{ route('settings.user-order-details', $order->id) }}"
                class="w-full md:w-auto">
                {{ __('View My Order') }}
            </flux:button>
        </div>
    </div>
</section>
