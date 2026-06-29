<x-layouts.karyawan title="Dokumen Saya">
    <div class="bg-white shadow rounded">
        <div class="px-6 py-5 border-b">
            <h1 class="text-2xl font-semibold">
                Dokumen Saya
            </h1>
        </div>

        <div class="p-4 sm:p-6">
            @if(! $karyawan)
                <div class="rounded bg-yellow-100 p-4 text-sm text-yellow-800">
                    Data karyawan belum terhubung dengan akun ini.
                    Pastikan email atau NIK akun login sama dengan data karyawan.
                </div>
            @else
                <div class="w-full overflow-x-auto rounded border border-gray-200 bg-white">
                    <table class="min-w-[640px] w-full text-sm">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="w-20 border px-4 py-3 text-left font-semibold">
                                    No.
                                </th>

                                <th class="border px-4 py-3 text-left font-semibold">
                                    Jenis Dokumen
                                </th>

                                <th class="w-32 border px-4 py-3 text-left font-semibold">
                                    Status
                                </th>

                                <th class="w-56 border px-4 py-3 text-left font-semibold">
                                    Aksi
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($items as $item)
                                <tr>
                                    <td class="border px-4 py-3">
                                        {{ $item['no'] }}
                                    </td>

                                    <td class="border px-4 py-3">
                                        {{ $item['label'] }}
                                    </td>

                                    <td class="border px-4 py-3">
                                        @if($item['ada'])
                                            <span class="text-gray-800">
                                                Ada
                                            </span>
                                        @else
                                            <span class="text-gray-500">
                                                Tidak Ada
                                            </span>
                                        @endif
                                    </td>

                                    <td class="border px-4 py-3">
                                        @if($item['ada'])
                                            <div class="flex flex-nowrap items-center gap-2">
                                                <a href="{{ route('karyawan.dokumen.preview', $item['jenis']) }}"
                                                   target="_blank"
                                                   rel="noopener"
                                                   class="whitespace-nowrap rounded bg-blue-600 px-3 py-1.5 text-sm text-white hover:bg-blue-700">
                                                    Lihat
                                                </a>

                                                <a href="{{ route('karyawan.dokumen.download', $item['jenis']) }}"
                                                   class="whitespace-nowrap rounded bg-green-600 px-3 py-1.5 text-sm text-white hover:bg-green-700">
                                                    Download
                                                </a>
                                            </div>
                                        @else
                                            <span class="text-sm text-gray-400">
                                                Tidak tersedia
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</x-layouts.karyawan>