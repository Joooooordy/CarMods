<div>
    @include('partials.settings-heading')

    <x-settings.layout
        :heading="__('Admin Panel')"
        :subheading="__('View all orders.')"
        content-class="w-full">

        @livewire('order-table')

        @livewire('settings.admin.order-edit-modal')
    </x-settings.layout>
</div>
