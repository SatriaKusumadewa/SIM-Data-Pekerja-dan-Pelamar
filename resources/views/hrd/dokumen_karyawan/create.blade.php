<x-layouts.hrd title="Upload Dokumen Karyawan">
    <div class="bg-white shadow rounded max-w-4xl">
        <div class="px-6 py-5 border-b">
            <h1 class="text-2xl font-semibold">
                Dokumen Karyawan - {{ $karyawan->nama_karyawan }}
            </h1>
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

            <form action="{{ route('hrd.data-karyawan.dokumen.store', ['karyawan' => $karyawan->nik]) }}"
                  method="POST"
                  enctype="multipart/form-data"
                  class="space-y-6">
                @csrf

                {{-- KTP --}}
                <div>
                    <label class="block mb-1 text-sm font-medium">
                        KTP
                    </label>

                    <input type="file"
                           name="ktp"
                           class="w-full border rounded p-2 text-sm">

                    @if($dokumen?->ktp_path)
                        <div class="mt-2 flex items-center gap-3">
                            <span class="text-sm font-semibold text-green-600">
                                File sudah ada
                            </span>

                            <a href="{{ route('hrd.dokumen-karyawan.preview', [$karyawan->nik, 'ktp']) }}"
                               class="rounded bg-sky-600 px-3 py-1 text-xs text-white hover:bg-sky-700">
                                Preview KTP
                            </a>
                        </div>
                    @else
                        <p class="mt-1 text-sm text-gray-500">
                            Belum ada file.
                        </p>
                    @endif
                </div>

                {{-- Ijazah --}}
                <div>
                    <label class="block mb-1 text-sm font-medium">
                        Ijazah
                    </label>

                    <input type="file"
                           name="ijazah"
                           class="w-full border rounded p-2 text-sm">

                    @if($dokumen?->ijazah_path)
                        <div class="mt-2 flex items-center gap-3">
                            <span class="text-sm font-semibold text-green-600">
                                File sudah ada
                            </span>

                            <a href="{{ route('hrd.dokumen-karyawan.preview', [$karyawan->nik, 'ijazah']) }}"
                               class="rounded bg-sky-600 px-3 py-1 text-xs text-white hover:bg-sky-700">
                                Preview Ijazah
                            </a>
                        </div>
                    @else
                        <p class="mt-1 text-sm text-gray-500">
                            Belum ada file.
                        </p>
                    @endif
                </div>

                {{-- Foto --}}
                <div>
                    <label class="block mb-1 text-sm font-medium">
                        Foto
                    </label>

                    <input type="file"
                           name="foto"
                           class="w-full border rounded p-2 text-sm">

                    @if($dokumen?->foto_path)
                        <div class="mt-2 flex items-center gap-3">
                            <span class="text-sm font-semibold text-green-600">
                                File sudah ada
                            </span>

                            <a href="{{ route('hrd.dokumen-karyawan.preview', [$karyawan->nik, 'foto']) }}"
                            class="rounded bg-sky-600 px-3 py-1 text-xs text-white hover:bg-sky-700">
                                Preview Foto
                            </a>
                        </div>
                    @else
                        <p class="mt-1 text-sm text-gray-500">
                            Belum ada file.
                        </p>
                    @endif
                </div>

                {{-- Buku Rekening --}}
                <div>
                    <label class="block mb-1 text-sm font-medium">
                        Buku Rekening
                    </label>

                    <input type="file"
                           name="buku_rekening"
                           class="w-full border rounded p-2 text-sm">

                    @if($dokumen?->buku_rekening_path)
                        <div class="mt-2 flex items-center gap-3">
                            <span class="text-sm font-semibold text-green-600">
                                File sudah ada
                            </span>

                            <a href="{{ route('hrd.dokumen-karyawan.preview', [$karyawan->nik, 'buku_rekening']) }}"
                               class="rounded bg-sky-600 px-3 py-1 text-xs text-white hover:bg-sky-700">
                                Preview Buku Rekening
                            </a>
                        </div>
                    @else
                        <p class="mt-1 text-sm text-gray-500">
                            Belum ada file.
                        </p>
                    @endif
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="submit" class="bg-sky-600 text-white px-6 py-2 rounded text-sm hover:bg-sky-700">
                        Simpan
                    </button>

                    <a href="{{ route('hrd.dokumen-karyawan.index') }}"
                       class="bg-gray-600 text-white px-6 py-2 rounded text-sm hover:bg-gray-700">
                        Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-layouts.hrd>