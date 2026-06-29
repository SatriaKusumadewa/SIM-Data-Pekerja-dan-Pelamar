<x-layouts.manajer title="Detail Karyawan">
    <div class="bg-white shadow rounded">
        <div class="px-6 py-5 border-b">
            <h1 class="text-2xl font-semibold">Detail Karyawan</h1>
        </div>

        <div class="p-6 max-w-4xl">
            <div class="space-y-4">
                <div>
                    <label class="block mb-1 text-sm font-medium">NIK</label>
                    <input type="text"
                           value="{{ $dataKaryawan->nik }}"
                           class="w-full border rounded p-2 bg-gray-100 text-sm"
                           readonly>
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium">Nama Karyawan</label>
                    <input type="text"
                           value="{{ $dataKaryawan->nama_karyawan }}"
                           class="w-full border rounded p-2 bg-gray-100 text-sm"
                           readonly>
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium">Jenis Kelamin</label>
                    <input type="text"
                           value="{{ $dataKaryawan->jenis_kelamin ?? '-' }}"
                           class="w-full border rounded p-2 bg-gray-100 text-sm"
                           readonly>
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium">Tempat / Tanggal Lahir</label>
                    <input type="text"
                           value="{{ ($dataKaryawan->tempat_lahir ?? '-') . ' / ' . ($dataKaryawan->tgl_lahir ? \Carbon\Carbon::parse($dataKaryawan->tgl_lahir)->format('d-m-Y') : '-') }}"
                           class="w-full border rounded p-2 bg-gray-100 text-sm"
                           readonly>
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium">Alamat</label>
                    <textarea rows="3"
                              class="w-full border rounded p-2 bg-gray-100 text-sm"
                              readonly>{{ $dataKaryawan->alamat ?? '-' }}</textarea>
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium">No Telepon</label>
                    <input type="text"
                           value="{{ $dataKaryawan->no_telepon ?? '-' }}"
                           class="w-full border rounded p-2 bg-gray-100 text-sm"
                           readonly>
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium">Email</label>
                    <input type="text"
                           value="{{ $dataKaryawan->email ?? '-' }}"
                           class="w-full border rounded p-2 bg-gray-100 text-sm"
                           readonly>
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium">Divisi</label>
                    <input type="text"
                           value="{{ $dataKaryawan->divisi ?? '-' }}"
                           class="w-full border rounded p-2 bg-gray-100 text-sm"
                           readonly>
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium">Jabatan</label>
                    <input type="text"
                           value="{{ $dataKaryawan->jabatan ?? '-' }}"
                           class="w-full border rounded p-2 bg-gray-100 text-sm"
                           readonly>
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium">Tanggal Masuk</label>
                    <input type="text"
                           value="{{ $dataKaryawan->tgl_masuk ? \Carbon\Carbon::parse($dataKaryawan->tgl_masuk)->format('d-m-Y') : '-' }}"
                           class="w-full border rounded p-2 bg-gray-100 text-sm"
                           readonly>
                </div>
            </div>

            <div class="flex gap-3 pt-6">
                <a href="{{ route('manajer.data-karyawan.index') }}"
                   class="bg-sky-600 text-white px-6 py-2 rounded text-sm">
                    Kembali
                </a>
            </div>
        </div>
    </div>
</x-layouts.manajer>