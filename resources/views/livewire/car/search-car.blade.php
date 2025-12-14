<div>
    <div class="container mx-auto px-4 py-12 max-w-3xl">
        <!-- Header -->
        <div class="text-center mb-12">
            <div class="flex justify-center mb-6">
                <img src="{{ asset('img/CarMods.svg') }}"
                     alt="{{ __('CarMods Logo') }}"
                     class="h-75 w-75 object-contain drop-shadow-md"/>
            </div>
            <p class="text-gray-600 dark:text-gray-300 text-lg">
                {{ __('Log your car and its mods. View and share your build with the community.') }}
            </p>
        </div>

        <!-- Success Message -->
        @if (session()->has('success'))
            <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-800 rounded-lg shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <!-- Kenteken Zoek -->
        <div class="bg-white dark:bg-gray-900 shadow-xl rounded-2xl p-8 space-y-6 border border-gray-200 dark:border-gray-700">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-4">{{ __('Add your vehicle') }}</h2>

            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                {{ __('Search by License plate number (NL)') }}
            </label>

            <!-- Kentekenplaat stijl -->
            <div
                class="flex overflow-hidden rounded-lg border border-gray-400 dark:border-gray-600 bg-amber-400 dark:bg-gray-700 focus-within:ring-2 focus-within:ring-blue-500 transition">
                <div class="bg-blue-600 px-4 flex items-center justify-center text-white font-bold text-xl w-16">
                    NL
                </div>
                <input type="text"
                       id="licensePlateInput"
                       wire:model.live="licensePlate"
                       placeholder="{{ __('XX-123-X') }}"
                       maxlength="8"
                       class="licenseplateinput font-kenteken text-4xl text-center font-bold uppercase w-full h-20 bg-transparent text-gray-900 dark:text-white focus:outline-none px-4"/>
            </div>

            @error('licensePlate')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror

            <div class="text-center pt-6">
                <button type="button"
                        wire:click="lookupPlate"
                        wire:loading.attr="disabled"
                        class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold px-6 py-3 rounded-lg shadow-md transition w-full">
                        <span wire:loading.remove>
                            {{ __('Search') }}
                        </span>
                        <span wire:loading>
                           <flux:icon.loading class="w-5 h-5 text-white animate-spin" />
                        </span>
                </button>
            </div>

            <!-- Feedback messages -->
            @if($message)
                <div
                    class="mt-4 text-center text-sm font-semibold {{ $vehicleData ? 'text-green-600' : 'text-red-600' }}">
                    {{ $message }}
                </div>
            @endif
        </div>
    </div>
</div>
