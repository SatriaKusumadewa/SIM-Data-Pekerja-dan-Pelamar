<x-layouts.hrd title="Dashboard">
    <style>
        .hrd-dashboard-card-wrapper {
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: stretch;
            gap: 20px;
            width: 100%;
        }

        .hrd-dashboard-card {
            width: 32%;
            min-width: 240px;
            max-width: 360px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            background-color: #ffffff;
            padding: 20px;
            box-shadow: 0 8px 18px rgba(0, 0, 0, 0.08);
        }

        @media (max-width: 768px) {
            .hrd-dashboard-card-wrapper {
                flex-direction: column;
            }

            .hrd-dashboard-card {
                width: 100%;
                max-width: 100%;
            }
        }
    </style>

    <div class="rounded bg-white shadow">
        <div class="border-b px-6 py-5">
            <h1 class="text-2xl font-semibold text-gray-900">
                Dashboard
            </h1>
        </div>

        <div class="px-6 py-8">
            <div class="hrd-dashboard-card-wrapper">
                <div class="hrd-dashboard-card">
                    <p class="text-sm text-gray-500">
                        Total User
                    </p>

                    <h2 class="mt-2 text-3xl font-bold text-gray-900">
                        {{ $totalUser ?? $totalUsers ?? 0 }}
                    </h2>
                </div>

                <div class="hrd-dashboard-card">
                    <p class="text-sm text-gray-500">
                        Total Karyawan
                    </p>

                    <h2 class="mt-2 text-3xl font-bold text-gray-900">
                        {{ $totalKaryawan ?? 0 }}
                    </h2>
                </div>

                <div class="hrd-dashboard-card">
                    <p class="text-sm text-gray-500">
                        Total Pelamar
                    </p>

                    <h2 class="mt-2 text-3xl font-bold text-gray-900">
                        {{ $totalPelamar ?? 0 }}
                    </h2>
                </div>
            </div>
        </div>
    </div>
</x-layouts.hrd>