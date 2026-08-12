<aside class="w-full bg-white flex flex-col border-r border-gray-100 sticky top-0" style="height: 100vh; height: 100dvh;">

    {{-- HEADER SIDEBAR --}}
    <div class="h-24 flex items-center px-8 shrink-0 border-b border-gray-50 bg-white z-10">
        {{-- Tempat Logo Saja --}}
        <img src="{{ asset('images/MCP.jpg') }}" alt="Logo Multicomp" class="h-12 w-auto object-contain drop-shadow-sm transition-transform hover:scale-105 duration-300">
    </div>

    {{-- MENU NAVIGASI (Dengan min-h-0 agar bisa di-scroll) --}}
    <nav class="flex-1 px-4 py-2 space-y-1 overflow-y-auto custom-scrollbar min-h-0">

        <span class="block px-4 pb-2 text-[11px] font-bold text-gray-400 tracking-wider uppercase mt-2">Menu Utama</span>

        {{-- DASHBOARD --}}
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition {{ request()->routeIs('dashboard') ? 'bg-rose-50 text-rose-600 font-bold' : 'text-gray-500 font-semibold hover:bg-gray-50 hover:text-rose-600' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
            </svg>
            Dashboard
        </a>

        <span class="block px-4 pt-6 pb-2 text-[11px] font-bold text-gray-400 tracking-wider uppercase">Master Data</span>

        {{-- DATA PETUGAS --}}
        <a href="{{ route('admin.superadmin.petugas.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition {{ request()->routeIs('admin.superadmin.petugas.*') ? 'bg-rose-50 text-rose-600 font-bold' : 'text-gray-500 font-semibold hover:bg-gray-50 hover:text-rose-600' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
            </svg>
            Data Petugas
        </a>

        {{-- DATA MEMBER --}}
        <a href="{{ route('admin.superadmin.members.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition {{ request()->routeIs('admin.superadmin.members.*') ? 'bg-rose-50 text-rose-600 font-bold' : 'text-gray-500 font-semibold hover:bg-gray-50 hover:text-rose-600' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
            </svg>
            Data Member
        </a>

        {{-- DATA JURUSAN --}}
        <a href="{{ route('admin.superadmin.majors.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition {{ request()->routeIs('admin.superadmin.majors.*') ? 'bg-rose-50 text-rose-600 font-bold' : 'text-gray-500 font-semibold hover:bg-gray-50 hover:text-rose-600' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
            </svg>
            Data Jurusan
        </a>

        {{-- DATA RAK BUKU --}}
        <a href="{{ route('admin.superadmin.shelves.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition {{ request()->routeIs('admin.superadmin.shelves.*') ? 'bg-rose-50 text-rose-600 font-bold' : 'text-gray-500 font-semibold hover:bg-gray-50 hover:text-rose-600' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
            </svg>
            Data Rak Buku
        </a>

        <span class="block px-4 pt-6 pb-2 text-[11px] font-bold text-gray-400 tracking-wider uppercase">Sistem</span>

        {{-- TANGGAL MERAH --}}
        <a href="{{ route('admin.superadmin.holidays.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition {{ request()->routeIs('admin.superadmin.holidays.*') ? 'bg-rose-50 text-rose-600 font-bold' : 'text-gray-500 font-semibold hover:bg-gray-50 hover:text-rose-600' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            Tanggal Merah
        </a>

        {{-- JADWAL PIKET --}}
        <a href="{{ route('admin.superadmin.schedules.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition {{ request()->routeIs('admin.superadmin.schedules.*') ? 'bg-rose-50 text-rose-600 font-bold' : 'text-gray-500 font-semibold hover:bg-gray-50 hover:text-rose-600' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            Jadwal Piket
        </a>

        {{-- HERO SLIDERS --}}
        <a href="{{ route('admin.superadmin.sliders.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition {{ request()->routeIs('admin.superadmin.sliders.*') ? 'bg-rose-50 text-rose-600 font-bold' : 'text-gray-500 font-semibold hover:bg-gray-50 hover:text-rose-600' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            Hero Sliders
        </a>

        <a href="{{ route('admin.superadmin.backup.index') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-semibold {{ request()->routeIs('admin.superadmin.backup.*') ? 'bg-emerald-50 text-emerald-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} rounded-xl transition">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
            </svg>
            Backup Database
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
