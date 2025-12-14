<section class="w-full">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('Profile')" :subheading="__('Update your profile information')" content-class="w-full">
        <form wire:submit="updateProfileInformation" class="my-6 w-full space-y-10">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-center">
                <div class="flex items-center space-x-6">
                    <!-- Avatar -->
                    <x-file wire:model.live="avatarFile" accept="image/png, image/jpeg" class="cursor-pointer">
                        <img src="{{ avatar_url(auth()->user()->id) }}"
                             class="w-32 h-32 rounded-full border-4 border-indigo-500 shadow-lg object-cover transition-transform duration-300 hover:scale-105"
                             alt="profile picture"/>
                    </x-file>

                    <!-- Label -->
                    <span class="text-sm text-gray-600 dark:text-gray-300 max-w-xs">
        {{ __('Click the image to choose a new avatar!') }}
    </span>
                </div>

                <!-- Persoonlijke gegevens -->
                <div class="md:col-span-2">
                    <flux:fieldset class="border border-gray-300 rounded-lg p-6 shadow-inner bg-white dark:bg-gray-800">
                        <flux:legend class="text-lg font-semibold text-indigo-600 mb-4">{{__('Personal Data')}}
                        </flux:legend>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <flux:input wire:model.live="name" :label="__('Name')" type="text" required autofocus
                                        autocomplete="name"
                                        class="rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition"/>
                            <flux:input wire:model.live="email" :label="__('Email')" type="email" required
                                        autocomplete="email"
                                        class="rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition"/>
                        </div>
{{--                         Birthdate--}}
{{--                                                <div class="grid grid-cols-1 md:grid-cols-3">--}}
{{--                                                    <x-aui::date-picker class="w-96" mode="single" />--}}
{{--                                                </div>--}}
                    </flux:fieldset>
                </div>
            </div>

            <!-- Email verificatie melding -->
            @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !auth()->user()->hasVerifiedEmail())
                <div class="text-sm text-red-600 space-y-2 px-4 py-3 bg-red-50 rounded-md border border-red-300">
                    <p>{{ __('Your email address is unverified.') }}</p>
                    <flux:link class="cursor-pointer underline font-semibold text-red-700 hover:text-red-900"
                               wire:click.prevent="resendVerificationNotification">
                        {{ __('Click here to re-send the verification email.') }}
                    </flux:link>
                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-semibold text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif

            <!-- Bankgegevens -->
            <flux:fieldset class="border border-gray-300 rounded-lg p-6 shadow-inner bg-white dark:bg-gray-800">
                <flux:legend class="text-lg font-semibold text-indigo-600 mb-4">{{__('Bankrecords')}}</flux:legend>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <flux:input wire:model.live="bank_account" :label="__('Bank account')" type="text" autocomplete="off"
                                class="rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition"/>
                </div>
            </flux:fieldset>

            <!-- Adresgegevens -->
            <flux:fieldset class="border border-gray-300 rounded-lg p-6 shadow-inner bg-white dark:bg-gray-800">
                <flux:legend class="text-lg font-semibold text-indigo-600 mb-4">{{__('Address')}}</flux:legend>
                <div class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <flux:input label="Street address" placeholder="123 Main St" wire:model.live="street"
                                    class="rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition"/>
                        <flux:input label="House number" placeholder="42A" wire:model.live="house_nr"
                                    class="rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition"/>
                    </div>
                    <div class="grid grid-cols-2 gap-x-4 gap-y-6">
                        <flux:input label="City" placeholder="Amsterdam" wire:model.live="city"
                                    class="rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition"/>
                        <flux:input label="State / Province" placeholder="Noord-Holland" wire:model.live="state"
                                    class="rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition"/>
                        <flux:input label="Postal / Zip code" placeholder="1234 AB" wire:model.live="zipcode"
                                    class="rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition"/>
                        <flux:select label="Country" wire:model.live="country"
                                     class="rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition">
                            <option value="Nederland">Nederland</option>
                            <option value="België">België</option>
                            <option value="Duitsland">Duitsland</option>
                        </flux:select>
                    </div>
                </div>
            </flux:fieldset>

            <!-- Opslaan knop -->
            <div class="flex justify-center pt-8">
                <flux:button variant="primary" type="submit" class="px-8 py-3 text-lg font-semibold rounded-lg shadow-md
                    bg-indigo-600 hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-300 focus:outline-none
                    text-white transition duration-300 ease-in-out">
                    {{ __('Save') }}
                </flux:button>
            </div>

            <hr class="border-2 border-r-2">
            <livewire:settings.delete-user-form/>

            <x-action-message class="me-3 text-green-600 font-medium" on="profile-updated">
                {{ __('Saved.') }}
            </x-action-message>
        </form>
    </x-settings.layout>
</section>
