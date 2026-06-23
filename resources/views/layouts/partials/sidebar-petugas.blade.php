<aside class="w-full bg-white border-r border-gray-100 flex flex-col sticky top-0" style="height: 100vh; height: 100dvh;">

    {{-- Header Sidebar (FIXED) --}}
    <div class="h-24 flex items-center px-8 shrink-0">
        <h1 class="text-xl font-extrabold tracking-tight text-emerald-900 uppercase">
            Petugas.
        </h1>
    </div>

    {{-- Menu Navigasi (SCROLLABLE) --}}
    {{-- Tambahan min-h-0 sangat krusial di sini agar flexbox mengizinkan scroll --}}
    <nav class="flex-1 px-4 py-2 space-y-1 overflow-y-auto custom-scrollbar min-h-0">
        <span class="block px-4 pb-2 text-[11px] font-bold text-gray-400 tracking-wider uppercase mt-2">Menu Utama</span>

        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl {{ request()->routeIs('dashboard') ? 'bg-emerald-50 text-emerald-600 font-bold' : 'text-gray-500 font-semibold hover:bg-gray-50 hover:text-emerald-700' }} transition">
            <span class="text-lg">📊</span> Dashboard
        </a>

        <span class="block px-4 pt-6 pb-2 text-[11px] font-bold text-gray-400 tracking-wider uppercase">Sirkulasi & Anggota</span>

        <a href="{{ route('admin.petugas.verification.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl {{ request()->routeIs('admin.petugas.verification.*') ? 'bg-emerald-50 text-emerald-600 font-bold' : 'text-gray-500 font-semibold hover:bg-gray-50 hover:text-emerald-700' }} transition">
            <span class="text-lg">✅</span> Verifikasi Akun Siswa
        </a>
        <a href="{{ route('admin.petugas.teachers.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl {{ request()->routeIs('admin.petugas.teachers.*') ? 'bg-emerald-50 text-emerald-600 font-bold' : 'text-gray-500 font-semibold hover:bg-gray-50 hover:text-emerald-700' }} transition">
            <span class="text-lg">👩‍🏫</span> Buat Akun Guru
        </a>
        <a href="{{ route('admin.petugas.approvals.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl {{ request()->routeIs('admin.petugas.approvals.*') ? 'bg-emerald-50 text-emerald-600 font-bold' : 'text-gray-500 font-semibold hover:bg-gray-50 hover:text-emerald-700' }} transition">
            <span class="text-lg">📝</span> Pengajuan Pinjam
        </a>
        <a href="{{ route('admin.petugas.returns.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl {{ request()->routeIs('admin.petugas.returns.*') ? 'bg-emerald-50 text-emerald-600 font-bold' : 'text-gray-500 font-semibold hover:bg-gray-50 hover:text-emerald-700' }} transition">
            <span class="text-lg">📥</span> Pengembalian Buku
        </a>
        <a href="{{ route('admin.petugas.fines.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl {{ request()->routeIs('admin.petugas.fines.*') ? 'bg-emerald-50 text-emerald-600 font-bold' : 'text-gray-500 font-semibold hover:bg-gray-50 hover:text-emerald-700' }} transition">
            <span class="text-lg">💰</span> Kelola Denda
        </a>

        <span class="block px-4 pt-6 pb-2 text-[11px] font-bold text-gray-400 tracking-wider uppercase">Pustaka</span>

        <a href="{{ route('admin.petugas.books.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl {{ request()->routeIs('admin.petugas.books.*') ? 'bg-emerald-50 text-emerald-600 font-bold' : 'text-gray-500 font-semibold hover:bg-gray-50 hover:text-emerald-700' }} transition">
            <span class="text-lg">📖</span> Katalog Buku
        </a>
        <a href="{{ route('admin.petugas.genres.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl {{ request()->routeIs('admin.petugas.genres.*') ? 'bg-emerald-50 text-emerald-600 font-bold' : 'text-gray-500 font-semibold hover:bg-gray-50 hover:text-emerald-700' }} transition">
            <span class="text-lg">🏷️</span> Buat Genre
        </a>

        <span class="block px-4 pt-6 pb-2 text-[11px] font-bold text-gray-400 tracking-wider uppercase">Laporan</span>

        <a href="{{ route('admin.petugas.reports.borrowings.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl {{ request()->routeIs('admin.petugas.reports.*') ? 'bg-emerald-50 text-emerald-600 font-bold' : 'text-gray-500 font-semibold hover:bg-gray-50 hover:text-emerald-700' }} transition">
            <span class="text-lg">📈</span> Laporan Pinjaman
        </a>

        <div class="h-4"></div>
    </nav>

    {{-- Footer Sidebar (FIXED) - TOMBOL LOGOUT --}}
    <div class="p-4 border-t border-gray-100 shrink-0 bg-white mt-auto">
        <form action="{{ route('logout') }}" method="POST" class="m-0">
            @csrf
            <button type="submit" class="w-full flex items-center justify-center gap-3 px-4 py-3.5 rounded-2xl text-rose-600 font-bold bg-rose-50 hover:bg-rose-600 hover:text-white transition shadow-sm">
                <span class="text-lg">🚪</span> Log out
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
