<x-layouts.manajer title="Dashboard Manajer">
    <div class="bg-white shadow rounded">
        <div class="px-6 py-5 border-b">
            <h1 class="text-2xl font-semibold">Dashboard</h1>
        </div>

        <div class="p-6">
            <h2 class="text-xl text-center mb-4">Daftar Karyawan Divisi</h2>

            <div class="overflow-x-auto">
                <table class="w-full border border-gray-300 text-sm">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="border p-2">No.</th>
                            <th class="border p-2">Nama Karyawan</th>
                            <th class="border p-2">Jabatan</th>
                            <th class="border p-2">Status</th>
                            <th class="border p-2">Nama Role</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($dataKaryawan as $index => $item)
                            <tr>
                                <td class="border p-2 text-center">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</td>
                                <td class="border p-2">{{ $item->nama_karyawan }}</td>
                                <td class="border p-2">{{ $item->jabatan }}</td>
                                <td class="border p-2">{{ ucfirst($item->status_karyawan ?? 'aktif') }}</td>
                                <td class="border p-2">
                                    @php
                                        $jabatan = \Illuminate\Support\Str::lower(trim($item->jabatan ?? ''));
                                    @endphp

                                    @if($jabatan === 'manajer')
                                        Manajer
                                    @elseif($jabatan === 'hrd')
                                        HRD
                                    @else
                                        Karyawan
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="border p-3 text-center">Belum ada data karyawan untuk divisi ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts.manajer>