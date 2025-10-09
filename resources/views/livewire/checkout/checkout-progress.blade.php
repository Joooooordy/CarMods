<div class="w-full max-w-4xl mx-auto my-8">
    @php
        $steps = [
            1 => 'Billing',
            2 => 'Shipping',
            3 => 'Payment',
            4 => 'Order Overview',
        ];
        $totalSteps = count($steps);
    @endphp

    <div class="relative flex items-center justify-between">
        @foreach ($steps as $step => $label)
            <div class="relative flex-1 flex flex-col items-center">
                {{-- Lijn achter cirkel (links) --}}
                @if ($step > 1)
                    <div class="absolute top-4 left-0 w-1/2 h-0.5 z-0"
                         style="background-color: {{ $currentStep >= $step ? '#facc15' : '#d1d5db' }}"></div>
                @endif

                {{-- Cirkel --}}
                <div class="z-10 w-8 h-8 flex items-center justify-center rounded-full text-sm font-bold
                    {{ $currentStep >= $step ? 'bg-yellow-400 text-white' : 'bg-gray-300 text-gray-700' }}">
                    {{ $step }}
                </div>

                {{-- Lijn voor cirkel (rechts) --}}
                @if ($step < $totalSteps)
                    <div class="absolute top-4 right-0 w-1/2 h-0.5 z-0"
                         style="background-color: {{ $currentStep > $step ? '#facc15' : '#d1d5db' }}"></div>
                @endif

                {{-- Label --}}
                <div class="mt-2 text-sm {{ $currentStep == $step ? 'text-yellow-500 font-medium' : 'text-gray-600' }}">
                    {{ $label }}
                </div>
            </div>
        @endforeach
    </div>
</div>
