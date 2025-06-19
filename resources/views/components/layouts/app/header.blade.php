<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    @include('partials.head')
    @fluxAppearance
</head>
<body class="min-h-screen bg-white dark:bg-zinc-800">
<flux:header container class="border-b border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
    <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left"/>

    <a href="{{ route('dashboard') }}" class="ms-2 me-5 flex items-center space-x-2 rtl:space-x-reverse lg:ms-0"
       wire:navigate>
        <x-app-logo/>
    </a>

    <flux:navbar class="-mb-px max-lg:hidden">
        <flux:navbar.item icon="plus-circle" :href="route('add-car')" :current="request()->routeIs('add-car')"
                          wire:navigate>
            {{ __('Add Car') }}
        </flux:navbar.item>
    </flux:navbar>

    <flux:spacer/>

    <flux:navbar class="me-1.5 space-x-0.5 rtl:space-x-reverse py-0!">
        <flux:tooltip :content="__('Search')" position="bottom">
            <flux:navbar.item class="!h-10 [&>div>svg]:size-5" icon="magnifying-glass" href="#" :label="__('Search')"/>
        </flux:tooltip>

        <flux:tooltip :content="__('Documentation')" position="bottom">
            <flux:navbar.item
                class="h-10 max-lg:hidden [&>div>svg]:size-5"
                icon="book-open-text"
                href="https://laravel.com/docs/starter-kits#livewire"
                target="_blank"
                label="Documentation"
            />
        </flux:tooltip>
    </flux:navbar>

    <!-- Desktop User Menu -->
    <flux:dropdown position="top" align="end">

        <flux:profile circle name="{{auth()->user()->name}}"
                      avatar="{{avatar_url(auth()->user()) ?: '' }}"/>


        <flux:navmenu class="max-w-[12rem]">
            <div class="px-2 py-1.5">
                <flux:text size="sm">Signed in as</flux:text>
                <flux:heading class="mt-1! truncate">{{auth()->user()->email}}</flux:heading>
            </div>
            <flux:navmenu.separator/>
            <flux:navmenu.item :href="route('settings.profile')" icon="user" class="text-zinc-800 dark:text-white" wire:navigate>
                {{ __('Account') }}
            </flux:navmenu.item>
            @role('admin')
            <flux:menu.radio.group>
                <flux:menu.item :href="route('settings.admin_panel')" icon="cog" class="text-zinc-800 dark:text-white" wire:navigate>
                    {{ __('Admin Panel') }}
                </flux:menu.item>
            </flux:menu.radio.group>
            <flux:menu.separator/>
            @endrole
            <form method="POST" action="{{ route('logout') }}" class="w-full">
                @csrf
                <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                    {{ __('Log Out') }}
                </flux:menu.item>
            </form>
        </flux:navmenu>
    </flux:dropdown>
</flux:header>

<!-- Mobile Menu -->
<flux:sidebar stashable sticky
              class="lg:hidden border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
    <flux:sidebar.toggle class="lg:hidden" icon="x-mark"/>

    <a href="{{ route('dashboard') }}" class="ms-1 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
        <x-app-logo/>
    </a>

    <flux:navlist variant="outline">
        <flux:navlist.group :heading="__('Platform')">
            <flux:navlist.item icon="layout-grid" :href="route('dashboard')" :current="request()->routeIs('dashboard')"
                               wire:navigate>
                {{ __('Dashboard') }}
            </flux:navlist.item>
        </flux:navlist.group>
    </flux:navlist>

    <flux:spacer/>

    <flux:navlist variant="outline">
        <flux:navlist.item icon="folder-git-2" href="https://github.com/laravel/livewire-starter-kit" target="_blank">
            {{ __('Repository') }}
        </flux:navlist.item>

        <flux:navlist.item icon="book-open-text" href="https://laravel.com/docs/starter-kits#livewire" target="_blank">
            {{ __('Documentation') }}
        </flux:navlist.item>
    </flux:navlist>
</flux:sidebar>

{{ $slot }}

@fluxScripts
</body>
</html>
