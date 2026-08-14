<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - My MultiComp Library</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-white text-gray-800 antialiased flex h-screen overflow-hidden relative">

    <div id="sidebar-overlay" class="fixed inset-0 bg-black/20 z-40 hidden lg:hidden backdrop-blur-sm" onclick="toggleSidebar()"></div>

    @auth
        <div id="sidebar-container" class="fixed lg:static inset-y-0 left-0 z-50 w-64 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out bg-white h-full border-r border-gray-100 flex-shrink-0">
            @include('layouts.partials.sidebar-' . auth()->user()->role)
        </div>
    @endauth

    <div class="flex-1 flex flex-col relative h-screen overflow-hidden bg-white w-full">

        <div class="absolute top-0 left-0 right-0 h-[280px] bg-[#F4F1EA] rounded-bl-[4rem] z-0 pointer-events-none"></div>

        @auth
            <div class="relative z-10">
                @include('layouts.partials.header-' . auth()->user()->role)
            </div>
        @endauth

        {{--Tambah flex flex-col pada main --}}
        <main class="flex-1 overflow-y-auto p-4 lg:p-8 relative z-10 flex flex-col">

            {{-- Wrapper flex-1 agar konten menolak footer ke bawah --}}
            <div class="flex-1">
                @yield('content')
            </div>

            {{-- FOOTER INTERNAL --}}
            <footer class="mt-10 pt-6 pb-2 border-t border-gray-200/60">
                <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                    <p class="text-sm font-medium text-gray-500 text-center md:text-left">
                        &copy; {{ date('Y') }} <span class="font-extrabold text-rose-700">Perpustakaan SMK Multicomp</span>.
                    </p>
                </div>
            </footer>

        </main>
    </div>

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar-container').classList.toggle('-translate-x-full');
            document.getElementById('sidebar-overlay').classList.toggle('hidden');
        }
    </script>

    @auth
    <form id="autoLogoutForm" action="{{ route('logout') }}" method="POST" class="hidden">
        @csrf
    </form>

    <script>
        let idleTimer;
        const idleLimit = 180000;

        function logoutUser() {
            // Submit form logout secara otomatis
            document.getElementById('autoLogoutForm').submit();
        }

        function resetIdleTimer() {
            // Hapus timer yang lama
            clearTimeout(idleTimer);
            // Mulai ulang timer dari awal
            idleTimer = setTimeout(logoutUser, idleLimit);
        }

        // Daftar interaksi user yang menandakan mereka masih aktif
        const userActivities = ['mousemove', 'mousedown', 'keydown', 'scroll', 'touchstart', 'wheel'];

        // Pasang sensor (event listener) ke seluruh halaman
        userActivities.forEach(function(activity) {
            document.addEventListener(activity, resetIdleTimer, true);
        });

        // Jalankan timer saat halaman pertama kali dimuat
        resetIdleTimer();
    </script>
    @endauth

    {{-- BARIS INI WAJIB ADA UNTUK MENAMPUNG @push('scripts') DARI HALAMAN LAIN --}}
    @stack('scripts')
</body>
</html>
