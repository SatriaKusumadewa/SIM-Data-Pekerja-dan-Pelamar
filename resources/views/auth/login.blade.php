<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Informasi SDM</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-[#eef1f8]">
    <div class="min-h-screen flex flex-col">

        {{-- HEADER ATAS --}}
        <header class="bg-sky-600 shadow">
            <div class="flex min-h-24 items-center px-6">
                <div class="leading-tight text-white">
                    <div class="text-2xl font-bold">
                        Sistem Informasi SDM
                    </div>

                    <div class="text-sm font-medium text-white/90 mt-1">
                        Pelamar &amp; Pekerja
                    </div>
                </div>
            </div>
        </header>

        {{-- AREA UTAMA --}}
        <main class="flex-1 flex items-center justify-center px-4 py-8">
            <div class="w-full max-w-5xl">
                <div class="mx-auto w-full max-w-4xl bg-white shadow-lg px-6 py-16 md:px-16">
                    <div class="max-w-sm mx-auto">

                        <h1 class="text-center text-3xl font-bold text-blue-600 mb-10">
                            Login
                        </h1>

                        @if ($errors->any())
                            <div class="mb-4 rounded bg-red-100 px-4 py-2 text-sm text-red-700">
                                <ul class="space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if (session('status'))
                            <div class="mb-4 rounded bg-green-100 px-4 py-2 text-sm text-green-700">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}" class="space-y-4">
                            @csrf

                            <div>
                                <input id="email"
                                       type="email"
                                       name="email"
                                       value="{{ old('email') }}"
                                       required
                                       autofocus
                                       placeholder="Email"
                                       class="w-full bg-gray-50 border-l-4 border-blue-500 border border-gray-200 px-4 py-3 text-base text-gray-700 outline-none focus:border-blue-600">
                            </div>

                            <div>
                                <input id="password"
                                       type="password"
                                       name="password"
                                       required
                                       placeholder="Password"
                                       class="w-full bg-gray-50 border-l-4 border-blue-500 border border-gray-200 px-4 py-3 text-base text-gray-700 outline-none focus:border-blue-600">
                            </div>

                            <div class="pt-1">
                                <button type="submit"
                                        class="w-full bg-blue-600 py-3 text-base font-bold uppercase tracking-wide text-white hover:bg-blue-700">
                                    Sign In
                                </button>
                            </div>

                            <div class="text-left pt-1">
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}"
                                       class="text-sm font-semibold text-black hover:underline">
                                        Forgot Password ?
                                    </a>
                                @else
                                    <span class="text-sm font-semibold text-black">
                                        Forgot Password ?
                                    </span>
                                @endif
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </main>

        {{-- FOOTER BAWAH --}}
        <footer class="h-14 bg-gray-500"></footer>
    </div>
</body>
</html>