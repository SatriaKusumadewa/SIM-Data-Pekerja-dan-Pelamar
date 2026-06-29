<x-layouts.karyawan title="Preview Dokumen">
    <div class="bg-white shadow rounded">
        <div class="px-6 py-5 border-b flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-semibold">
                    Preview {{ $label }}
                </h1>

                <p class="mt-1 break-all text-sm text-gray-500">
                    {{ $downloadName }}
                </p>
            </div>

            <div class="flex flex-wrap gap-2">
                <a href="{{ route('karyawan.dokumen') }}"
                   class="rounded bg-gray-600 px-4 py-2 text-sm text-white hover:bg-gray-700">
                    Kembali
                </a>

                <a href="{{ route('karyawan.dokumen.download', $jenis) }}"
                   class="rounded bg-green-600 px-4 py-2 text-sm text-white hover:bg-green-700">
                    Download
                </a>
            </div>
        </div>

        <div class="p-4 sm:p-6">
            @if($isImage)
                <div class="flex justify-center rounded border bg-gray-50 p-3">
                    <img
                        src="data:{{ $mimeType }};base64,{{ $base64 }}"
                        alt="Preview {{ $label }}"
                        class="max-h-[75vh] max-w-full rounded"
                    >
                </div>
            @elseif($isPdf)

                <div
                    id="pdfViewer"
                    class="space-y-4 rounded border bg-gray-100 p-3"
                >
                    <div id="pdfLoading" class="rounded bg-white p-4 text-sm text-gray-600">
                        Memuat preview PDF...
                    </div>
                </div>

                <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
                <script>
                    document.addEventListener('DOMContentLoaded', async function () {
                        const viewer = document.getElementById('pdfViewer');
                        const loading = document.getElementById('pdfLoading');
                        const fallback = document.getElementById('pdfFallback');

                        try {
                            if (typeof pdfjsLib === 'undefined') {
                                throw new Error('PDF.js tidak tersedia.');
                            }

                            pdfjsLib.GlobalWorkerOptions.workerSrc =
                                'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';

                            const base64 = @json($base64);
                            const binary = atob(base64);
                            const bytes = new Uint8Array(binary.length);

                            for (let i = 0; i < binary.length; i++) {
                                bytes[i] = binary.charCodeAt(i);
                            }

                            const pdf = await pdfjsLib.getDocument({ data: bytes }).promise;

                            if (loading) {
                                loading.remove();
                            }

                            for (let pageNumber = 1; pageNumber <= pdf.numPages; pageNumber++) {
                                const page = await pdf.getPage(pageNumber);

                                const containerWidth = Math.min(viewer.clientWidth - 24, 900);
                                const viewportOriginal = page.getViewport({ scale: 1 });
                                const scale = containerWidth / viewportOriginal.width;
                                const viewport = page.getViewport({ scale: scale });

                                const canvas = document.createElement('canvas');
                                const context = canvas.getContext('2d');

                                canvas.width = viewport.width;
                                canvas.height = viewport.height;
                                canvas.className = 'mx-auto block max-w-full rounded bg-white shadow';

                                const pageWrapper = document.createElement('div');
                                pageWrapper.className = 'rounded bg-white p-2 shadow-sm';
                                pageWrapper.appendChild(canvas);

                                viewer.appendChild(pageWrapper);

                                await page.render({
                                    canvasContext: context,
                                    viewport: viewport
                                }).promise;
                            }
                        } catch (error) {
                            if (loading) {
                                loading.remove();
                            }

                            if (fallback) {
                                fallback.classList.remove('hidden');
                            }
                        }
                    });
                </script>
            @else
                <div class="rounded bg-yellow-100 p-4 text-sm text-yellow-800">
                    Jenis file ini tidak dapat dipreview langsung di browser.
                    Silakan gunakan tombol Download.
                </div>
            @endif
        </div>
    </div>
</x-layouts.karyawan>