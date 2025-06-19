<x-layouts.app>
    <div class="max-w-4xl mx-auto mt-12 px-4">
        @if($vehicleData)
            {{-- Header --}}
            <div class="bg-white dark:bg-gray-900 shadow-xl rounded-2xl p-8 space-y-6 border border-gray-200 dark:border-gray-700">
                <h1 class="text-4xl font-bold text-gray-800 tracking-wide pb-8">
                    {{ $vehicleData['merk'] ?? 'N/A' }} {{ $vehicleData['handelsbenaming'] ?? '' }}
                </h1>

                <div class="flex overflow-hidden rounded-lg border border-gray-400 dark:border-gray-600 bg-amber-400 dark:bg-gray-700 focus-within:ring-2 focus-within:ring-blue-500 transition">
                    <div class="bg-blue-600 px-4 flex items-center justify-center text-white font-bold text-xl w-16">
                        NL
                    </div>
                    <input type="text"
                           id="licensePlateInputCarData"
                           wire:model="licensePlate"
                           placeholder="{{ $formattedLicensePlate ?? $vehicleData['kenteken']}}"
                           maxlength="8"
                           class="licenseplateinputcardata font-kenteken text-4xl text-center font-bold uppercase w-full h-20 bg-transparent text-gray-900 dark:text-white focus:outline-none px-4"/>
                </div>

                @error('licensePlate')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror

                <div class="text-center pt-6 hidden" id="search_button_car_data">
                    <button type="button"
                            wire:click="lookupPlate"
                            wire:loading.attr="disabled"
                            class="bg-yellow-500 w-full hover:bg-yellow-600 text-white font-semibold px-6 py-3 rounded-lg shadow-md transition w-full">
                        <span wire:loading.remove>
                            Zoek Kenteken
                        </span>
                        <span wire:loading>
                           <flux:icon.loading class="w-5 h-5 text-white animate-spin" />
                        </span>
                    </button>
                </div>
            </div>

            {{-- Snelle Check --}}
            <div class="mt-10 bg-black text-white rounded-2xl p-6 shadow-xl">
                <h2 class="text-xl font-semibold mb-4">Snelle check</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-sm">

                    <div class="flex flex-col items-start">
                        <span class="text-gray-400">Nieuwwaarde</span>
                        <span class="text-lg font-medium">€{{ number_format($vehicleData['catalogusprijs']) ?? 'N/A' }}</span> {{-- hardcoded voor nu --}}
                    </div>

                    <div class="flex flex-col items-start">
                        <span class="text-gray-400">Datum APK</span>
                        <span class="text-lg font-medium">
                {{ \Carbon\Carbon::parse($vehicleData['vervaldatum_apk_dt'] ?? '')->format('d-m-Y') ?? 'N/A' }}
                        </span>
                    </div>

                    <div class="flex flex-col items-start">
                        <span class="text-gray-400">Topsnelheid</span>
                        <span class="text-lg font-medium">{{ $vehicleData['maximale_constructiesnelheid'] ?? 'N/A' }} km/u</span>
                    </div>

                    <div class="flex flex-col items-start">
                        <span class="text-gray-400">Taxi?</span>
                        <span class="text-lg font-medium">{{ $vehicleData['taxi_indicator'] ?? 'N/A' }}</span>
                    </div>

                    <div class="flex flex-col items-start">
                        <span class="text-gray-400">Bouwjaar</span>
                        <span class="text-lg font-medium">
                {{ \Carbon\Carbon::parse($vehicleData['datum_eerste_toelating'] ?? '')->format('Y') ?? 'N/A' }}
            </span>
                    </div>

                    <div class="flex flex-col items-start">
                        <span class="text-gray-400">Geïmporteerd?</span>
                        <span
                            class="text-lg font-medium">{{ $vehicleData['import_indicator'] ?? 'Nee' }}</span> {{-- "Nee" fallback --}}
                    </div>

                    <div class="flex flex-col items-start">
                        <span class="text-gray-400">Eerste toelating nationaal</span>
                        <span class="text-lg font-medium">
                {{ \Carbon\Carbon::parse($vehicleData['datum_eerste_tenaamstelling_in_nederland_dt'] ?? '')->format('d-m-Y') ?? 'N/A' }}
            </span>
                    </div>

                </div>
            </div>


            {{-- Voertuiggegevens --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-white shadow-xl rounded-2xl p-8 border border-gray-200 mt-8">
                <div>
                    <p class="text-sm text-gray-500 uppercase font-semibold mb-1">Merk</p>
                    <p class="text-lg text-gray-800">{{ $vehicleData['merk'] ?? 'N/A' }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-500 uppercase font-semibold mb-1">Model</p>
                    <p class="text-lg text-gray-800">{{ $vehicleData['handelsbenaming'] ?? 'N/A' }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-500 uppercase font-semibold mb-1">Inrichting</p>
                    <p class="text-lg text-gray-800">{{ $vehicleData['inrichting'] ?? 'N/A' }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-500 uppercase font-semibold mb-1">Kleur</p>
                    <p class="text-lg text-gray-800">{{ $vehicleData['eerste_kleur'] ?? 'N/A' }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-500 uppercase font-semibold mb-1">Aantal deuren</p>
                    <p class="text-lg text-gray-800">{{ $vehicleData['aantal_deuren'] ?? 'N/A' }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-500 uppercase font-semibold mb-1">Voertuigsoort</p>
                    <p class="text-lg text-gray-800">{{ $vehicleData['voertuigsoort'] ?? 'N/A' }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-500 uppercase font-semibold mb-1">Bouwjaar</p>
                    <p class="text-lg text-gray-800">
                        {{ \Carbon\Carbon::parse($vehicleData['datum_eerste_toelating'] ?? '')->format('Y') ?? 'N/A' }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-gray-500 uppercase font-semibold mb-1">APK tot</p>
                    <p class="text-lg text-gray-800">
                        {{ \Carbon\Carbon::parse($vehicleData['vervaldatum_apk_dt'] ?? '')->format('d-m-Y') ?? 'N/A' }}
                    </p>
                </div>
            </div>
        @else
            {{-- Geen data --}}
            <div class="bg-yellow-100 text-yellow-800 p-6 rounded-xl text-center shadow-md">
                Geen voertuigdata beschikbaar.
            </div>
        @endif
    </div>
</x-layouts.app>
