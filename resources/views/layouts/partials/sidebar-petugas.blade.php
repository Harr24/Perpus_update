<aside class="w-full bg-white border-r border-gray-100 flex flex-col sticky top-0" style="height: 100vh; height: 100dvh;">

    {{-- Header Sidebar (FIXED) --}}
    <div class="h-24 flex items-center px-8 shrink-0">
        <h1 class="text-xl font-extrabold tracking-tight text-emerald-900 uppercase">
            Petugas.
        </h1>
    </div>

    {{-- Menu Navigasi (SCROLLABLE) --}}
    <nav class="flex-1 px-4 py-2 space-y-1 overflow-y-auto custom-scrollbar min-h-0">
        <span class="block px-4 pb-2 text-[11px] font-bold text-gray-400 tracking-wider uppercase mt-2">Menu Utama</span>

        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl {{ request()->routeIs('dashboard') ? 'bg-emerald-50 text-emerald-600 font-bold' : 'text-gray-500 font-semibold hover:bg-gray-50 hover:text-emerald-700' }} transition">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5"><path fill-rule="evenodd" d="M3 6a3 3 0 0 1 3-3h2.25a3 3 0 0 1 3 3v2.25a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3V6Zm9.75 0a3 3 0 0 1 3-3H18a3 3 0 0 1 3 3v2.25a3 3 0 0 1-3 3h-2.25a3 3 0 0 1-3-3V6ZM3 15.75a3 3 0 0 1 3-3h2.25a3 3 0 0 1 3 3V18a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3v-2.25Zm9.75 0a3 3 0 0 1 3-3H18a3 3 0 0 1 3 3V18a3 3 0 0 1-3 3h-2.25a3 3 0 0 1-3-3v-2.25Z" clip-rule="evenodd" /></svg>
            Dashboard
        </a>

        <span class="block px-4 pt-6 pb-2 text-[11px] font-bold text-gray-400 tracking-wider uppercase">Sirkulasi & Anggota</span>

        <a href="{{ route('admin.petugas.verification.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl {{ request()->routeIs('admin.petugas.verification.*') ? 'bg-emerald-50 text-emerald-600 font-bold' : 'text-gray-500 font-semibold hover:bg-gray-50 hover:text-emerald-700' }} transition">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5"><path fill-rule="evenodd" d="M8.603 3.799A4.49 4.49 0 0 1 12 2.25c1.357 0 2.573.6 3.397 1.549a4.49 4.49 0 0 1 3.498 1.307 4.491 4.491 0 0 1 1.307 3.497A4.49 4.49 0 0 1 21.75 12a4.49 4.49 0 0 1-1.549 3.397 4.491 4.491 0 0 1-1.307 3.497 4.491 4.491 0 0 1-3.497 1.307A4.49 4.49 0 0 1 12 21.75a4.49 4.49 0 0 1-3.397-1.549 4.49 4.49 0 0 1-3.498-1.306 4.491 4.491 0 0 1-1.307-3.498A4.49 4.49 0 0 1 2.25 12c0-1.357.6-2.573 1.549-3.397a4.49 4.49 0 0 1 1.307-3.497 4.49 4.49 0 0 1 3.497-1.307Zm7.007 6.387a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd" /></svg>
            Verifikasi Akun Siswa
        </a>
        <a href="{{ route('admin.petugas.teachers.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl {{ request()->routeIs('admin.petugas.teachers.*') ? 'bg-emerald-50 text-emerald-600 font-bold' : 'text-gray-500 font-semibold hover:bg-gray-50 hover:text-emerald-700' }} transition">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5"><path d="M5.25 6.375a4.125 4.125 0 1 1 8.25 0 4.125 4.125 0 0 1-8.25 0ZM2.25 19.125a7.125 7.125 0 0 1 14.25 0v.003l-.001.119a.75.75 0 0 1-.363.63 13.067 13.067 0 0 1-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 0 1-.364-.63l-.001-.122ZM18.75 7.5a.75.75 0 0 0-1.5 0v2.25H15a.75.75 0 0 0 0 1.5h2.25v2.25a.75.75 0 0 0 1.5 0v-2.25H21a.75.75 0 0 0 0-1.5h-2.25V7.5Z" /></svg>
            Buat Akun Guru
        </a>
        <a href="{{ route('admin.petugas.approvals.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl {{ request()->routeIs('admin.petugas.approvals.*') ? 'bg-emerald-50 text-emerald-600 font-bold' : 'text-gray-500 font-semibold hover:bg-gray-50 hover:text-emerald-700' }} transition">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5"><path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12ZM12 8.25a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0V9a.75.75 0 0 1 .75-.75Zm0 8.25a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" clip-rule="evenodd" /></svg>
            Pengajuan Pinjam
        </a>

        {{-- 🔥 MENU BARU: Peminjaman Ekspres / Kasir 🔥 --}}
        <a href="{{ route('admin.petugas.direct_borrow.create') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl {{ request()->routeIs('admin.petugas.direct_borrow.*') ? 'bg-emerald-50 text-emerald-600 font-bold' : 'text-gray-500 font-semibold hover:bg-gray-50 hover:text-emerald-700' }} transition">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5"><path fill-rule="evenodd" d="M14.615 1.595a.75.75 0 0 1 .359.852L12.982 9.75h7.268a.75.75 0 0 1 .548 1.262l-10.5 11.25a.75.75 0 0 1-1.272-.71l1.992-7.302H3.75a.75.75 0 0 1-.548-1.262l10.5-11.25a.75.75 0 0 1 .913-.143Z" clip-rule="evenodd" /></svg>
            Peminjaman Ekspres
        </a>

        <a href="{{ route('admin.petugas.returns.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl {{ request()->routeIs('admin.petugas.returns.*') ? 'bg-emerald-50 text-emerald-600 font-bold' : 'text-gray-500 font-semibold hover:bg-gray-50 hover:text-emerald-700' }} transition">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5"><path d="M11.47 1.72a.75.75 0 0 1 1.06 0l3 3a.75.75 0 0 1-1.06 1.06l-1.72-1.72V15.69a.75.75 0 0 1-1.5 0V4.06L9.53 5.78a.75.75 0 0 1-1.06-1.06l3-3ZM3 15.69A.75.75 0 0 1 3.75 15h16.5a.75.75 0 0 1 .75.75v4.56c0 1.243-1.007 2.25-2.25 2.25H5.25A2.25 2.25 0 0 1 3 20.25v-4.56Z" /></svg>
            Pengembalian Buku
        </a>
        <a href="{{ route('admin.petugas.fines.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl {{ request()->routeIs('admin.petugas.fines.*') ? 'bg-emerald-50 text-emerald-600 font-bold' : 'text-gray-500 font-semibold hover:bg-gray-50 hover:text-emerald-700' }} transition">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5"><path d="M10.464 8.746c.227-.18.497-.311.786-.394v2.795a2.252 2.252 0 0 1-.786-.393c-.394-.313-.546-.681-.546-1.004 0-.323.152-.691.546-1.004ZM12.75 15.662v-2.824c.347.085.664.228.921.421.427.32.579.686.579.991 0 .305-.152.671-.579.991a2.534 2.534 0 0 1-.921.42Z" /><path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 6a.75.75 0 0 0-1.5 0v.816a3.836 3.836 0 0 0-1.72.756c-.712.566-1.112 1.35-1.112 2.178 0 .829.4 1.612 1.113 2.178.502.4 1.102.647 1.719.756v2.978a2.536 2.536 0 0 1-.921-.421l-.879-.66a.75.75 0 0 0-.9 1.2l.879.66c.533.4 1.169.645 1.821.75V18a.75.75 0 0 0 1.5 0v-.81a4.124 4.124 0 0 0 1.821-.749c.745-.559 1.179-1.344 1.179-2.191 0-.847-.434-1.632-1.179-2.191a4.122 4.122 0 0 0-1.821-.75V8.354c.29.082.559.213.786.393l.415.33a.75.75 0 0 0 .933-1.175l-.415-.33a3.836 3.836 0 0 0-1.719-.755V6Z" clip-rule="evenodd" /></svg>
            Kelola Denda
        </a>

        <span class="block px-4 pt-6 pb-2 text-[11px] font-bold text-gray-400 tracking-wider uppercase">Pustaka</span>

        <a href="{{ route('admin.petugas.books.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl {{ request()->routeIs('admin.petugas.books.*') ? 'bg-emerald-50 text-emerald-600 font-bold' : 'text-gray-500 font-semibold hover:bg-gray-50 hover:text-emerald-700' }} transition">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5"><path d="M11.25 4.533A9.707 9.707 0 0 0 6 3a9.735 9.735 0 0 0-3.25.555.75.75 0 0 0-.5.707v14.25a.75.75 0 0 0 1 .707A8.237 8.237 0 0 1 6 18.75c1.995 0 3.823.707 5.25 1.886V4.533ZM12.75 20.636A8.214 8.214 0 0 1 18 18.75c.966 0 1.89.166 2.75.47a.75.75 0 0 0 1-.708V4.262a.75.75 0 0 0-.5-.707A9.735 9.735 0 0 0 18 3a9.707 9.707 0 0 0-5.25 1.533v16.103Z" /></svg>
            Katalog Buku
        </a>
        <a href="{{ route('admin.petugas.genres.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl {{ request()->routeIs('admin.petugas.genres.*') ? 'bg-emerald-50 text-emerald-600 font-bold' : 'text-gray-500 font-semibold hover:bg-gray-50 hover:text-emerald-700' }} transition">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5"><path fill-rule="evenodd" d="M5.25 2.25a3 3 0 0 0-3 3v4.318a3 3 0 0 0 .879 2.121l9.58 9.581c.92.92 2.39 1.186 3.548.428a18.849 18.849 0 0 0 5.441-5.44c.758-1.16.492-2.629-.428-3.548l-9.58-9.581a3 3 0 0 0-2.122-.879H5.25ZM6.375 7.5a1.125 1.125 0 1 0 0-2.25 1.125 1.125 0 0 0 0 2.25Z" clip-rule="evenodd" /></svg>
            Buat Genre
        </a>

        <span class="block px-4 pt-6 pb-2 text-[11px] font-bold text-gray-400 tracking-wider uppercase">Laporan</span>

        <a href="{{ route('admin.petugas.reports.borrowings.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl {{ request()->routeIs('admin.petugas.reports.*') ? 'bg-emerald-50 text-emerald-600 font-bold' : 'text-gray-500 font-semibold hover:bg-gray-50 hover:text-emerald-700' }} transition">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5"><path d="M18.375 2.25c-1.035 0-1.875.84-1.875 1.875v15.75c0 1.035.84 1.875 1.875 1.875h.75c1.035 0 1.875-.84 1.875-1.875V4.125c0-1.036-.84-1.875-1.875-1.875h-.75ZM9.75 8.625c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-.75a1.875 1.875 0 0 1-1.875-1.875V8.625ZM3 13.125c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v6.75c0 1.035-.84 1.875-1.875 1.875h-.75A1.875 1.875 0 0 1 3 19.875v-6.75Z" /></svg>
            Laporan Pinjaman
        </a>

        <div class="h-4"></div>
    </nav>

    {{-- Footer Sidebar (FIXED) - TOMBOL LOGOUT --}}
    <div class="p-4 border-t border-gray-100 shrink-0 bg-white mt-auto">
        <form action="{{ route('logout') }}" method="POST" class="m-0">
            @csrf
            <button type="submit" class="w-full flex items-center justify-center gap-3 px-4 py-3.5 rounded-2xl text-rose-600 font-bold bg-rose-50 hover:bg-rose-600 hover:text-white transition shadow-sm group">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-rose-500 group-hover:text-white transition-colors"><path fill-rule="evenodd" d="M16.5 2.25h-9a2.25 2.25 0 0 0-2.25 2.25v15a2.25 2.25 0 0 0 2.25 2.25h9a2.25 2.25 0 0 0 2.25-2.25V4.5a2.25 2.25 0 0 0-2.25-2.25Zm-3.14 8.618a.75.75 0 0 0-1.22-.872l-3 4.5a.75.75 0 0 0 0 .87l3 4.5a.75.75 0 1 0 1.24-.832l-2.42-3.634h5.29a.75.75 0 0 0 0-1.5h-5.29l2.42-3.632Z" clip-rule="evenodd" /></svg>
                Log out
            </button>
        </form>
    </div>
</aside>

<style>
    .custom-scrollbar::-webkit-scrollbar {
        width: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #e2e8f0;
        border-radius: 4px;
    }
    .custom-scrollbar:hover::-webkit-scrollbar-thumb {
        background: #cbd5e1;
    }
</style>
