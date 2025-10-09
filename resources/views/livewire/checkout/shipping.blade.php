<div class="max-w-7xl mx-auto p-8 bg-white rounded-lg shadow-lg border border-gray-200">
    @livewire('checkout.checkout-progress')

    <flux:field variant="inline" class="items-center gap-4 px-4 py-3 border rounded-lg shadow-sm bg-white mb-8">
        <span class="text-lg font-semibold text-gray-800 flex justify-between items-center w-full">
            Ship to a different address?
            <flux:switch wire:model.live="different_address" class="hover:cursor-pointer"/>
        </span>

        <flux:error name="different_address"/>
    </flux:field>

    @if($different_address)
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <flux:field>
                <flux:label badge="Required">First Name</flux:label>
                <flux:input placeholder="River" wire:model.defer="first_name" required />
                <flux:error name="first_name" />
            </flux:field>

            <flux:field>
                <flux:label badge="Required">Last Name</flux:label>
                <flux:input placeholder="Porzio" wire:model.defer="last_name" required />
                <flux:error name="last_name" />
            </flux:field>

            <flux:field class="md:col-span-2">
                <flux:label badge="Required">Email</flux:label>
                <flux:input type="email" placeholder="example@gmail.com" wire:model.defer="email" required />
                <flux:error name="email" />
            </flux:field>

            <flux:field class="md:col-span-2">
                <flux:label badge="Required">Phone Number</flux:label>
                <flux:input placeholder="(555) 555-5555" mask="(999) 999-9999" wire:model.defer="phone_number" required/>
                <flux:error name="phone_number" />
            </flux:field>

            <flux:fieldset class="md:col-span-2">
                <div class="space-y-6">
                    <flux:field>
                        <flux:label badge="Optional">Company</flux:label>
                        <flux:input placeholder="Company Inc." wire:model.defer="company_name" />
                        <flux:error name="company_name" />
                    </flux:field>

                    <flux:field>
                        <flux:label badge="Required">Country</flux:label>
                        <flux:select wire:model.defer="country" required>
                            <option value="US">United States</option>
                            <option value="NL">Netherlands</option>
                            <option value="BE">Belgium</option>
                            <option value="DE">Germany</option>
                        </flux:select>
                        <flux:error name="country" />
                    </flux:field>

                    <flux:field>
                        <flux:label badge="Required">Street address</flux:label>
                        <flux:input placeholder="123 Main St" wire:model.defer="street_address" required />
                        <flux:error name="street_address" />
                    </flux:field>

                    <flux:field>
                        <flux:input placeholder="Apartment, studio, or floor" wire:model.defer="apartment" />
                        <flux:error name="apartment" />
                    </flux:field>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <flux:field>
                            <flux:label badge="Required">City</flux:label>
                            <flux:input placeholder="San Francisco" wire:model.defer="city" required />
                            <flux:error name="city" />
                        </flux:field>

                        <flux:field>
                            <flux:label badge="Required">State / Province</flux:label>
                            <flux:input placeholder="CA" wire:model.defer="state" required />
                            <flux:error name="state" />
                        </flux:field>

                        <flux:field>
                            <flux:label badge="Required">Postal / Zip code</flux:label>
                            <flux:input placeholder="12345" wire:model.defer="postal_code" required />
                            <flux:error name="postal_code" />
                        </flux:field>
                    </div>
                </div>
            </flux:fieldset>
        </div>
    @endif

    <div class="mt-8 flex justify-end">
        <button wire:click="saveShipping"
                class="bg-yellow-500 hover:bg-yellow-600 text-white text-center py-3 px-6 rounded-lg font-semibold shadow-md transition duration-200 ease-in-out cursor-pointer">
            Continue to payment
        </button>
    </div>
</div>
