<x-layouts.app :title="__('Home')">
    <main class="dark:bg-gray-900 py-12">
        <div class="container mx-auto max-w-3xl text-center px-4">
            <!-- Logo -->
            <div class="flex justify-center mb-6">
                <img src="{{ asset('img/CarMods.svg') }}"
                     alt="CarMods Logo"
                     class="h-16 w-16 sm:h-50 sm:w-50 object-contain drop-shadow-md" />
            </div>

            <!-- Titel en ondertitel -->
            <h1 class="text-4xl sm:text-5xl font-extrabold text-gray-900 dark:text-white tracking-tight">
                Welkom bij <span class="text-yellow-500">CarMods</span>
            </h1>
            <p class="mt-4 text-lg text-gray-600 dark:text-gray-300">
                Dé plek voor autoliefhebbers om hun build te delen, mods bij te houden en inspiratie op te doen.
            </p>

            <!-- CTA knop -->
            <div class="mt-8">
                <a href="{{ route('add-car') }}"
                   class="inline-block bg-yellow-500 hover:bg-yellow-600 text-white font-semibold px-6 py-3 rounded-xl shadow transition duration-200">
                    Voeg je auto toe
                </a>
            </div>
        </div>
    </main>
</x-layouts.app>
