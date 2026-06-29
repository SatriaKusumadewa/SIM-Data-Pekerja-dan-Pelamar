<x-layouts.manajer title="Data Pelamar">
    <div class="bg-white shadow rounded">
        <div class="px-6 py-5 border-b">
            <h1 class="text-2xl font-semibold">
                Pelamar Divisi
            </h1>
        </div>

        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="w-full border border-gray-300 text-sm">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="border p-2">No.</th>
                            <th class="border p-2">Nama</th>
                            <th class="border p-2">Email</th>
                            <th class="border p-2">Posisi</th>
                            <th class="border p-2">Status</th>
                            <th class="border p-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pelamars as $index => $pelamar)
                            <tr>
                                <td class="border p-2 text-center">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</td>
                                <td class="border p-2">{{ $pelamar->nama }}</td>
                                <td class="border p-2">{{ $pelamar->email }}</td>
                                <td class="border p-2">{{ $pelamar->posisi_dilamar }}</td>
                                <td class="border p-2">{{ ucfirst($pelamar->status_pelamar) }}</td>
                                <td class="border p-2 text-center">
                                    <a href="{{ route('manajer.data-pelamar.show', $pelamar->id) }}"
                                    class="inline-flex items-center px-3 py-1 bg-sky-600 text-white text-xs rounded hover:bg-sky-700">
                                    Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="border p-3 text-center">
                                    Belum ada data pelamar.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts.manajer>