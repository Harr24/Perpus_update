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

        <main class="flex-1 overflow-y-auto p-4 lg:p-8 relative z-10">
            @yield('content')
        </main>
    </div>

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar-container').classList.toggle('-translate-x-full');
            document.getElementById('sidebar-overlay').classList.toggle('hidden');
        }
    </script>

    {{-- BARIS INI WAJIB ADA UNTUK MENAMPUNG @push('scripts') DARI HALAMAN LAIN --}}
    @stack('scripts')
</body>
</html>
