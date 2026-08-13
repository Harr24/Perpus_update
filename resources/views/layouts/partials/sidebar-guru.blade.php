<aside class="w-full bg-white flex flex-col border-r border-gray-100 sticky top-0" style="height: 100vh; height: 100dvh;">

    {{-- HEADER SIDEBAR --}}
    <div class="h-24 flex items-center px-8 shrink-0 border-b border-gray-50 bg-white z-10">
        <h1 class="text-2xl font-extrabold tracking-tight text-rose-700 uppercase">
            GURU.
        </h1>
    </div>

    {{-- MENU NAVIGASI --}}
    <nav class="flex-1 px-4 py-2 space-y-1 overflow-y-auto custom-scrollbar min-h-0">

        <span class="block px-4 pb-2 text-[11px] font-bold text-gray-400 tracking-wider uppercase mt-2">Menu Utama</span>

        {{-- DASHBOARD --}}
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition {{ request()->routeIs('dashboard') ? 'bg-rose-50 text-rose-600 font-bold' : 'text-gray-500 font-semibold hover:bg-gray-50 hover:text-rose-600' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
            </svg>
            Dashboard
        </a>

        <span class="block px-4 pt-6 pb-2 text-[11px] font-bold text-gray-400 tracking-wider uppercase">Pustaka & Materi</span>

        {{-- KELOLA MATERI --}}
        <a href="{{ route('guru.materials.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition {{ request()->routeIs('guru.materials.*') ? 'bg-rose-50 text-rose-600 font-bold' : 'text-gray-500 font-semibold hover:bg-gray-50 hover:text-rose-600' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
            </svg>
            Kelola Materi
        </a>

        {{-- KATALOG BUKU --}}
        <a href="{{ route('internal.catalog.all') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition {{ request()->routeIs('internal.catalog.*') ? 'bg-rose-50 text-rose-600 font-bold' : 'text-gray-500 font-semibold hover:bg-gray-50 hover:text-rose-600' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
            </svg>
            Katalog Buku
        </a>

        <span class="block px-4 pt-6 pb-2 text-[11px] font-bold text-gray-400 tracking-wider uppercase">Akun Pribadi</span>

        {{-- RIWAYAT PEMINJAMAN (MENU BARU) --}}
        <a href="{{ route('borrow.history') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition {{ request()->routeIs('borrow.history') ? 'bg-rose-50 text-rose-600 font-bold' : 'text-gray-500 font-semibold hover:bg-gray-50 hover:text-rose-600' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
            </svg>
            Riwayat Peminjaman
        </a>

        {{-- PROFIL SAYA --}}
        <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition {{ request()->routeIs('profile.*') ? 'bg-rose-50 text-rose-600 font-bold' : 'text-gray-500 font-semibold hover:bg-gray-50 hover:text-rose-600' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
            </svg>
            Profil Saya
        </a>

        <div class="h-6"></div>
    </nav>

    {{-- FOOTER / TOMBOL LOGOUT --}}
    <div class="p-4 border-t border-gray-100 shrink-0 bg-white mt-auto">
        <form action="{{ route('logout') }}" method="POST" class="m-0">
            @csrf
            <button type="submit" class="w-full flex items-center justify-center gap-3 px-4 py-3.5 rounded-2xl text-rose-600 font-bold hover:bg-rose-50 transition shadow-sm border border-transparent hover:border-rose-100">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                </svg>
                Log out
            </button>
        </form>
    </div>
</aside>

<style>
    /* Desain scrollbar agar mulus */
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 4px; }
    .custom-scrollbar:hover::-webkit-scrollbar-thumb { background: #cbd5e1; }
</style>
