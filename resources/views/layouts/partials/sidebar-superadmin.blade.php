<aside class="w-full bg-white flex flex-col border-r border-gray-100 sticky top-0" style="height: 100vh; height: 100dvh;">

    {{-- HEADER SIDEBAR --}}

    <div class="h-24 flex items-center px-8 shrink-0 border-b border-gray-50 bg-white z-10">
        {{-- Tempat Logo Saja --}}
        <img src="{{ asset('images/MCP.jpg') }}" alt="Logo Multicomp" class="h-12 w-auto object-contain drop-shadow-sm transition-transform hover:scale-105 duration-300">
    </div>

    {{--<div class="h-24 flex items-center px-8 shrink-0">
        <h1 class="text-xl font-extrabold tracking-tight text-gray-900 uppercase">
            Multicomp.
        </h1>
    </div>--}}

    {{-- MENU NAVIGASI (Dengan min-h-0 agar bisa di-scroll) --}}
    <nav class="flex-1 px-4 py-2 space-y-1 overflow-y-auto custom-scrollbar min-h-0">

        <span class="block px-4 pb-2 text-[11px] font-bold text-gray-400 tracking-wider uppercase mt-2">Menu Utama</span>

        {{-- DASHBOARD --}}
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition {{ request()->routeIs('dashboard') ? 'bg-rose-50 text-rose-600 font-bold' : 'text-gray-500 font-semibold hover:bg-gray-50 hover:text-rose-600' }}">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>
            Dashboard
        </a>

        <span class="block px-4 pt-6 pb-2 text-[11px] font-bold text-gray-400 tracking-wider uppercase">Master Data</span>

        {{-- DATA PETUGAS --}}
        <a href="{{ route('admin.superadmin.petugas.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition {{ request()->routeIs('admin.superadmin.petugas.*') ? 'bg-rose-50 text-rose-600 font-bold' : 'text-gray-500 font-semibold hover:bg-gray-50 hover:text-rose-600' }}">
            <span class="text-lg">👮</span> Data Petugas
        </a>

        {{-- DATA MEMBER --}}
        <a href="{{ route('admin.superadmin.members.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition {{ request()->routeIs('admin.superadmin.members.*') ? 'bg-rose-50 text-rose-600 font-bold' : 'text-gray-500 font-semibold hover:bg-gray-50 hover:text-rose-600' }}">
            <span class="text-lg">👥</span> Data Member
        </a>

        {{-- DATA JURUSAN --}}
        <a href="{{ route('admin.superadmin.majors.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition {{ request()->routeIs('admin.superadmin.majors.*') ? 'bg-rose-50 text-rose-600 font-bold' : 'text-gray-500 font-semibold hover:bg-gray-50 hover:text-rose-600' }}">
            <span class="text-lg">🏫</span> Data Jurusan
        </a>

        {{-- DATA RAK BUKU --}}
        <a href="{{ route('admin.superadmin.shelves.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition {{ request()->routeIs('admin.superadmin.shelves.*') ? 'bg-rose-50 text-rose-600 font-bold' : 'text-gray-500 font-semibold hover:bg-gray-50 hover:text-rose-600' }}">
            <span class="text-lg">📚</span> Data Rak Buku
        </a>

        <span class="block px-4 pt-6 pb-2 text-[11px] font-bold text-gray-400 tracking-wider uppercase">Sistem</span>

        {{-- TANGGAL MERAH --}}
        <a href="{{ route('admin.superadmin.holidays.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition {{ request()->routeIs('admin.superadmin.holidays.*') ? 'bg-rose-50 text-rose-600 font-bold' : 'text-gray-500 font-semibold hover:bg-gray-50 hover:text-rose-600' }}">
            <span class="text-lg">📅</span> Tanggal Merah
        </a>

        {{-- JADWAL PIKET --}}
        <a href="{{ route('admin.superadmin.schedules.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition {{ request()->routeIs('admin.superadmin.schedules.*') ? 'bg-rose-50 text-rose-600 font-bold' : 'text-gray-500 font-semibold hover:bg-gray-50 hover:text-rose-600' }}">
            <span class="text-lg">⏰</span> Jadwal Piket
        </a>

        {{-- HERO SLIDERS --}}
        <a href="{{ route('admin.superadmin.sliders.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition {{ request()->routeIs('admin.superadmin.sliders.*') ? 'bg-rose-50 text-rose-600 font-bold' : 'text-gray-500 font-semibold hover:bg-gray-50 hover:text-rose-600' }}">
            <span class="text-lg">🖼️</span> Hero Sliders
        </a>

        <a href="{{ route('admin.superadmin.backup.index') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-semibold {{ request()->routeIs('admin.superadmin.backup.*') ? 'bg-emerald-50 text-emerald-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} rounded-xl transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
            Backup Database
        </a>

        <span class="block px-4 pt-6 pb-2 text-[11px] font-bold text-gray-400 tracking-wider uppercase">Keuangan</span>

        <span class="block px-4 pt-6 pb-2 text-[11px] font-bold text-gray-400 tracking-wider uppercase">Keuangan</span>

        {{-- RIWAYAT DENDA --}}
        <a href="{{ route('admin.superadmin.fines.history') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition {{ request()->routeIs('admin.superadmin.fines.*') ? 'bg-rose-50 text-rose-600 font-bold' : 'text-gray-500 font-semibold hover:bg-gray-50 hover:text-rose-600' }}">
            <span class="text-lg">💰</span> Riwayat Denda
        </a>

        <div class="h-6"></div>
    </nav>

    {{-- FOOTER / TOMBOL LOGOUT --}}
    <div class="p-4 border-t border-gray-100 shrink-0 bg-white mt-auto">
        <form action="{{ route('logout') }}" method="POST" class="m-0">
            @csrf
            <button type="submit" class="w-full flex items-center justify-center gap-3 px-4 py-3.5 rounded-2xl text-rose-600 font-bold hover:bg-rose-50 transition shadow-sm border border-transparent hover:border-rose-100">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
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
