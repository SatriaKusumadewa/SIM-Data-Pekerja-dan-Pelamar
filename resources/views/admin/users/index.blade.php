<x-layouts.admin title="Kelola User">
    <div class="w-full rounded-lg bg-white shadow">
        <div class="flex flex-col gap-3 border-b px-4 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-6">
            <h1 class="text-xl font-semibold text-gray-800 sm:text-2xl">
                Kelola User
            </h1>

            <a href="{{ route('admin.users.create') }}"
               class="inline-flex w-fit items-center justify-center rounded bg-sky-600 px-3 py-2 text-xs font-medium text-white hover:bg-sky-700 sm:text-sm">
                + Tambah User
            </a>
        </div>

        <div class="p-4 sm:p-6">
            @if(session('success'))
                <div class="mb-4 rounded bg-green-100 p-3 text-sm text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            <div class="w-full overflow-x-auto rounded-lg border border-gray-200 bg-white shadow-sm">
                <table class="min-w-[640px] w-full text-xs sm:text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="whitespace-nowrap px-2 py-2 text-left font-semibold text-gray-700 sm:px-4">
                                Nama User
                            </th>
                            <th class="whitespace-nowrap px-2 py-2 text-left font-semibold text-gray-700 sm:px-4">
                                Email
                            </th>
                            <th class="whitespace-nowrap px-2 py-2 text-left font-semibold text-gray-700 sm:px-4">
                                Role
                            </th>
                            <th class="whitespace-nowrap px-2 py-2 text-left font-semibold text-gray-700 sm:px-4">
                                Aksi
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200 bg-white">
                        @forelse($users as $user)
                            <tr>
                                <td class="whitespace-nowrap px-2 py-2 text-gray-800 sm:px-4">
                                    {{ $user->name }}
                                </td>

                                <td class="whitespace-nowrap px-2 py-2 text-gray-800 sm:px-4">
                                    {{ $user->email }}
                                </td>

                                <td class="whitespace-nowrap px-2 py-2 text-gray-800 sm:px-4">
                                    {{ $user->roles->pluck('name')->implode(', ') ?: '-' }}
                                </td>

                                <td class="whitespace-nowrap px-2 py-2 sm:px-4">
                                    <div class="flex flex-nowrap gap-1">
                                        <a href="{{ route('admin.users.edit', $user) }}"
                                           class="rounded bg-yellow-500 px-2 py-1 text-[11px] font-medium text-white hover:bg-yellow-600">
                                            Edit
                                        </a>

                                        <form action="{{ route('admin.users.destroy', $user) }}"
                                              method="POST"
                                              onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="rounded bg-red-600 px-2 py-1 text-[11px] font-medium text-white hover:bg-red-700">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-4 text-center text-sm text-gray-500">
                                    Data user belum tersedia.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts.admin>