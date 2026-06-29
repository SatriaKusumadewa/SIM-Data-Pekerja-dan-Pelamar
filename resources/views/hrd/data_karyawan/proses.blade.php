<x-layouts.hrd title="Tambah Karyawan">
    <div class="bg-white shadow rounded max-w-4xl">
        <div class="px-6 py-5 border-b">
            <h1 class="text-2xl font-semibold">Tambah Karyawan</h1>
        </div>

        <div class="p-6">
            @if ($errors->any())
                <div class="mb-4 rounded bg-red-100 p-4 text-red-700 text-sm">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('hrd.pelamars.proses.store', $pelamar) }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="block mb-1 text-sm font-medium">NIK</label>
                    <input type="text" value="{{ $pelamar->nik }}" class="w-full border rounded p-2 bg-gray-100 text-sm" readonly>
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium">Nama Karyawan</label>
                    <input type="text" value="{{ $pelamar->nama }}" class="w-full border rounded p-2 bg-gray-100 text-sm" readonly>
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium">Jenis Kelamin</label>
                    <input type="text" value="{{ $pelamar->jenis_kelamin ?? '-' }}" class="w-full border rounded p-2 bg-gray-100 text-sm" readonly>
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium">Tempat Lahir</label>
                    <input type="text" value="{{ $pelamar->tempat_lahir ?? '-' }}" class="w-full border rounded p-2 bg-gray-100 text-sm" readonly>
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
                    <label class="block mb-1 text-sm font-medium">No Telepon</label>
                    <input
                        type="text"
                        id="no_telepon"
                        name="no_telepon"
                        value="{{ old('no_telepon', $pelamar->no_telepon ?? $karyawan->no_telepon ?? '') }}"
                        inputmode="numeric"
                        pattern="[0-9]*"
                        minlength="10"
                        maxlength="15"
                        class="w-full border rounded p-2 text-sm"
                        placeholder="Contoh: 081234567890"
                        required
                        oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                    >
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium">Email</label>
                    <input type="text" value="{{ $pelamar->email ?? '-' }}" class="w-full border rounded p-2 bg-gray-100 text-sm" readonly>
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium">Jabatan</label>
                    <input type="text" value="{{ $pelamar->posisi_dilamar ?? '-' }}" class="w-full border rounded p-2 bg-gray-100 text-sm" readonly>
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium">Tanggal Masuk</label>
                    <input type="text" value="{{ now()->format('d-m-Y') }}" class="w-full border rounded p-2 bg-gray-100 text-sm" readonly>
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium">Divisi</label>
                    <input type="text" name="divisi" value="{{ old('divisi') }}" class="w-full border rounded p-2 text-sm">
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium">No Rekening</label>
                    <input type="text" name="no_rekening" value="{{ old('no_rekening') }}" class="w-full border rounded p-2 text-sm">
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium">Nama Bank</label>
                    <input type="text" name="nama_bank" value="{{ old('nama_bank') }}" class="w-full border rounded p-2 text-sm">
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="submit" class="bg-sky-600 text-white px-6 py-2 rounded text-sm">
                        Simpan
                    </button>

                    <a href="{{ route('hrd.pelamars.show', $pelamar) }}"
                       class="bg-gray-600 text-white px-6 py-2 rounded text-sm">
                        Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-layouts.hrd>