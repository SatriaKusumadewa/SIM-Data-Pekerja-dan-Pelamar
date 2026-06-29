<x-layouts.hrd title="Edit Pelamar">
    <div class="bg-white shadow rounded max-w-4xl">
        <div class="px-6 py-5 border-b">
            <h1 class="text-2xl font-semibold">Edit Pelamar</h1>
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

            <form action="{{ route('hrd.pelamars.update', $pelamar) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block mb-1 text-sm font-medium">NIK</label>
                    <input type="text" name="nik"
                           value="{{ old('nik', $pelamar->nik) }}"
                           class="w-full border rounded p-2 text-sm">
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium">Nama</label>
                    <input type="text" name="nama"
                           value="{{ old('nama', $pelamar->nama) }}"
                           class="w-full border rounded p-2 text-sm">
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium">Jenis Kelamin</label>
                    <input type="text" name="jenis_kelamin"
                           value="{{ old('jenis_kelamin', $pelamar->jenis_kelamin) }}"
                           class="w-full border rounded p-2 text-sm">
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium">Tempat Lahir</label>
                    <input type="text" name="tempat_lahir"
                        value="{{ old('tempat_lahir') ?: ($pelamar->tempat_lahir ?? '') }}"
                        class="w-full border rounded p-2 text-sm">
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium">Tanggal Lahir</label>
                    <input type="date" name="tgl_lahir"
                        value="{{ old('tgl_lahir') ?: ($pelamar->tgl_lahir ? \Carbon\Carbon::parse($pelamar->tgl_lahir)->format('Y-m-d') : '') }}"
                        class="w-full border rounded p-2 text-sm">
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium">Alamat</label>
                    <textarea name="alamat" rows="3" class="w-full border rounded p-2 text-sm">{{ old('alamat', $pelamar->alamat) }}</textarea>
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium">No Telepon</label>
                    <input type="text" name="no_telepon"
                           value="{{ old('no_telepon', $pelamar->no_telepon) }}"
                           class="w-full border rounded p-2 text-sm">
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium">Email</label>
                    <input type="email" name="email"
                           value="{{ old('email', $pelamar->email) }}"
                           class="w-full border rounded p-2 text-sm">
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium">Pendidikan</label>
                    <input type="text" name="pendidikan"
                           value="{{ old('pendidikan', $pelamar->pendidikan) }}"
                           class="w-full border rounded p-2 text-sm">
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium">Posisi Dilamar</label>
                    <input type="text" name="posisi_dilamar"
                           value="{{ old('posisi_dilamar', $pelamar->posisi_dilamar) }}"
                           class="w-full border rounded p-2 text-sm">
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium">Tanggal Melamar</label>
                    <input type="date" name="tgl_melamar"
                           value="{{ old('tgl_melamar', $pelamar->tgl_melamar ? \Carbon\Carbon::parse($pelamar->tgl_melamar)->format('Y-m-d') : '') }}"
                           class="w-full border rounded p-2 text-sm">
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium">Status Pelamar</label>
                    <select name="status_pelamar" class="w-full border rounded p-2 text-sm">
                        <option value="diproses" {{ old('status_pelamar', $pelamar->status_pelamar) == 'diproses' ? 'selected' : '' }}>Diproses</option>
                        <option value="diterima" {{ old('status_pelamar', $pelamar->status_pelamar) == 'diterima' ? 'selected' : '' }}>Diterima</option>
                        <option value="ditolak" {{ old('status_pelamar', $pelamar->status_pelamar) == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
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