<x-layouts.app>
    <div class="max-w-4xl mx-auto mt-12 px-4">
        @if($vehicleData)
            {{-- Header --}}
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
                           <flux:icon.loading class="w-5 h-5 text-white animate-spin"/>
                        </span>
                    </button>
                </div>
            </div>

            {{-- Snelle Check --}}
            <div class="mt-10 dark:bg-black bg-white dark:text-white text-black rounded-2xl p-6 shadow-xl">
                <h2 class="text-xl font-semibold">Snelle check</h2>
                <p class="mb-4 pb-3 border-b-1 border-black">Waarde-indicatie, onderhoud en meer</p>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6 text-sm">
                    <div class="icon" data-darkbgimage="url('https://finnik.nl/svg/pricegraph/405E7A.svg')">
                        <span class="block text-gray-400">Waarde-indicatie</span>
                        <span
                            class="text-lg font-medium">€{{ number_format($vehicleData['catalogusprijs'], 0, ',', '.') ?? 'N/A' }}</span>
                    </div>


                    <div class="icon" data-darkbgimage="url('https://finnik.nl/svg/garage/405E7A.svg')">
                        <span class="block text-gray-400">Datum APK</span>
                        <span class="text-lg font-medium">
                {{ \Carbon\Carbon::parse($vehicleData['vervaldatum_apk_dt'] ?? '')->format('d-m-Y') ?? 'N/A' }}
            </span>
                    </div>

                    <div class="icon" data-darkbgimage="url('https://finnik.nl/svg/cars/405E7A.svg')">
                        <span class="block text-gray-400">Aantal Cilinders</span>
                        <span class="text-lg font-medium">{{ $vehicleData['aantal_cilinders'] ?? 'N/A' }}</span>
                    </div>

                    <div class="icon" data-darkbgimage="url('https://finnik.nl/svg/speed/405E7A.svg')">
                        <span class="block text-gray-400">Topsnelheid</span>
                        <span class="text-lg font-medium">{{ $vehicleData['maximale_constructiesnelheid'] ?? 'N/A' }} km/u</span>
                    </div>

                    <div class="icon" data-darkbgimage="url('https://finnik.nl/svg/owners/405E7A.svg')">
                        <span class="block text-gray-400">Aantal eigenaren</span>
                        <span class="text-lg font-medium">{{ $vehicleData['aantal_eigenaren'] ?? 'N/A' }}</span>
                    </div>

                    <div class="icon" data-darkbgimage="url('https://finnik.nl/svg/taxi/405E7A.svg')">
                        <span class="block text-gray-400">Taxi?</span>
                        <span class="text-lg font-medium">{{ $vehicleData['taxi_indicator'] ?? 'Nee' }}</span>
                    </div>

                    <div class="icon" data-darkbgimage="url('https://finnik.nl/svg/calendar/405E7A.svg')">
                        <span class="block text-gray-400">Bouwjaar</span>
                        <span class="text-lg font-medium">
                {{ \Carbon\Carbon::parse($vehicleData['datum_eerste_toelating'] ?? '')->format('Y') ?? 'N/A' }}
            </span>
                    </div>

                    <div class="icon" data-darkbgimage="url('https://finnik.nl/svg/netherlands/405E7A.svg')">
                        <span class="block text-gray-400">Geïmporteerd?</span>
                        <span class="text-lg font-medium">{{ $vehicleData['import_indicator'] ?? 'Nee' }}</span>
                    </div>

                    <div class="icon" data-darkbgimage="url('https://finnik.nl/svg/netherlands/405E7A.svg')">
                        <span class="block text-gray-400">Eerste toelating nationaal</span>
                        <span class="text-lg font-medium">
                {{ \Carbon\Carbon::parse($vehicleData['datum_eerste_tenaamstelling_in_nederland_dt'] ?? '')->format('d-m-Y') ?? 'N/A' }}
            </span>
                    </div>
                </div>
            </div>



            {{-- Alle voertuiggegevens --}}
            <div class="mt-10 bg-white dark:bg-gray-900 shadow-xl rounded-2xl p-8 border border-gray-200 dark:border-gray-700">
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Alle voertuiggegevens</h2>
                <p class="mb-8 pb-3 border-b-1 border-black">Vermogen, snelheid, gewicht en meer</p>

                <dl class="grid grid-cols-1 sm:grid-cols-1 gap-x-12 gap-y-6 text-md">
                    @foreach($vehicleData as $key => $value)
                        @php
                            // Sla API-velden over
                            if (Str::startsWith($key, ['api_', 'registratie'])) continue;
                            if (Str::endsWith($key, ['_dt'])) continue;

                            // Omschrijving netjes formatteren
                            $label = Str::of($key)->replace('_', ' ')->title();

                            // Check of het een datumveld is
                            $isDate = Str::endsWith($key, ['_dt', '_datum']) || Str::startsWith($key, ['datum_', 'vervaldatum_']);
                            $formattedValue = $value;

                            // Format als datum indien nodig
                            if ($isDate && $value) {
                                try {
                                    $formattedValue = \Carbon\Carbon::parse($value)->format('d-m-Y');
                                } catch (Exception $e) {}
                            }

                            // Format als numeriek indien mogelijk
                            elseif (is_numeric($value)) {
                                // Valuta-velden
                                if (Str::contains($key, ['catalogusprijs', 'bpm'])) {
                                    $formattedValue = '€ ' . number_format($value, 0, '.', ',');
                                }
                                // Massa/inhoud in kg/cm³/liter etc.
                                elseif (Str::contains($key, ['massa', 'inhoud', 'gewicht'])) {
                                    $formattedValue = number_format($value, 0, ',', ',') . ' kg';
                                }
                                // Snelheid
                                elseif (Str::contains($key, ['snelheid'])) {
                                    $formattedValue = number_format($value, 0, ',', ',') . ' km/u';
                                }
                                // Vermogen
                                elseif (Str::contains($key, ['vermogen'])) {
                                    $formattedValue = number_format($value, 0, ',', ',') . ' kW';
                                }
                                // Standaard getallen
                                else {
                                    $formattedValue = number_format($value, 0, ',', ',');
                                }
                            }
                        @endphp

                        <div class="flex justify-between pb-2">
                            <dt class="text-gray-600 dark:text-gray-400 font-medium">{{ $label }}</dt>
                            <dd class="text-gray-900 dark:text-white text-left font-semibold break-words">
                                {{ $formattedValue ?: 'N/A' }}
                            </dd>
                        </div>
                    @endforeach
                </dl>
            </div>
        @else
            {{-- Geen data --}}
            <div class="bg-yellow-100 text-yellow-800 p-6 rounded-xl text-center shadow-md">
                Geen voertuigdata beschikbaar.
            </div>
        @endif
    </div>
</x-layouts.app>
<script>
    const icons = document.querySelectorAll('.icon[data-darkbgimage]');
    icons.forEach(el => {
        const bg = el.getAttribute('data-darkbgimage');
        if (bg) {
            const url = bg.replace(/^url\(['"]?/, '').replace(/['"]?\)$/, '');
            const img = new Image();
            img.onload = () => {
                el.style.backgroundImage = bg;
            };
            img.onerror = () => {
                console.warn('Could not load', bg);
            };
            img.src = url;
        }
    });
</script>
