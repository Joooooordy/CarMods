<div class="max-w-7xl mx-auto p-8 bg-white rounded-lg shadow-lg border border-gray-200">
    @livewire('checkout.checkout-progress')

    <div class="flex flex-col lg:flex-row gap-8">

        {{-- LINKS: Formulier --}}
        <div class="flex-1">

            {{-- Shipping tab --}}
            <div class="mb-6 border border-gray-200 rounded-md p-4">
                <div class="flex items-center space-x-2 text-sm text-gray-700 mb-2">
                    <span class="bg-gray-200 rounded-md px-3 py-1">{{ __('Shipping') }}</span>
                    <span>{{ __('Flat rate:') }} <strong>€ {{ number_format($shippingCost ?? 0, 2, ',', '.') }}</strong></span>
                </div>
            </div>

            {{-- Payment methods --}}
            <form wire:submit.prevent="submit" class="bg-gray-50 rounded-md p-6 shadow-inner" novalidate>
                @csrf

                <fieldset class="space-y-6 mb-6">
                    <legend class="text-lg font-semibold text-gray-800 mb-4">{{ __('Choose your payment method') }}</legend>

                    <flux:radio.group class="flex flex-col gap-3">
                        @foreach($paymentMethods as $key => $label)
                            <div>
                                <flux:radio
                                    value="{{ $key }}"
                                    label="{{ $label }}"
                                    label-class="cursor-pointer"
                                    wire:click="selectPaymentMethod('{{ $key }}')"
                                    class="text-gray-900 font-medium"
                                />

                                <div class="{{ $paymentMethod === 'cc' && $key === 'cc' ? 'block' : 'hidden' }}">
                                    <div class="flex items-center gap-2">
                                        @if ($this->cardType === 'amex' && strlen($this->cc_cvv) === 4)
                                            @svg('fab-cc-amex', 'mt-8 ml-[16px] w-16 h-16 text-indigo-600')
                                        @elseif ($this->cardType === 'visa')
                                            @svg('fab-cc-visa', 'mt-8 ml-[16px] w-16 h-16 text-blue-600')
                                        @elseif ($this->cardType === 'mastercard')
                                            @svg('fab-cc-mastercard', 'mt-8 ml-[16px] w-16 h-16 text-red-600')
                                        @endif
                                    </div>

                                    <div class="mt-3 p-4 rounded-md space-y-4 max-w-3xl">
                                        {{-- Card Number --}}
                                        <flux:input
                                            :label="__('Card Number')"
                                            :badge="__('Required')"
                                            type="text"
                                            icon="credit-card"
                                            :placeholder="__('1234 1234 1234 1234')"
                                            wire:model.blur="cc_number"
                                            mask="9999 9999 9999 9999"
                                            input-class="w-full rounded-md border-gray-300 p-2 focus:outline-none focus:ring-2 focus:ring-purple-500"
                                            autocomplete="cc-number"
                                            error-key="cc_number"
                                            required
                                        />

                                        <div class="flex gap-4">
                                            <div class="flex-1">
                                                <flux:input
                                                    :label="__('Expiry Date')"
                                                    :badge="__('Required')"
                                                    type="text"
                                                    :placeholder="__('MM / YY')"
                                                    icon="calendar"
                                                    wire:model.blur="cc_expiry"
                                                    input-class="w-full rounded-md border-gray-300 p-2 focus:outline-none focus:ring-2 focus:ring-purple-500"
                                                    autocomplete="cc-exp"
                                                    mask="99 / 99"
                                                    error-key="cc_expiry"
                                                    maxlength="9"
                                                    required
                                                />
                                            </div>

                                            <div class="flex-1">
                                                <flux:input
                                                    :label="__('CVC')"
                                                    :badge="__('Required')"
                                                    type="text"
                                                    :placeholder="__('CVC')"
                                                    icon="lock-closed"
                                                    wire:model.blur="cc_cvv"
                                                    input-class="w-full rounded-md border border-gray-300 p-2 focus:outline-none focus:ring-2 focus:ring-purple-500"
                                                    autocomplete="cc-csc"
                                                    error-key="cc_cvv"
                                                    maxlength="{{ $this->cardType === 'amex' ? 4 : 3 }}"
                                                    required
                                                />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </flux:radio.group>
                </fieldset>

                <p class="text-xs text-gray-600 mb-6">
                    {{ __('Your personal data will be used to process your order, support your experience throughout this website, and for other purposes described in our') }}
                    <a href="#" class="text-purple-600 underline">{{ __('privacy policy') }}</a>.
                </p>

                <button
                    type="submit"
                    wire:click="submit"
                    class="w-full bg-purple-700 hover:bg-purple-800 text-white font-semibold py-3 rounded-md transition cursor-pointer">
                    {{ __('PLACE ORDER') }}
                </button>
            </form>
        </div>

        {{-- RECHTS: Order overzicht --}}
        <aside class="w-full lg:w-96 bg-white border rounded-lg p-6 shadow-sm">
            <h2 class="font-bold text-2xl mb-4">{{ __('Overview') }}</h2>

            {{-- Artikelen lijst --}}
            <div class="overflow-y-auto max-h-60 mb-4">
                <table class="w-full">
                    <thead>
                    <tr>
                        <th class="border-b border-gray-300 pb-2 text-left text-[18px]">{{ __('Product') }}</th>
                        <th class="border-b border-gray-300 pb-2 text-right text-[18px]">{{ __('Subtotal') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($cart as $item)
                        <tr>
                            <td class="border-b border-gray-200 py-2">
                                <p class="font-semibold text-gray-800">{{ $item['name'] }}</p>
                                <p class="text-sm text-gray-600">{{ __('Items:') }} {{ $item['quantity'] }}</p>
                            </td>
                            <td class="border-b border-gray-200 py-2 text-right font-semibold">
                                € {{ number_format($item['price'] * $item['quantity'], 2, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Subtotaal --}}
            @php
                $subtotal = collect($cart)->sum(fn($i) => $i['price'] * $i['quantity']);
                $discount = $discountAmount ?? 0;
                $total = $subtotal + ($shippingCost ?? 0) - $discount;
            @endphp

            <div class="flex justify-between mb-2 text-sm">
                <span>{{ __('Subtotal') }}</span>
                <span class="font-semibold">€ {{ number_format($subtotal, 2, ',', '.') }}</span>
            </div>

            {{-- Shipping --}}
            <div class="flex justify-between mb-2 text-sm">
                <span>{{ __('Shipping') }}</span>
                <span class="text-green-600 font-semibold">€ {{ number_format($shippingCost ?? 0, 2, ',', '.') }}</span>
            </div>

            {{-- Discount --}}
            @if ($discount > 0)
                <div class="flex justify-between mb-2 text-sm text-amber-700">
                    <span>{{ __('Discount') }}</span>
                    <span class="font-semibold">-€ {{ number_format($discount, 2, ',', '.') }}</span>
                </div>
            @endif

            <hr class="my-4"/>

            {{-- Discount code --}}
            <div class="mb-6">
                <x-input
                    :label="__('Do you have a discount code?')"
                    icon="percent-badge"
                    :placeholder="__('CARMODS20')"
                    wire:model="discountCode"
                    borderless
                />

                <x-button
                    wire:click="applyDiscount"
                    icon="check"
                    :label="__('Apply')"
                    class="mt-2 w-full bg-yellow-500 hover:bg-yellow-600 text-white justify-center"
                />

                @if (session()->has('discountMessage'))
                    <p class="text-green-600 font-semibold text-sm mt-2">{{ session('discountMessage') }}</p>
                @endif
            </div>

            {{-- Total --}}
            <div class="bg-yellow-100 p-3 rounded-md flex justify-between items-center mb-6">
                <span class="font-semibold text-lg">{{ __('Total to pay:') }}</span>
                <span class="font-bold text-xl">€ {{ number_format($total, 2, ',', '.') }}</span>
            </div>
        </aside>
    </div>
</div>
