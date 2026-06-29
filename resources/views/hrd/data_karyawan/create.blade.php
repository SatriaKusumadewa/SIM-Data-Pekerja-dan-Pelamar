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

            <form action="{{ route('hrd.data-karyawan.store') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label for="nik" class="block mb-1 text-sm font-medium">
                        NIK
                    </label>

                    <input
                        type="text"
                        id="nik"
                        name="nik"
                        value="{{ old('nik') }}"
                        inputmode="numeric"
                        pattern="[0-9]*"
                        minlength="16"
                        maxlength="16"
                        class="w-full border rounded p-2 text-sm"
                        placeholder="Contoh: 3515010101010001"
                        required
                        oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                    >
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium">Nama Karyawan</label>
                    <input
                        type="text"
                        name="nama_karyawan"
                        value="{{ old('nama_karyawan') }}"
                        maxlength="100"
                        class="w-full border rounded p-2 text-sm"
                        required
                    >
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium">Jenis Kelamin</label>
                    <input type="text" name="jenis_kelamin" value="{{ old('jenis_kelamin') }}" class="w-full border rounded p-2 text-sm">
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium">Tempat Lahir</label>
                    <input
                        type="text"
                        name="tempat_lahir"
                        value="{{ old('tempat_lahir') }}"
                        maxlength="100"
                        class="w-full border rounded p-2 text-sm"
                    >
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium">Tanggal Lahir</label>
                    <input type="date" name="tgl_lahir" value="{{ old('tgl_lahir') }}" class="w-full border rounded p-2 text-sm">
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium">Alamat</label>
                    <textarea name="alamat" rows="3" class="w-full border rounded p-2 text-sm">{{ old('alamat') }}</textarea>
                </div>

                <div>
                    <label for="no_telepon" class="block mb-1 text-sm font-medium">
                        No Telepon
                    </label>

                    <input
                        type="text"
                        id="no_telepon"
                        name="no_telepon"
                        value="{{ old('no_telepon') }}"
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
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        maxlength="100"
                        class="w-full border rounded p-2 text-sm"
                    >
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium">Jabatan</label>
                    <input
                        type="text"
                        name="jabatan"
                        value="{{ old('jabatan') }}"
                        maxlength="100"
                        class="w-full border rounded p-2 text-sm"
                        required
                    >
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium">Divisi</label>
                    <input
                        type="text"
                        name="divisi"
                        value="{{ old('divisi') }}"
                        maxlength="100"
                        class="w-full border rounded p-2 text-sm"
                        required
                    >
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium">Tanggal Masuk</label>
                    <input type="date" name="tgl_masuk" value="{{ old('tgl_masuk') }}" class="w-full border rounded p-2 text-sm">
                </div>

                <div>
                    <label for="no_rekening" class="block mb-1 text-sm font-medium">
                        No Rekening
                    </label>

                    <input
                        type="text"
                        id="no_rekening"
                        name="no_rekening"
                        value="{{ old('no_rekening') }}"
                        inputmode="numeric"
                        pattern="[0-9]*"
                        minlength="6"
                        maxlength="18"
                        class="w-full border rounded p-2 text-sm"
                        placeholder="Contoh: 1234567890"
                        required
                        oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                    >
                </div>

                <div>
                    <label for="nama_bank" class="block mb-1 text-sm font-medium">
                        Nama Bank
                    </label>

                    <input
                        type="text"
                        id="nama_bank"
                        name="nama_bank"
                        value="{{ old('nama_bank') }}"
                        maxlength="50"
                        class="w-full border rounded p-2 text-sm"
                        placeholder="Contoh: BCA, BRI, BNI, Mandiri"
                        required
                    >
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="submit" class="bg-sky-600 text-white px-6 py-2 rounded text-sm">
                        Simpan
                    </button>

                    <a href="{{ route('hrd.data-karyawan.index') }}"
                       class="bg-gray-600 text-white px-6 py-2 rounded text-sm">
                        Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-layouts.hrd>