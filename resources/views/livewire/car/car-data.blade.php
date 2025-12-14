<div class="max-w-4xl mx-auto mt-12 px-4">
    @if($vehicleData)
        <div
            class="bg-white dark:bg-gray-900 shadow-xl rounded-2xl p-8 space-y-6 border border-gray-200 dark:border-gray-700">
            <h1 class="text-4xl font-bold text-gray-800 tracking-wide pb-8">
                {{ $vehicleData['merk'] ?? 'N/A' }} {{ $vehicleData['handelsbenaming'] ?? '' }}
            </h1>

            <div
                class="flex overflow-hidden rounded-lg border border-gray-400 dark:border-gray-600 bg-amber-400 dark:bg-gray-700 focus-within:ring-2 focus-within:ring-blue-500 transition">
                <div class="bg-blue-600 px-4 flex items-center justify-center text-white font-bold text-xl w-16">
                    NL
                </div>
                <input type="text"
                       id="licensePlateInputCarData"
                       placeholder="{{ $formattedLicensePlate ?? $vehicleData['kenteken'] }}"
                       maxlength="8"
                       class="licenseplateinputcardata font-kenteken text-4xl text-center font-bold uppercase w-full h-20 bg-transparent text-gray-900 dark:text-white focus:outline-none px-4 pointer-events-none"/>
            </div>

            <div class="flex justify-center mt-4">
                <button
                    type="button"
                    wire:click="addVehicle"
                    class="mb-4 px-5 py-2 bg-blue-600 text-white font-semibold rounded-lg shadow hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition-all duration-200 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-400">
                    {{ __('Add to my vehicles') }}
                </button>
            </div>

            @error('licensePlate')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        {{-- Snelle Check --}}
        <div class="mt-10 dark:bg-black bg-white dark:text-white text-black rounded-2xl p-6 shadow-xl">
            <h2 class="text-xl font-semibold">{{ __('Snelle check') }}</h2>
            <p class="mb-4 pb-3 border-b-1 border-black">{{ __('Waarde-indicatie, onderhoud en meer') }}</p>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6 text-sm">
                <div class="icon" data-darkbgimage="url('https://finnik.nl/svg/pricegraph/405E7A.svg')">
                    <span class="block text-gray-400">{{ __('Waarde-indicatie') }}</span>
                    <span
                        class="text-lg font-medium">€{{ number_format($vehicleData['catalogusprijs'], 0, ',', '.') ?? __('N/A') }}</span>
                </div>


                <div class="icon" data-darkbgimage="url('https://finnik.nl/svg/garage/405E7A.svg')">
                    <span class="block text-gray-400">{{ __('Datum APK') }}</span>
                    <span class="text-lg font-medium">
                {{ \Carbon\Carbon::parse($vehicleData['vervaldatum_apk_dt'] ?? '')->format('d-m-Y') ?? __('N/A') }}
            </span>
                </div>

                <div class="icon" data-darkbgimage="url('https://finnik.nl/svg/cars/405E7A.svg')">
                    <span class="block text-gray-400">{{ __('Aantal Cilinders') }}</span>
                    <span class="text-lg font-medium">{{ $vehicleData['aantal_cilinders'] ?? __('N/A') }}</span>
                </div>

                <div class="icon" data-darkbgimage="url('https://finnik.nl/svg/speed/405E7A.svg')">
                    <span class="block text-gray-400">{{ __('Topsnelheid') }}</span>
                    <span
                        class="text-lg font-medium">{{ $vehicleData['maximale_constructiesnelheid'] ?? __('N/A') }} {{ __('km/u') }}</span>
                </div>

                <div class="icon" data-darkbgimage="url('https://finnik.nl/svg/owners/405E7A.svg')">
                    <span class="block text-gray-400">{{ __('Aantal eigenaren') }}</span>
                    <span class="text-lg font-medium">{{ $vehicleData['aantal_eigenaren'] ?? __('N/A') }}</span>
                </div>

                <div class="icon" data-darkbgimage="url('https://finnik.nl/svg/taxi/405E7A.svg')">
                    <span class="block text-gray-400">{{ __('Taxi?') }}</span>
                    <span class="text-lg font-medium">{{ $vehicleData['taxi_indicator'] ?? __('Nee') }}</span>
                </div>

                <div class="icon" data-darkbgimage="url('https://finnik.nl/svg/calendar/405E7A.svg')">
                    <span class="block text-gray-400">{{ __('Bouwjaar') }}</span>
                    <span class="text-lg font-medium">
                {{ \Carbon\Carbon::parse($vehicleData['datum_eerste_toelating'] ?? '')->format('Y') ?? __('N/A') }}
            </span>
                </div>

                <div class="icon" data-darkbgimage="url('https://finnik.nl/svg/netherlands/405E7A.svg')">
                    <span class="block text-gray-400">{{ __('Geïmporteerd?') }}</span>
                    <span class="text-lg font-medium">{{ $vehicleData['import_indicator'] ?? __('Nee') }}</span>
                </div>

                <div class="icon" data-darkbgimage="url('https://finnik.nl/svg/netherlands/405E7A.svg')">
                    <span class="block text-gray-400">{{ __('Eerste toelating nationaal') }}</span>
                    <span class="text-lg font-medium">
                {{ \Carbon\Carbon::parse($vehicleData['datum_eerste_tenaamstelling_in_nederland_dt'] ?? '')->format('d-m-Y') ?? __('N/A') }}
            </span>
                </div>
            </div>
        </div>



        {{-- Alle voertuiggegevens --}}
        <div class="mt-10 text-center">
            <button id="toggleVehicleDataBtn"
                    class="mb-4 px-5 py-2 bg-blue-600 text-white font-semibold rounded-lg shadow hover:bg-blue-700 transition">
                {{ __('Load more data...') }}
            </button>

            <div id="vehicleDataContent"
                 class="hidden text-left bg-white dark:bg-gray-900 shadow-xl rounded-2xl p-8 border border-gray-200 dark:border-gray-700">
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white">{{ __('Alle voertuiggegevens') }}</h2>
                <p class="mb-8 pb-3 border-b-1 border-black">{{ __('Vermogen, snelheid, gewicht en meer') }}</p>

                <dl class="grid grid-cols-1 sm:grid-cols-1 gap-x-12 gap-y-6 text-md">
                    @foreach($formattedFields as $field)
                        <div class="flex justify-between pb-2">
                            <div class="text-gray-600 dark:text-gray-400 font-medium">{{ $field['label'] }}</div>
                            <div class="text-gray-900 dark:text-white text-left font-semibold break-words">
                                {{ $field['value'] ?: __('N/A') }}
                            </div>
                        </div>
                    @endforeach
                </dl>
            </div>
        </div>
    @else
        {{-- Geen data --}}
        <div class="bg-yellow-100 text-yellow-800 p-6 rounded-xl text-center shadow-md">
            {{ __('Geen voertuigdata beschikbaar.') }}
        </div>
    @endif
</div>

