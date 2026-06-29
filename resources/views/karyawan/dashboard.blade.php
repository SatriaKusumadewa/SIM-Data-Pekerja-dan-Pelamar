<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Dashboard Karyawan
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">Profil Saya</h3>
                    <p class="text-gray-600 dark:text-gray-300 mt-2">Melihat data pribadi karyawan.</p>
                </div>

                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">Dokumen Saya</h3>
                    <p class="text-gray-600 dark:text-gray-300 mt-2">Melihat dokumen pribadi karyawan.</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>