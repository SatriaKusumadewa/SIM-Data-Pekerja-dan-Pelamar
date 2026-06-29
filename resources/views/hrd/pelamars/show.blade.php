<x-layouts.hrd title="Detail Pelamar">
    <div class="bg-white shadow rounded">
        <div class="px-6 py-5 border-b">
            <h1 class="text-2xl font-semibold">Detail Pelamar</h1>
        </div>

        <div class="p-6 max-w-4xl space-y-4">
            @if(session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-700 rounded text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div>
                <label class="block mb-1 text-sm font-medium">Nama Lengkap</label>
                <input type="text" value="{{ $pelamar->nama }}" class="w-full border rounded p-2 bg-gray-100 text-sm" readonly>
            </div>

            <div>
                <label class="block mb-1 text-sm font-medium">NIK</label>
                <input type="text" value="{{ $pelamar->nik }}" class="w-full border rounded p-2 bg-gray-100 text-sm" readonly>
            </div>

            <div>
                <label class="block mb-1 text-sm font-medium">Jenis Kelamin</label>
                <input type="text" value="{{ $pelamar->jenis_kelamin ?? '-' }}" class="w-full border rounded p-2 bg-gray-100 text-sm" readonly>
            </div>

            <div>
                <label class="block mb-1 text-sm font-medium">Tempat Lahir</label>
                <input type="text"
                    value="{{ $pelamar->tempat_lahir ?? '-' }}"
                    class="w-full border rounded p-2 bg-gray-100 text-sm"
                    readonly>
            </div>

            <div>
                <label class="block mb-1 text-sm font-medium">Tanggal Lahir</label>
                <input type="text"
                    value="{{ $pelamar->tgl_lahir ? \Carbon\Carbon::parse($pelamar->tgl_lahir)->format('d-m-Y') : '-' }}"
                    class="w-full border rounded p-2 bg-gray-100 text-sm"
                    readonly>
            </div>

            <div>
                <label class="block mb-1 text-sm font-medium">Alamat</label>
                <textarea rows="3" class="w-full border rounded p-2 bg-gray-100 text-sm" readonly>{{ $pelamar->alamat ?? '-' }}</textarea>
            </div>

            <div>
                <label class="block mb-1 text-sm font-medium">Nomor HP</label>
                <input type="text" value="{{ $pelamar->no_telepon ?? '-' }}" class="w-full border rounded p-2 bg-gray-100 text-sm" readonly>
            </div>

            <div>
                <label class="block mb-1 text-sm font-medium">Email</label>
                <input type="text" value="{{ $pelamar->email ?? '-' }}" class="w-full border rounded p-2 bg-gray-100 text-sm" readonly>
            </div>

            <div>
                <label class="block mb-1 text-sm font-medium">Pendidikan Terakhir</label>
                <input type="text" value="{{ $pelamar->pendidikan ?? '-' }}" class="w-full border rounded p-2 bg-gray-100 text-sm" readonly>
            </div>

            <div>
                <label class="block mb-1 text-sm font-medium">Posisi Yang Dilamar</label>
                <input type="text" value="{{ $pelamar->posisi_dilamar ?? '-' }}" class="w-full border rounded p-2 bg-gray-100 text-sm" readonly>
            </div>

            <div>
                <label class="block mb-1 text-sm font-medium">Tanggal Melamar</label>
                <input type="text"
                    value="{{ $pelamar->tgl_melamar ? \Carbon\Carbon::parse($pelamar->tgl_melamar)->format('d-m-Y') : '-' }}"
                    class="w-full border rounded p-2 bg-gray-100 text-sm"
                    readonly>
            </div>

            <div>
                <label class="block mb-1 text-sm font-medium">Status Lamaran</label>
                <input type="text" value="{{ ucfirst($pelamar->status_pelamar ?? '-') }}" class="w-full border rounded p-2 bg-gray-100 text-sm" readonly>
            </div>

            <div class="pt-2">
                <h2 class="text-lg font-semibold mb-3">Dokumen Pelamar</h2>

                <div class="overflow-x-auto">
                    <table class="w-full border border-gray-300 text-sm">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="border p-2">Dokumen</th>
                                <th class="border p-2">Status</th>
                                <th class="border p-2">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $dokumenPelamar = [
                                    ['label' => 'KTP', 'field' => 'scan_ktp', 'jenis' => 'ktp'],
                                    ['label' => 'Ijazah', 'field' => 'scan_ijazah', 'jenis' => 'ijazah'],
                                    ['label' => 'Foto', 'field' => 'foto', 'jenis' => 'foto'],
                                    ['label' => 'CV', 'field' => 'cv', 'jenis' => 'cv'],
                                ];
                            @endphp

                            @foreach($dokumenPelamar as $dok)
                                <tr>
                                    <td class="border p-2">{{ $dok['label'] }}</td>
                                    <td class="border p-2">{{ !empty($pelamar->{$dok['field']}) ? 'Ada' : 'Belum Ada' }}</td>
                                    <td class="border p-2">
                                        @if(!empty($pelamar->{$dok['field']}))
                                            <div class="flex gap-2">
                                                <a href="{{ route('hrd.pelamars.dokumen.preview', [$pelamar, $dok['jenis']]) }}"
                                                   class="bg-blue-600 text-white px-3 py-1 rounded text-xs">
                                                    Lihat
                                                </a>
                                                <a href="{{ route('hrd.pelamars.dokumen.download', [$pelamar, $dok['jenis']]) }}"
                                                   class="bg-green-600 text-white px-3 py-1 rounded text-xs">
                                                    Download
                                                </a>
                                            </div>
                                        @else
                                            <span class="text-gray-500 text-xs">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="flex flex-wrap gap-3 pt-4">
                <a href="{{ route('hrd.pelamars.index') }}" class="bg-gray-600 text-white px-6 py-2 rounded text-sm">
                    Kembali
                </a>

                <a href="{{ route('hrd.pelamars.edit', $pelamar) }}" class="bg-yellow-500 text-white px-6 py-2 rounded text-sm">
                    Edit
                </a>

                @if($pelamar->status_pelamar === 'diterima')
                    <a href="{{ route('hrd.pelamars.proses.create', $pelamar) }}" class="bg-sky-600 text-white px-6 py-2 rounded text-sm">
                        Proses ke Karyawan
                    </a>
                @endif
            </div>
        </div>
    </div>
</x-layouts.hrd>