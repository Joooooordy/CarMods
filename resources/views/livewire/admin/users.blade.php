<div>
    @include('partials.settings-heading')

    <x-settings.admin-layout :heading="__('Admin Panel')" :subheading="__('View users and add or edit their data.')">
        <div class="overflow-x-auto p-4">
            <table class="table-auto w-full border-collapse border border-gray-300 text-sm">
                <thead class="bg-gray-100">
                <tr>
                    <th class="border px-4 py-2">ID</th>
                    <th class="border px-4 py-2">Name</th>
                    <th class="border px-4 py-2">Email</th>
                    <th class="border px-4 py-2">Roles</th>
                    <th class="border px-4 py-2">Permissions</th>
                    <th class="border px-4 py-2">Created On</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($users as $user)
                    <tr class="hover:bg-gray-50">
                        <td class="border px-4 py-2">{{ $user->id }}</td>
                        <td class="border px-4 py-2">{{ $user->name }}</td>
                        <td class="border px-4 py-2">{{ $user->email }}</td>
                        <td class="border px-4 py-2">
                            @foreach ($user->roles as $role)
                                <span
                                    class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded">{{ $role->name }}</span>
                            @endforeach
                        </td>
                        <td class="border px-4 py-2">
                            @foreach ($user->getAllPermissions() as $perm)
                                <span
                                    class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded">{{ $perm->name }}</span>
                            @endforeach
                        </td>
                        <td class="border px-4 py-2">{{ $user->created_at->format('d-m-Y H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-gray-500 py-4">Geen gebruikers gevonden.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
            <!-- Paginate links -->
            <div class="mt-4">
                {{ $users->links() }}
            </div>
        </div>
    </x-settings.admin-layout>
</div>
