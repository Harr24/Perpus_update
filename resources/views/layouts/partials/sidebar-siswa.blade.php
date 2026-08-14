<aside class="w-full h-full bg-white flex flex-col border-r border-gray-100">
    <div class="h-24 flex items-center px-8">
        <h1 class="text-xl font-extrabold tracking-tight text-indigo-900 uppercase">
            Siswa.
        </h1>
    </div>

    <nav class="flex-1 px-4 py-2 space-y-1 overflow-y-auto">
        <span class="block px-4 pb-2 text-[11px] font-bold text-gray-400 tracking-wider uppercase mt-2">Menu Utama</span>

        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition {{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-600 font-bold' : 'text-gray-500 font-semibold hover:bg-gray-50 hover:text-indigo-700' }}">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>
            Dashboard
        </a>

        <span class="block px-4 pt-6 pb-2 text-[11px] font-bold text-gray-400 tracking-wider uppercase">Pustaka</span>

        <a href="{{ route('internal.catalog.all') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition {{ request()->routeIs('catalog.*') ? 'bg-indigo-50 text-indigo-600 font-bold' : 'text-gray-500 font-semibold hover:bg-gray-50 hover:text-indigo-700' }}">
            <span class="text-lg">📖</span> Katalog Buku
        </a>

        <a href="{{ route('borrow.history') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition {{ request()->routeIs('borrow.history') ? 'bg-indigo-50 text-indigo-600 font-bold' : 'text-gray-500 font-semibold hover:bg-gray-50 hover:text-indigo-700' }}">
            <span class="text-lg">🕒</span> Riwayat Peminjaman
        </a>

        {{-- MATERI PEMBELAJARAN --}}
        <a href="{{ route('internal.catalog.materials') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition {{ request()->routeIs('internal.catalog.materials') ? 'bg-indigo-50 text-indigo-600 font-bold' : 'text-gray-500 font-semibold hover:bg-gray-50 hover:text-indigo-600' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
            </svg>
            Materi Pembelajaran
        </a>

        <span class="block px-4 pt-6 pb-2 text-[11px] font-bold text-gray-400 tracking-wider uppercase">Akun Pribadi</span>

        <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition {{ request()->routeIs('profile.*') ? 'bg-indigo-50 text-indigo-600 font-bold' : 'text-gray-500 font-semibold hover:bg-gray-50 hover:text-indigo-700' }}">
            <span class="text-lg">👤</span> Profil Saya
        </a>
    </nav>

    <div class="p-4 border-t border-gray-100">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl text-gray-500 font-semibold hover:bg-red-50 hover:text-red-600 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                Log out
            </button>
        </form>
    </div>
</aside>
