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
                Welcome to <span class="text-yellow-500">CarMods</span>
            </h1>
            <p class="mt-4 text-lg text-gray-600 dark:text-gray-300">
                THE place for car enthousiasts to share their build, keep track of their mods and shop for parts.
            </p>

            <!-- CTA knop -->
            <div class="mt-8 flex gap-5 justify-center">
                <a href="{{ route('search-car') }}"
                   class="inline-block bg-yellow-400 hover:bg-yellow-500 text-white font-semibold px-6 py-3 rounded-xl shadow transition duration-200">
                   Find Your Car
                </a>
                <a href="{{ route('shop') }}"
                   class="inline-block bg-yellow-400 hover:bg-yellow-500 text-white font-semibold px-6 py-3 rounded-xl shadow transition duration-200">
                    Go To The Shop
                </a>
            </div>
        </div>
    </main>
</x-layouts.app>
