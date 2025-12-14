<div>
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('Admin Panel')" :subheading="__('View users and add or edit their data.')" content-class="w-full">
        @livewire('user-table')

        @livewire('settings.admin.user-edit-modal')
    </x-settings.layout>
</div>
