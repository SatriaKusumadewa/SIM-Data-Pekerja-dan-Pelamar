<x-layouts.admin title="Kelola Role">
    <div class="w-full rounded-lg bg-white shadow">
        <div class="flex flex-col gap-3 border-b px-4 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-6">
            <h1 class="text-xl font-semibold text-gray-800 sm:text-2xl">
                Kelola Role
            </h1>

            <a href="{{ route('admin.roles.create') }}"
               class="inline-flex w-fit items-center justify-center rounded bg-sky-600 px-3 py-2 text-xs font-medium text-white hover:bg-sky-700 sm:text-sm">
                + Tambah Role
            </a>
        </div>

        <div class="p-4 sm:p-6">
            @if(session('success'))
                <div class="mb-4 rounded bg-green-100 p-3 text-sm text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            <div class="w-full overflow-x-auto rounded-lg border border-gray-200 bg-white shadow-sm">
                <table class="w-full table-fixed text-xs sm:text-sm">
                    <colgroup>
                        <col style="width: 80px;">
                        <col style="width: 55%;">
                        <col style="width: 180px;">
                    </colgroup>

                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-3 text-left font-semibold text-gray-700">
                                No
                            </th>

                            <th class="px-4 py-3 text-left font-semibold text-gray-700">
                                Nama Role
                            </th>

                            <th class="px-4 py-3 text-left font-semibold text-gray-700">
                                Aksi
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200 bg-white">
                        @forelse($roles as $role)
                            <tr>
                                <td class="px-2 py-2 text-gray-700 sm:px-4">
                                    {{ $loop->iteration }}
                                </td>

                                <td class="truncate px-2 py-2 font-medium text-gray-800 sm:px-4">
                                    {{ $role->name }}
                                </td>

                                <td class="px-2 py-2 sm:px-4">
                                    <div class="flex justify-start gap-1">
                                        @if(\Illuminate\Support\Facades\Route::has('admin.roles.edit'))
                                            <a href="{{ route('admin.roles.edit', $role) }}"
                                            class="rounded bg-yellow-500 px-2 py-1 text-[11px] font-medium text-white hover:bg-yellow-600">
                                                Edit
                                            </a>
                                        @endif

                                        @if(\Illuminate\Support\Facades\Route::has('admin.roles.destroy'))
                                            <form action="{{ route('admin.roles.destroy', $role) }}"
                                                method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus role ini?')">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                        class="rounded bg-red-600 px-2 py-1 text-[11px] font-medium text-white hover:bg-red-700">
                                                    Hapus
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-4 py-4 text-center text-sm text-gray-500">
                                    Data role belum tersedia.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts.admin>