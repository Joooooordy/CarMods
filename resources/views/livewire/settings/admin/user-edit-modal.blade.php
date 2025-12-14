<div>
    <flux:modal name="edit-user" wire:model.live="isOpen" focusable class="max-w-4xl">

    <form wire:submit="save" class="space-y-6">
            <div>
                <flux:heading size="lg">{{ __('Edit user') }}</flux:heading>
                <flux:subheading>
                    {{ __('Update user data. Changes are saved immediately to the database.') }}
                </flux:subheading>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <flux:input wire:model="name" :label="__('Name')" type="text" required />
                <flux:input wire:model="email" :label="__('Email')" type="email" required />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <flux:input wire:model="birthdate" :label="__('Birthdate')" type="date" />
                <flux:input wire:model="bank_account" :label="__('Bank account')" type="text" autocomplete="off" />
                <flux:select wire:model="role" :label="__('Role')" required>
                    <option value="">{{ __('Select a role') }}</option>
                    @foreach ($availableRoles as $availableRole)
                        <option value="{{ $availableRole['name'] }}">{{ $availableRole['name'] }}</option>
                    @endforeach
                </flux:select>
            </div>

            <div>
                <flux:input wire:model.live="avatarFile" :label="__('Avatar')" type="file" accept="image/png, image/jpeg" />
            </div>

            <flux:fieldset class="border border-gray-300 rounded-lg p-6 shadow-inner bg-white dark:bg-gray-800">
                <flux:legend class="text-lg font-semibold text-indigo-600 mb-4">{{ __('Address') }}</flux:legend>

                <div class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <flux:input wire:model="street" :label="__('Street address')" placeholder="123 Main St" />
                        <flux:input wire:model="house_nr" :label="__('House number')" placeholder="42A" />
                        <flux:input wire:model="zipcode" :label="__('Postal / Zip code')" placeholder="1234 AB" />
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <flux:input wire:model="city" :label="__('City')" placeholder="Amsterdam" />
                        <flux:input wire:model="state" :label="__('State / Province')" placeholder="Noord-Holland" />
                        <flux:input wire:model="country" :label="__('Country')" placeholder="Nederland" />
                    </div>
                </div>
            </flux:fieldset>

            <div class="flex justify-end space-x-2 rtl:space-x-reverse">
                <flux:button variant="filled" type="button" wire:click="close">
                    {{ __('Cancel') }}
                </flux:button>

                <flux:button variant="primary" type="submit">
                    {{ __('Save') }}
                </flux:button>
            </div>

            <x-action-message class="me-3 text-green-600 font-medium" on="admin-user-updated">
                {{ __('Saved.') }}
            </x-action-message>
        </form>
    </flux:modal>
</div>
