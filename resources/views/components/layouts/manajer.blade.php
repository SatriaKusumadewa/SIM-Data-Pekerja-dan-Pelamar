@props(['title' => 'Manajer'])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title }} - {{ config('app.name', 'Sistem Karyawan') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .role-sidebar {
            top: var(--role-header-height, 64px);
            bottom: 64px;
            width: 320px;
            transform: translateX(-100%);
        }

        .role-sidebar-overlay {
            top: var(--role-header-height, 64px);
            bottom: 64px;
        }

        .role-main-content {
            padding-top: var(--role-header-height, 64px);
            padding-bottom: 140px;
        }

        @media (max-width: 767px) {
            .role-sidebar {
                width: 72vw;
                max-width: 320px;
            }

            .role-user-name {
                display: block;
                max-width: 72px;
                font-size: 12px;
                line-height: 1.1;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }
        }
    </style>
</head>

<body class="min-h-screen bg-gray-100 font-sans antialiased text-gray-900 overflow-x-hidden">
    <div class="min-h-screen w-full overflow-x-hidden">
        {{-- HEADER --}}
        <header id="roleHeader" class="fixed top-0 inset-x-0 z-[60] w-full bg-sky-600 text-white shadow">
            <div class="flex min-h-16 items-center justify-between gap-3 px-4 py-3">
                <div class="flex min-w-0 items-center gap-3">
                    <button
                        id="sidebarToggleButton"
                        type="button"
                        class="inline-flex shrink-0 items-center justify-center rounded-md border border-white/70 bg-sky-700 px-3 py-2 text-white hover:bg-sky-800 focus:outline-none focus:ring-2 focus:ring-white"
                        aria-label="Buka atau tutup sidebar"
                    >
                        ☰
                    </button>

                    <div class="leading-tight">
                        <div class="text-2xl font-bold text-white">
                            Sistem Informasi SDM
                        </div>
                        <div class="text-sm font-medium text-white/90">
                            Pelamar &amp; Pekerja
                        </div>
                    </div>
                </div>

                {{-- Search Desktop --}}
                <form method="GET"
                      action="{{ route('manajer.search') }}"
                      class="hidden flex-1 justify-center px-4 sm:flex">
                    <input
                        type="text"
                        name="q"
                        value="{{ request('q') }}"
                        placeholder="Cari..."
                        class="w-full max-w-xl rounded-full border border-gray-300 px-4 py-2 text-sm text-gray-700 focus:border-sky-500 focus:outline-none focus:ring-1 focus:ring-sky-500"
                    >
                </form>

                <div class="flex min-w-0 shrink-0 items-center gap-2">
                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-white font-bold text-sky-700">
                        {{ strtoupper(substr(Auth::user()->name ?? 'M', 0, 1)) }}
                    </div>

                    <div class="role-user-name truncate text-sm font-medium text-white">
                        {{ Auth::user()->name ?? 'Manajer' }}
                    </div>
                </div>
            </div>

            {{-- Search Mobile --}}
            <form method="GET"
                  action="{{ route('manajer.search') }}"
                  class="px-4 pb-3 sm:hidden">
                <input
                    type="text"
                    name="q"
                    value="{{ request('q') }}"
                    placeholder="Cari..."
                    class="w-full rounded-full border border-gray-300 px-4 py-2 text-sm text-gray-700 focus:border-sky-500 focus:outline-none focus:ring-1 focus:ring-sky-500"
                >
            </form>
        </header>

        {{-- OVERLAY MOBILE --}}
        <div
            id="sidebarOverlay"
            class="role-sidebar-overlay fixed left-0 right-0 z-40 hidden bg-black/40 md:hidden"
        ></div>

        {{-- SIDEBAR --}}
        <aside
            id="appSidebar"
            class="role-sidebar fixed left-0 z-50 flex flex-col border-r border-sky-500 bg-white shadow-lg transition-transform duration-200"
        >
            <div class="border-b px-6 py-5">
                <h2 class="text-2xl font-bold text-gray-900">Manajer</h2>
            </div>

            <div class="flex-1 overflow-y-auto p-6">
                <nav class="space-y-3">
                    <a href="{{ route('manajer.dashboard') }}"
                       class="block rounded border px-4 py-2 text-base transition
                       {{ request()->routeIs('manajer.dashboard')
                            ? 'border-sky-600 bg-sky-600 text-white'
                            : 'border-gray-100 bg-white text-gray-800 hover:border-sky-600 hover:bg-sky-600 hover:text-white' }}">
                        Dashboard
                    </a>

                    <a href="{{ route('manajer.data-karyawan.index') }}"
                       class="block rounded border px-4 py-2 text-base transition
                       {{ request()->routeIs('manajer.data-karyawan.*')
                            ? 'border-sky-600 bg-sky-600 text-white'
                            : 'border-gray-100 bg-white text-gray-800 hover:border-sky-600 hover:bg-sky-600 hover:text-white' }}">
                        Data Karyawan
                    </a>

                    <a href="{{ route('manajer.data-pelamar.index') }}"
                       class="block rounded border px-4 py-2 text-base transition
                       {{ request()->routeIs('manajer.data-pelamar.*')
                            ? 'border-sky-600 bg-sky-600 text-white'
                            : 'border-gray-100 bg-white text-gray-800 hover:border-sky-600 hover:bg-sky-600 hover:text-white' }}">
                         Pelamar Divisi
                    </a>
                </nav>
            </div>

            <div class="border-t p-6">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button type="submit"
                            class="w-full rounded bg-sky-600 px-4 py-2 text-base text-white hover:bg-sky-700">
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        {{-- MAIN CONTENT --}}
        <main
            id="mainContent"
            class="role-main-content min-w-0 px-4 py-4 transition-all duration-200 sm:px-6 lg:px-8"
        >
            <div class="mx-auto w-full max-w-7xl">
                {{ $slot }}
            </div>
        </main>

        {{-- FOOTER --}}
        <footer
            id="proposalFooter"
            style="
                position: fixed;
                left: 0;
                right: 0;
                bottom: 0;
                height: 64px;
                background-color: #6b7280;
                z-index: 9999;
            "
        ></footer>
    </div>

    <script>
        (function () {
            const sidebar = document.getElementById('appSidebar');
            const mainContent = document.getElementById('mainContent');
            const overlay = document.getElementById('sidebarOverlay');
            const toggleButton = document.getElementById('sidebarToggleButton');
            const roleHeader = document.getElementById('roleHeader');

            if (!sidebar || !mainContent || !toggleButton) return;

            const sidebarWidth = '320px';
            let sidebarOpen = window.innerWidth >= 768;

            function updateHeaderHeight() {
                if (!roleHeader) return;

                document.documentElement.style.setProperty(
                    '--role-header-height',
                    roleHeader.offsetHeight + 'px'
                );
            }

            function renderSidebar() {
                if (sidebarOpen) {
                    sidebar.style.transform = 'translateX(0)';

                    if (window.innerWidth >= 768) {
                        mainContent.style.marginLeft = sidebarWidth;
                    } else {
                        mainContent.style.marginLeft = '0';
                    }

                    if (overlay && window.innerWidth < 768) {
                        overlay.classList.remove('hidden');
                    }
                } else {
                    sidebar.style.transform = 'translateX(-100%)';
                    mainContent.style.marginLeft = '0';

                    if (overlay) {
                        overlay.classList.add('hidden');
                    }
                }
            }

            toggleButton.addEventListener('click', function () {
                sidebarOpen = !sidebarOpen;
                renderSidebar();
            });

            if (overlay) {
                overlay.addEventListener('click', function () {
                    sidebarOpen = false;
                    renderSidebar();
                });
            }

            window.addEventListener('resize', function () {
                updateHeaderHeight();
                sidebarOpen = window.innerWidth >= 768;
                renderSidebar();
            });

            updateHeaderHeight();
            renderSidebar();

            setTimeout(function () {
                updateHeaderHeight();
                renderSidebar();
            }, 100);
        })();
    </script>
</body>
</html>