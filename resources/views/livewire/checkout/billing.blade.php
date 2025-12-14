<div class="max-w-7xl mx-auto p-8 bg-white rounded-lg shadow-lg border border-gray-200">
    @livewire('checkout.checkout-progress')

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <flux:field>
            <flux:label :badge="__('Required')">{{ __('First Name') }}</flux:label>
            <flux:input :placeholder="__('River')" wire:model="first_name" required />
            <flux:error name="first_name" />
        </flux:field>

        <flux:field>
            <flux:label :badge="__('Required')">{{ __('Last Name') }}</flux:label>
            <flux:input :placeholder="__('Porzio')" wire:model="last_name" required />
            <flux:error name="last_name" />
        </flux:field>

        <flux:field class="md:col-span-2">
            <flux:label :badge="__('Required')">{{ __('Email') }}</flux:label>
            <flux:input type="email" :placeholder="__('example@gmail.com')" wire:model="email" required />
            <flux:error name="email" />
        </flux:field>

        <flux:field class="md:col-span-2">
            <flux:label :badge="__('Required')">{{ __('Phone Number') }}</flux:label>
            <flux:input :placeholder="__('(06) 12 34 56 78')" mask="(99) 99 99 99 99" wire:model="phone_number" required/>
            <flux:error name="phone_number" />
        </flux:field>

        <flux:fieldset class="md:col-span-2">
            <div class="space-y-6">
                <flux:field>
                    <flux:label :badge="__('Optional')">{{ __('Company') }}</flux:label>
                    <flux:input :placeholder="__('Company Inc.')" wire:model="company_name" />
                    <flux:error name="company_name" />
                </flux:field>

                <flux:field>
                    <flux:label :badge="__('Required')">{{ __('Country') }}</flux:label>
                    <flux:select wire:model="country" required>
                        <option value="US">{{ __('United States') }}</option>
                        <option value="NL">{{ __('Netherlands') }}</option>
                        <option value="BE">{{ __('Belgium') }}</option>
                        <option value="DE">{{ __('Germany') }}</option>
                    </flux:select>
                    <flux:error name="country" />
                </flux:field>

                <flux:field>
                    <flux:label :badge="__('Required')">{{ __('Street address') }}</flux:label>
                    <flux:input :placeholder="__('Boterstraat 123')" wire:model="street_address" required />
                    <flux:error name="street_address" />
                </flux:field>

                <flux:field>
                    <flux:label :badge="__('Optional')">{{ __('Apartment, studio, or floor') }}</flux:label>
                    <flux:input :placeholder="__('Apartment, studio, or floor')" wire:model="apartment" />
                    <flux:error name="apartment" />
                </flux:field>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <flux:field>
                        <flux:label :badge="__('Required')">{{ __('City') }}</flux:label>
                        <flux:input :placeholder="__('Rotterdam')" wire:model="city" required />
                        <flux:error name="city" />
                    </flux:field>

                    <flux:field>
                        <flux:label :badge="__('Required')">{{ __('State / Province') }}</flux:label>
                        <flux:input :placeholder="__('ZH')" wire:model="state" required />
                        <flux:error name="state" />
                    </flux:field>

                    <flux:field>
                        <flux:label :badge="__('Required')">{{ __('Postal / Zip code') }}</flux:label>
                        <flux:input :placeholder="__('1234 AB')" wire:model="postal_code" required />
                        <flux:error name="postal_code" />
                    </flux:field>
                </div>
            </div>
        </flux:fieldset>
    </div>

    <div class="mt-8 flex justify-end">
        <button
            wire:click="saveBilling"
            class="bg-yellow-500 hover:bg-yellow-600 text-white text-center py-3 px-6 rounded-lg font-semibold shadow-md transition duration-200 ease-in-out cursor-pointer">
            {{ __('Continue to shipping') }}
        </button>
    </div>
</div>
