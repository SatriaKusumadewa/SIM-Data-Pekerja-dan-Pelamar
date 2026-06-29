<x-layouts.hrd title="Preview Dokumen Karyawan">
    <style>
        .preview-page {
            height: calc(100vh - var(--role-header-height, 64px) - 90px);
            min-height: 620px;
        }

        .preview-frame {
            width: 100%;
            height: calc(100vh - var(--role-header-height, 64px) - 220px);
            min-height: 520px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            background: #ffffff;
        }

        .preview-image-wrapper {
            height: calc(100vh - var(--role-header-height, 64px) - 220px);
            min-height: 520px;
            overflow: auto;
        }

        .preview-image {
            max-width: 100%;
            min-width: 70%;
            height: auto;
        }

        @media (max-width: 768px) {
            .preview-page {
                height: auto;
                min-height: 520px;
            }

            .preview-frame,
            .preview-image-wrapper {
                height: 70vh;
                min-height: 420px;
            }

            .preview-image {
                min-width: 100%;
            }
        }
    </style>

    <div class="preview-page bg-white shadow rounded flex flex-col">
        <div class="px-6 py-4 border-b">
            <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-2xl font-semibold">
                        Preview {{ $label }}
                    </h1>

                    <p class="mt-1 text-sm text-gray-500">
                        Menampilkan preview dokumen {{ $label }} milik {{ $dataKaryawan->nama_karyawan ?? '-' }}.
                    </p>
                </div>

                <a href="{{ route('hrd.data-karyawan.dokumen.create', ['karyawan' => $karyawan]) }}"
                   class="inline-flex w-fit items-center justify-center rounded bg-gray-600 px-5 py-2 text-sm text-white hover:bg-gray-700">
                    Kembali
                </a>
            </div>
        </div>

        <div class="flex-1 p-4">
            @if(str_contains($mimeType, 'pdf'))
                <iframe
                    src="{{ route('hrd.dokumen-karyawan.preview-file', [$karyawan, $jenis]) }}#zoom=125&view=FitH&toolbar=1&navpanes=0&scrollbar=1"
                    class="preview-frame"
                ></iframe>
            @elseif(str_contains($mimeType, 'image'))
                <div class="preview-image-wrapper rounded border border-gray-300 bg-gray-100 p-4">
                    <div class="flex justify-center">
                        <img
                            src="{{ route('hrd.dokumen-karyawan.preview-file', [$karyawan, $jenis]) }}"
                            alt="Preview {{ $label }}"
                            class="preview-image rounded border bg-white object-contain shadow"
                        >
                    </div>
                </div>
            @else
                <div class="rounded bg-yellow-100 p-4 text-sm text-yellow-800">
                    Format dokumen tidak dapat ditampilkan langsung di browser.
                </div>
            @endif
        </div>
    </div>
</x-layouts.hrd>