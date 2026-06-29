<x-layouts.hrd title="Dokumen Karyawan">
    <div class="bg-white shadow rounded">
        <div class="px-6 py-5 border-b">
            <h1 class="text-2xl font-semibold">Dokumen Karyawan</h1>
        </div>

        <div class="p-6">
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
                            <th class="border p-2">KTP</th>
                            <th class="border p-2">Ijazah</th>
                            <th class="border p-2">Foto</th>
                            <th class="border p-2">Buku Rekening</th>
                            <th class="border p-2">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($dataKaryawan as $item)
                            @php
                                $dokumen = $item->dokumen;
                            @endphp

                            <tr>
                                <td class="border p-2">{{ $item->nik }}</td>
                                <td class="border p-2">{{ $item->nama_karyawan }}</td>

                                <td class="border p-2">
                                    @if($dokumen?->ktp_path)
                                        <span class="font-semibold text-green-700">Ada</span>
                                    @else
                                        <span class="text-gray-500">Belum</span>
                                    @endif
                                </td>

                                <td class="border p-2">
                                    @if($dokumen?->ijazah_path)
                                        <span class="font-semibold text-green-700">Ada</span>
                                    @else
                                        <span class="text-gray-500">Belum</span>
                                    @endif
                                </td>

                                <td class="border p-2">
                                    @if($dokumen?->foto_path)
                                        <span class="font-semibold text-green-700">Ada</span>
                                    @else
                                        <span class="text-gray-500">Belum</span>
                                    @endif
                                </td>

                                <td class="border p-2">
                                    @if($dokumen?->buku_rekening_path)
                                        <span class="font-semibold text-green-700">Ada</span>
                                    @else
                                        <span class="text-gray-500">Belum</span>
                                    @endif
                                </td>

                                <td class="border p-2">
                                    <a href="{{ route('hrd.data-karyawan.dokumen.create', ['karyawan' => $item->nik]) }}"
                                       class="inline-block rounded bg-blue-600 px-3 py-1 text-xs text-white hover:bg-blue-700">
                                        Upload / Edit
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="border p-3 text-center">
                                    Belum ada data dokumen karyawan
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts.hrd>