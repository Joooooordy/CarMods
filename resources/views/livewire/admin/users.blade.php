<div>
    @include('partials.settings-heading')

    <x-settings.admin-layout :heading="__('Admin Panel')" :subheading="__('View users and add or edit their data.')">
        @livewire('user-table')
    </x-settings.admin-layout>
</div>
