<x-layouts.hrd title="Edit Karyawan">
    <div class="bg-white shadow rounded max-w-4xl">
        <div class="px-6 py-5 border-b">
            <h1 class="text-2xl font-semibold">Edit Karyawan</h1>
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

            <form action="{{ route('hrd.data-karyawan.update', $karyawan->nik) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label for="nik" class="block mb-1 text-sm font-medium">
                        NIK
                    </label>

                    <input
                        type="text"
                        id="nik"
                        name="nik"
                        value="{{ old('nik', $karyawan->nik) }}"
                        inputmode="numeric"
                        pattern="[0-9]*"
                        minlength="16"
                        maxlength="16"
                        class="w-full border rounded p-2 text-sm"
                        placeholder="Contoh: 3515010101010001"
                        required
                        oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                    >

                    <p class="mt-1 text-xs text-gray-500">
                        NIK diisi angka saja dan harus 16 digit.
                    </p>
                </div>

                <div>
                    <label for="nama_karyawan" class="block mb-1 text-sm font-medium">
                        Nama Karyawan
                    </label>

                    <input
                        type="text"
                        id="nama_karyawan"
                        name="nama_karyawan"
                        value="{{ old('nama_karyawan', $karyawan->nama_karyawan) }}"
                        maxlength="100"
                        class="w-full border rounded p-2 text-sm"
                        required
                    >
                </div>

                <div>
                    <label for="jenis_kelamin" class="block mb-1 text-sm font-medium">
                        Jenis Kelamin
                    </label>

                    <input
                        type="text"
                        id="jenis_kelamin"
                        name="jenis_kelamin"
                        value="{{ old('jenis_kelamin', $karyawan->jenis_kelamin) }}"
                        maxlength="20"
                        class="w-full border rounded p-2 text-sm"
                        placeholder="Laki-laki / Perempuan"
                        required
                    >
                </div>

                <div>
                    <label for="tempat_lahir" class="block mb-1 text-sm font-medium">
                        Tempat Lahir
                    </label>

                    <input
                        type="text"
                        id="tempat_lahir"
                        name="tempat_lahir"
                        value="{{ old('tempat_lahir', $karyawan->tempat_lahir) }}"
                        maxlength="100"
                        class="w-full border rounded p-2 text-sm"
                    >
                </div>

                <div>
                    <label for="tgl_lahir" class="block mb-1 text-sm font-medium">
                        Tanggal Lahir
                    </label>

                    <input
                        type="date"
                        id="tgl_lahir"
                        name="tgl_lahir"
                        value="{{ old('tgl_lahir', $karyawan->tgl_lahir ? \Carbon\Carbon::parse($karyawan->tgl_lahir)->format('Y-m-d') : '') }}"
                        class="w-full border rounded p-2 text-sm"
                    >
                </div>

                <div>
                    <label for="alamat" class="block mb-1 text-sm font-medium">
                        Alamat
                    </label>

                    <textarea
                        id="alamat"
                        name="alamat"
                        rows="3"
                        maxlength="255"
                        class="w-full border rounded p-2 text-sm"
                    >{{ old('alamat', $karyawan->alamat) }}</textarea>

                    <p class="mt-1 text-xs text-gray-500">
                        Alamat maksimal 255 karakter.
                    </p>
                </div>

                <div>
                    <label for="no_telepon" class="block mb-1 text-sm font-medium">
                        No Telepon
                    </label>

                    <input
                        type="text"
                        id="no_telepon"
                        name="no_telepon"
                        value="{{ old('no_telepon', $karyawan->no_telepon) }}"
                        inputmode="numeric"
                        pattern="[0-9]*"
                        minlength="10"
                        maxlength="15"
                        class="w-full border rounded p-2 text-sm"
                        placeholder="Contoh: 081234567890"
                        required
                        oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                    >

                    <p class="mt-1 text-xs text-gray-500">
                        No telepon diisi angka saja, minimal 10 digit dan maksimal 15 digit.
                    </p>
                </div>

                <div>
                    <label for="email" class="block mb-1 text-sm font-medium">
                        Email
                    </label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email', $karyawan->email) }}"
                        maxlength="100"
                        class="w-full border rounded p-2 text-sm"
                    >
                </div>

                <div>
                    <label for="jabatan" class="block mb-1 text-sm font-medium">
                        Jabatan
                    </label>

                    <input
                        type="text"
                        id="jabatan"
                        name="jabatan"
                        value="{{ old('jabatan', $karyawan->jabatan) }}"
                        maxlength="100"
                        class="w-full border rounded p-2 text-sm"
                        required
                    >
                </div>

                <div>
                    <label for="divisi" class="block mb-1 text-sm font-medium">
                        Divisi
                    </label>

                    <input
                        type="text"
                        id="divisi"
                        name="divisi"
                        value="{{ old('divisi', $karyawan->divisi) }}"
                        maxlength="100"
                        class="w-full border rounded p-2 text-sm"
                        required
                    >
                </div>

                <div>
                    <label for="tgl_masuk" class="block mb-1 text-sm font-medium">
                        Tanggal Masuk
                    </label>

                    <input
                        type="date"
                        id="tgl_masuk"
                        name="tgl_masuk"
                        value="{{ old('tgl_masuk', $karyawan->tgl_masuk ? \Carbon\Carbon::parse($karyawan->tgl_masuk)->format('Y-m-d') : '') }}"
                        class="w-full border rounded p-2 text-sm"
                        required
                    >
                </div>

                <div>
                    <label for="no_rekening" class="block mb-1 text-sm font-medium">
                        No Rekening
                    </label>

                    <input
                        type="text"
                        id="no_rekening"
                        name="no_rekening"
                        value="{{ old('no_rekening', $karyawan->no_rekening) }}"
                        inputmode="numeric"
                        pattern="[0-9]*"
                        minlength="6"
                        maxlength="18"
                        class="w-full border rounded p-2 text-sm"
                        placeholder="Contoh: 1234567890"
                        required
                        oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                    >

                    <p class="mt-1 text-xs text-gray-500">
                        Nomor rekening diisi angka saja, minimal 6 digit dan maksimal 18 digit.
                    </p>
                </div>

                <div>
                    <label for="nama_bank" class="block mb-1 text-sm font-medium">
                        Nama Bank
                    </label>

                    <input
                        type="text"
                        id="nama_bank"
                        name="nama_bank"
                        value="{{ old('nama_bank', $karyawan->nama_bank) }}"
                        maxlength="50"
                        class="w-full border rounded p-2 text-sm"
                        placeholder="Contoh: BCA, BRI, BNI, Mandiri"
                        required
                    >

                    <p class="mt-1 text-xs text-gray-500">
                        Isi nama bank sesuai data rekening, misalnya BCA, BRI, BNI, Mandiri, atau BSI.
                    </p>
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="submit" class="bg-sky-600 text-white px-6 py-2 rounded text-sm">
                        Simpan Perubahan
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