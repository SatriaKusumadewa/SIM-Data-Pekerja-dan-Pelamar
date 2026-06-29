<x-layouts.admin title="Dashboard Admin">
    <div class="bg-white shadow rounded">
        <div class="px-6 py-5 border-b">
            <h1 class="text-2xl font-semibold">Dashboard</h1>
        </div>

        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-gradient-to-b from-white to-gray-50 border border-gray-300 shadow-[0_4px_12px_rgba(0,0,0,0.14)] rounded-md px-4 py-3">
                    <p class="text-xs text-gray-500">Total User</p>
                    <p class="text-2xl font-semibold text-gray-900 mt-1">{{ $totalUser }}</p>
                </div>

                <div class="bg-gradient-to-b from-white to-gray-50 border border-gray-300 shadow-[0_4px_12px_rgba(0,0,0,0.14)] rounded-md px-4 py-3">
                    <p class="text-xs text-gray-500">Total Karyawan</p>
                    <p class="text-2xl font-semibold text-gray-900 mt-1">{{ $totalKaryawan }}</p>
                </div>

                <div class="bg-gradient-to-b from-white to-gray-50 border border-gray-300 shadow-[0_4px_12px_rgba(0,0,0,0.14)] rounded-md px-4 py-3">
                    <p class="text-xs text-gray-500">Total Pelamar</p>
                    <p class="text-2xl font-semibold text-gray-900 mt-1">{{ $totalPelamar }}</p>
                </div>

                <div class="bg-gradient-to-b from-white to-gray-50 border border-gray-300 shadow-[0_4px_12px_rgba(0,0,0,0.14)] rounded-md px-4 py-3">
                    <p class="text-xs text-gray-500">Total Role</p>
                    <p class="text-2xl font-semibold text-gray-900 mt-1">{{ $totalRole }}</p>
                </div>
            </div>
        </div>
    </div>
</x-layouts.admin>