<x-layouts.admin title="Hasil Pencarian Admin">
    <div class="bg-white shadow rounded">
        <div class="px-6 py-5 border-b">
            <h1 class="text-2xl font-semibold">Hasil Pencarian</h1>
            <p class="text-sm text-gray-600 mt-2">
                Kata kunci: <span class="font-semibold">{{ $q ?: '-' }}</span>
            </p>
        </div>

        <div class="p-6 space-y-8">
            <div>
                <h2 class="text-lg font-semibold mb-3">Data User</h2>

                <div class="overflow-x-auto">
                    <table class="w-full border border-gray-300 text-sm">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="border p-2">Nama User</th>
                                <th class="border p-2">Email</th>
                                <th class="border p-2">Role</th>
                                <th class="border p-2">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                                <tr>
                                    <td class="border p-2">{{ $user->name }}</td>
                                    <td class="border p-2">{{ $user->email }}</td>
                                    <td class="border p-2">{{ $user->roles->pluck('name')->implode(', ') ?: '-' }}</td>
                                    <td class="border p-2">
                                        <a href="{{ route('admin.users.edit', $user) }}"
                                           class="bg-yellow-500 text-white px-3 py-1 rounded text-xs">
                                            Edit
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="border p-3 text-center">Tidak ada data user</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div>
                <h2 class="text-lg font-semibold mb-3">Data Role</h2>

                <div class="overflow-x-auto">
                    <table class="w-full border border-gray-300 text-sm">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="border p-2">No.</th>
                                <th class="border p-2">Nama Role</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($roles as $index => $role)
                                <tr>
                                    <td class="border p-2 text-center">{{ $index + 1 }}</td>
                                    <td class="border p-2">{{ $role->name }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="border p-3 text-center">Tidak ada data role</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-layouts.admin>