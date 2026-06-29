<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Preview CV - {{ $pelamar->nama }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                <div class="mb-4">
                    <a href="{{ route('hrd.pelamars.cv.download', $pelamar->id) }}"
                       class="bg-green-600 text-white px-4 py-2 rounded">
                        Download CV
                    </a>

                    <a href="{{ route('pelamars.show', $pelamar->id) }}"
                       class="bg-gray-600 text-white px-4 py-2 rounded ml-2">
                        Kembali
                    </a>
                </div>

                <iframe src="{{ $previewUrl }}"
                        width="100%"
                        height="700px"
                        style="border: none;">
                </iframe>
            </div>
        </div>
    </div>
</x-app-layout>