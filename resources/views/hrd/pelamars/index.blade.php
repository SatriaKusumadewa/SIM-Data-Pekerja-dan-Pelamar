<x-layouts.hrd title="Data Pelamar">
    <div class="bg-white shadow rounded">
        <div class="px-6 py-5 border-b">
            <h1 class="text-2xl font-semibold">Data Pelamar</h1>
        </div>

        <div class="p-6">
            <div class="flex gap-2 mb-4">
                <a href="{{ route('hrd.pelamars.index', ['filter' => 'aktif']) }}"
                   class="px-3 py-2 rounded text-sm {{ ($filter ?? 'aktif') === 'aktif' ? 'bg-sky-600 text-white' : 'bg-gray-200 text-gray-800' }}">
                    Data Aktif
                </a>

                <a href="{{ route('hrd.pelamars.index', ['filter' => 'arsip']) }}"
                   class="px-3 py-2 rounded text-sm {{ ($filter ?? '') === 'arsip' ? 'bg-sky-600 text-white' : 'bg-gray-200 text-gray-800' }}">
                    Arsip
                </a>
            </div>

            @if(session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-700 rounded text-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 p-3 bg-red-100 text-red-700 rounded text-sm">
                    {{ session('error') }}
                </div>
            @endif

            <div class="overflow-x-auto">
                <table class="w-full border border-gray-300 text-sm">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="border p-2">NIK</th>
                            <th class="border p-2">Nama</th>
                            <th class="border p-2">Email</th>
                            <th class="border p-2">Posisi</th>
                            <th class="border p-2">Status</th>
                            <th class="border p-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pelamars as $pelamar)
                            <tr>
                                <td class="border p-2">{{ $pelamar->nik }}</td>
                                <td class="border p-2">{{ $pelamar->nama }}</td>
                                <td class="border p-2">{{ $pelamar->email }}</td>
                                <td class="border p-2">{{ $pelamar->posisi_dilamar }}</td>
                                <td class="border p-2">{{ ucfirst($pelamar->status_pelamar) }}</td>
                                <td class="border p-2">
                                    <div class="flex flex-wrap gap-2">
                                        <a href="{{ route('hrd.pelamars.show', $pelamar) }}"
                                           class="bg-blue-600 text-white px-3 py-1 rounded text-xs">
                                            Detail
                                        </a>

                                        <a href="{{ route('hrd.pelamars.edit', $pelamar) }}"
                                           class="bg-yellow-500 text-white px-3 py-1 rounded text-xs">
                                            Edit
                                        </a>

                                        @if($pelamar->status_pelamar === 'diterima')
                                            <a href="{{ route('hrd.pelamars.proses.create', $pelamar) }}"
                                               class="bg-green-600 text-white px-3 py-1 rounded text-xs">
                                                Proses
                                            </a>
                                        @endif

                                        @if(($filter ?? 'aktif') !== 'arsip')
                                            <form action="{{ route('hrd.pelamars.arsip', $pelamar) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="bg-gray-600 text-white px-3 py-1 rounded text-xs">
                                                    Arsip
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('hrd.pelamars.pulihkan', $pelamar) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="bg-green-700 text-white px-3 py-1 rounded text-xs">
                                                    Pulihkan
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="border p-3 text-center">Belum ada data pelamar</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts.hrd>