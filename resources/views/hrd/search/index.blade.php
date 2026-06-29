<x-layouts.hrd title="Hasil Pencarian HRD">
    <div class="bg-white shadow rounded">
        <div class="px-6 py-5 border-b">
            <h1 class="text-2xl font-semibold">Hasil Pencarian</h1>
            <p class="text-sm text-gray-600 mt-2">
                Kata kunci: <span class="font-semibold">{{ $q ?: '-' }}</span>
            </p>
        </div>

        <div class="p-6 space-y-8">
            <div>
                <h2 class="text-lg font-semibold mb-3">Data Pelamar</h2>

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
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="border p-3 text-center">Tidak ada data pelamar</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div>
                <h2 class="text-lg font-semibold mb-3">Data Karyawan</h2>

                <div class="overflow-x-auto">
                    <table class="w-full border border-gray-300 text-sm">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="border p-2">NIK</th>
                                <th class="border p-2">Nama</th>
                                <th class="border p-2">Email</th>
                                <th class="border p-2">Jabatan</th>
                                <th class="border p-2">Divisi</th>
                                <th class="border p-2">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($karyawans as $item)
                                <tr>
                                    <td class="border p-2">{{ $item->nik }}</td>
                                    <td class="border p-2">{{ $item->nama_karyawan }}</td>
                                    <td class="border p-2">{{ $item->email }}</td>
                                    <td class="border p-2">{{ $item->jabatan }}</td>
                                    <td class="border p-2">{{ $item->divisi }}</td>
                                    <td class="border p-2">
                                        <div class="flex flex-wrap gap-2">
                                            <a href="{{ route('hrd.data-karyawan.dokumen.create', ['karyawan' => $item->nik]) }}"
                                               class="bg-blue-600 text-white px-3 py-1 rounded text-xs">
                                                Kelola Dokumen
                                            </a>

                                            <a href="{{ route('hrd.data-karyawan.index') }}"
                                               class="bg-gray-600 text-white px-3 py-1 rounded text-xs">
                                                Lihat Tabel
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="border p-3 text-center">Tidak ada data karyawan</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-layouts.hrd>