<x-layouts.manajer title="Data Karyawan">
    <div class="bg-white shadow rounded">
        <div class="px-6 py-5 border-b">
            <h1 class="text-2xl font-semibold">Data Karyawan</h1>
        </div>

        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="w-full border border-gray-300 text-sm">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="border p-2">No.</th>
                            <th class="border p-2">Nama</th>
                            <th class="border p-2">Divisi</th>
                            <th class="border p-2">Jabatan</th>
                            <th class="border p-2">Tanggal Masuk</th>
                            <th class="border p-2">Status</th>
                            <th class="border p-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($dataKaryawan as $index => $item)
                            <tr>
                                <td class="border p-2 text-center">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</td>
                                <td class="border p-2">{{ $item->nama_karyawan }}</td>
                                <td class="border p-2">{{ $item->divisi }}</td>
                                <td class="border p-2">{{ $item->jabatan }}</td>
                                <td class="border p-2">
                                    {{ $item->tgl_masuk ? \Carbon\Carbon::parse($item->tgl_masuk)->format('d-m-Y') : '-' }}
                                </td>
                                <td class="border p-2">{{ $item->status_label }}</td>
                                <td class="border p-2 text-center">
                                    <a href="{{ route('manajer.data-karyawan.show', ['karyawan' => $item->nik]) }}"
                                       class="bg-blue-600 text-white px-3 py-1 rounded text-xs">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="border p-3 text-center">
                                    Belum ada data karyawan untuk divisi ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts.manajer>