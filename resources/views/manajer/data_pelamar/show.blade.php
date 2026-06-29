<x-layouts.manajer title="Detail Pelamar">
    <div class="bg-white shadow rounded">
        <div class="px-6 py-5 border-b">
            <h1 class="text-2xl font-semibold">Detail Pelamar Divisi</h1>
        </div>

        <div class="p-6 max-w-4xl">
            <div class="space-y-4">
                <div>
                    <label class="block mb-1 text-sm font-medium">NIK</label>
                    <input type="text"
                           value="{{ $pelamar->nik }}"
                           class="w-full border rounded p-2 bg-gray-100 text-sm"
                           readonly>
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium">Nama Lengkap</label>
                    <input type="text"
                           value="{{ $pelamar->nama }}"
                           class="w-full border rounded p-2 bg-gray-100 text-sm"
                           readonly>
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium">Jenis Kelamin</label>
                    <input type="text"
                           value="{{ $pelamar->jenis_kelamin ?? '-' }}"
                           class="w-full border rounded p-2 bg-gray-100 text-sm"
                           readonly>
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium">Tempat / Tanggal Lahir</label>
                    <input type="text"
                           value="{{ ($pelamar->tempat_lahir ?? '-') . ' / ' . ($pelamar->tgl_lahir ? \Carbon\Carbon::parse($pelamar->tgl_lahir)->format('d-m-Y') : '-') }}"
                           class="w-full border rounded p-2 bg-gray-100 text-sm"
                           readonly>
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium">Alamat</label>
                    <textarea rows="3"
                              class="w-full border rounded p-2 bg-gray-100 text-sm"
                              readonly>{{ $pelamar->alamat ?? '-' }}</textarea>
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium">No Telepon</label>
                    <input type="text"
                           value="{{ $pelamar->no_telepon ?? '-' }}"
                           class="w-full border rounded p-2 bg-gray-100 text-sm"
                           readonly>
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium">Email</label>
                    <input type="text"
                           value="{{ $pelamar->email ?? '-' }}"
                           class="w-full border rounded p-2 bg-gray-100 text-sm"
                           readonly>
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium">Pendidikan</label>
                    <input type="text"
                           value="{{ $pelamar->pendidikan ?? '-' }}"
                           class="w-full border rounded p-2 bg-gray-100 text-sm"
                           readonly>
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium">Posisi Dilamar</label>
                    <input type="text"
                           value="{{ $pelamar->posisi_dilamar ?? '-' }}"
                           class="w-full border rounded p-2 bg-gray-100 text-sm"
                           readonly>
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium">Tanggal Melamar</label>
                    <input type="text"
                           value="{{ $pelamar->tgl_melamar ? \Carbon\Carbon::parse($pelamar->tgl_melamar)->format('d-m-Y') : '-' }}"
                           class="w-full border rounded p-2 bg-gray-100 text-sm"
                           readonly>
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium">Status Pelamar</label>
                    <input type="text"
                           value="{{ ucfirst($pelamar->status_pelamar ?? '-') }}"
                           class="w-full border rounded p-2 bg-gray-100 text-sm"
                           readonly>
                </div>
            </div>

            <div class="flex gap-3 pt-6">
                <a href="{{ route('manajer.data-pelamar.index') }}"
                   class="bg-sky-600 text-white px-6 py-2 rounded text-sm">
                    Kembali
                </a>
            </div>
        </div>
    </div>
</x-layouts.manajer>