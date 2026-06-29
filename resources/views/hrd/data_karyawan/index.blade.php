<x-layouts.hrd title="Data Karyawan">
    <div class="bg-white shadow rounded">
        <div class="px-6 py-5 border-b flex items-center justify-between">
            <h1 class="text-2xl font-semibold">Data Karyawan</h1>

            <a href="{{ Route::has('hrd.data-karyawan.create') ? route('hrd.data-karyawan.create') : route('hrd.data-karyawan.index') }}"
               class="bg-sky-600 text-white px-4 py-2 rounded text-sm">
                + Tambah Karyawan
            </a>
        </div>

        <div class="p-6">
            <div class="flex gap-2 mb-4">
                <a href="{{ route('hrd.data-karyawan.index', ['filter' => 'aktif']) }}"
                   class="px-3 py-2 rounded text-sm {{ ($filter ?? 'aktif') === 'aktif' ? 'bg-sky-600 text-white' : 'bg-gray-200 text-gray-800' }}">
                    Karyawan Aktif
                </a>

                <a href="{{ route('hrd.data-karyawan.index', ['filter' => 'resign']) }}"
                   class="px-3 py-2 rounded text-sm {{ ($filter ?? '') === 'resign' ? 'bg-sky-600 text-white' : 'bg-gray-200 text-gray-800' }}">
                    Resign
                </a>

                <a href="{{ route('hrd.data-karyawan.index', ['filter' => 'semua']) }}"
                   class="px-3 py-2 rounded text-sm {{ ($filter ?? '') === 'semua' ? 'bg-sky-600 text-white' : 'bg-gray-200 text-gray-800' }}">
                    Semua
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
                            <th class="border p-2">Jabatan</th>
                            <th class="border p-2">Divisi</th>
                            <th class="border p-2">Status</th>
                            <th class="border p-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($dataKaryawan as $item)
                            <tr>
                                <td class="border p-2">{{ $item->nik }}</td>
                                <td class="border p-2">{{ $item->nama_karyawan }}</td>
                                <td class="border p-2">{{ $item->email }}</td>
                                <td class="border p-2">{{ $item->jabatan }}</td>
                                <td class="border p-2">{{ $item->divisi }}</td>
                                <td class="border p-2">{{ ucfirst($item->status_karyawan ?? 'aktif') }}</td>
                                <td class="border p-2">
                                    <div class="flex flex-wrap gap-2">
                                        <a href="{{ route('hrd.data-karyawan.edit', $item->nik) }}"
                                        class="bg-yellow-500 text-white px-3 py-1 rounded text-xs hover:bg-yellow-600">
                                            Edit
                                        </a>

                                        <a href="{{ route('hrd.data-karyawan.cetak', $item->nik) }}"
                                        class="bg-green-600 text-white px-3 py-1 rounded text-xs">
                                            Cetak Report
                                        </a>

                                        @if(($item->status_karyawan ?? 'aktif') === 'aktif')
                                            <form action="{{ route('hrd.data-karyawan.status', $item) }}" method="POST" class="inline">
                                                @csrf
                                                <input type="hidden" name="status_karyawan" value="resign">
                                                <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded text-xs">
                                                    Resign
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('hrd.data-karyawan.status', $item) }}" method="POST" class="inline">
                                                @csrf
                                                <input type="hidden" name="status_karyawan" value="aktif">
                                                <button type="submit" class="bg-green-600 text-white px-3 py-1 rounded text-xs">
                                                    Aktifkan
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="border p-3 text-center">Belum ada data karyawan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts.hrd>