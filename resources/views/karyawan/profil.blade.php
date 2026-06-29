<x-layouts.karyawan title="Profil Karyawan">
    <div class="bg-white shadow rounded">
        <div class="px-6 py-5 border-b">
            <h1 class="text-2xl font-semibold">Profil Karyawan</h1>
        </div>

        <div class="p-6 max-w-4xl">
            @if(! $karyawan)
                <div class="rounded bg-yellow-100 p-4 text-sm text-yellow-800">
                    Data profil karyawan belum terhubung dengan akun ini.
                    Pastikan email atau NIK pada akun login sama dengan data karyawan.
                </div>
            @else
                @php
                    $tanggalLahir = $karyawan->tgl_lahir ?? $karyawan->tanggal_lahir ?? null;
                    $tanggalMasuk = $karyawan->tgl_masuk ?? $karyawan->tanggal_masuk ?? null;
                @endphp

                <div class="space-y-4">
                    <div>
                        <label class="block mb-1 text-sm font-medium">NIK</label>
                        <input type="text"
                               value="{{ $karyawan->nik ?? '-' }}"
                               class="w-full border rounded p-2 bg-gray-100 text-sm"
                               readonly>
                    </div>

                    <div>
                        <label class="block mb-1 text-sm font-medium">Nama Karyawan</label>
                        <input type="text"
                               value="{{ $karyawan->nama_karyawan ?? '-' }}"
                               class="w-full border rounded p-2 bg-gray-100 text-sm"
                               readonly>
                    </div>

                    <div>
                        <label class="block mb-1 text-sm font-medium">Jenis Kelamin</label>
                        <input type="text"
                               value="{{ $karyawan->jenis_kelamin ?? '-' }}"
                               class="w-full border rounded p-2 bg-gray-100 text-sm"
                               readonly>
                    </div>

                    <div>
                        <label class="block mb-1 text-sm font-medium">Tempat / Tanggal Lahir</label>
                        <input type="text"
                               value="{{ ($karyawan->tempat_lahir ?? '-') . ' / ' . ($tanggalLahir ? \Carbon\Carbon::parse($tanggalLahir)->format('d-m-Y') : '-') }}"
                               class="w-full border rounded p-2 bg-gray-100 text-sm"
                               readonly>
                    </div>

                    <div>
                        <label class="block mb-1 text-sm font-medium">Alamat</label>
                        <textarea rows="3"
                                  class="w-full border rounded p-2 bg-gray-100 text-sm"
                                  readonly>{{ $karyawan->alamat ?? '-' }}</textarea>
                    </div>

                    <div>
                        <label class="block mb-1 text-sm font-medium">No Telepon</label>
                        <input type="text"
                               value="{{ $karyawan->no_telepon ?? '-' }}"
                               class="w-full border rounded p-2 bg-gray-100 text-sm"
                               readonly>
                    </div>

                    <div>
                        <label class="block mb-1 text-sm font-medium">Email</label>
                        <input type="text"
                               value="{{ $karyawan->email ?? '-' }}"
                               class="w-full border rounded p-2 bg-gray-100 text-sm"
                               readonly>
                    </div>

                    <div>
                        <label class="block mb-1 text-sm font-medium">Jabatan</label>
                        <input type="text"
                               value="{{ $karyawan->jabatan ?? '-' }}"
                               class="w-full border rounded p-2 bg-gray-100 text-sm"
                               readonly>
                    </div>

                    <div>
                        <label class="block mb-1 text-sm font-medium">Divisi</label>
                        <input type="text"
                               value="{{ $karyawan->divisi ?? '-' }}"
                               class="w-full border rounded p-2 bg-gray-100 text-sm"
                               readonly>
                    </div>

                    <div>
                        <label class="block mb-1 text-sm font-medium">Status Karyawan</label>
                        <input type="text"
                               value="{{ ucfirst($karyawan->status_karyawan ?? 'aktif') }}"
                               class="w-full border rounded p-2 bg-gray-100 text-sm"
                               readonly>
                    </div>

                    <div>
                        <label class="block mb-1 text-sm font-medium">Tanggal Masuk</label>
                        <input type="text"
                               value="{{ $tanggalMasuk ? \Carbon\Carbon::parse($tanggalMasuk)->format('d-m-Y') : '-' }}"
                               class="w-full border rounded p-2 bg-gray-100 text-sm"
                               readonly>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-layouts.karyawan>