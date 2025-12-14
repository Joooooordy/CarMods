<section class="w-full">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('My Vehicles')" :subheading="__('View and configure your vehicles here')"
                       content-class="w-full">
        @if($vehicles->isEmpty())
            <p class="text-gray-500">{{ __('No vehicles found.') }}</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($vehiclesWithFormattedFields as $item)
                    <div class="border rounded-lg p-4 shadow hover:shadow-lg transition">
                        <h2 class="text-xl font-bold">
                            {{ $item['vehicle']->kenteken->formatted_licenseplate ?? 'N/A' }}
                        </h2>

                        @if($item['formattedFields'])
                            <ul class="mt-2 space-y-1 text-gray-700">
                                @foreach($item['formattedFields'] as $field)
                                    <li class="flex justify-between pb-2">
                                        <div class="text-gray-600 dark:text-gray-400 font-medium">{{ $field['label'] }}</div>
                                        <div class="text-gray-900 dark:text-white text-left font-semibold break-words">
                                            {{ $field['value'] ?: __('N/A') }}
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </x-settings.layout>
</section>
