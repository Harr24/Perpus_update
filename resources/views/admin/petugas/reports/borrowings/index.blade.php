@extends('layouts.admin')

@section('content')
    <div class="max-w-[100rem] mx-auto">

        {{-- Header Halaman --}}
        <div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Laporan Peminjaman</h2>
                <p class="text-gray-500 mt-1 font-medium">Rekapitulasi aktivitas peminjaman dan pengembalian buku di perpustakaan.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 bg-white text-gray-700 border border-gray-200 font-bold py-2.5 px-5 rounded-xl hover:bg-gray-50 transition shadow-sm text-sm">
                    <span>⬅️</span> Kembali
                </a>
            </div>
        </div>

        {{-- Filter Bar --}}
        <div class="bg-white p-6 rounded-[1.5rem] shadow-sm border border-gray-100 mb-8">
            <form action="{{ route('admin.petugas.reports.borrowings.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-4 items-end">

                {{-- Bulan --}}
                <div>
                    <label for="month" class="block text-xs font-extrabold text-gray-400 uppercase mb-2">Bulan</label>
                    <select name="month" id="month" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-50 outline-none transition text-sm font-bold text-gray-700 bg-gray-50 cursor-pointer">
                        <option value="">Semua Bulan</option>
                        @for ($m = 1; $m <= 12; $m++)
                            <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>
                                {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                            </option>
                        @endfor
                    </select>
                </div>

                {{-- Tahun --}}
                <div>
                    <label for="year" class="block text-xs font-extrabold text-gray-400 uppercase mb-2">Tahun</label>
                    <input type="number" name="year" id="year" value="{{ request('year', date('Y')) }}" placeholder="Tahun"
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-50 outline-none transition text-sm font-bold text-gray-700 bg-gray-50">
                </div>

                {{-- Status --}}
                <div>
                    <label for="status" class="block text-xs font-extrabold text-gray-400 uppercase mb-2">Status Akhir</label>
                    <select name="status" id="status" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-50 outline-none transition text-sm font-bold text-gray-700 bg-gray-50 cursor-pointer">
                        <option value="">Semua Status</option>
                        <option value="returned" {{ request('status') == 'returned' ? 'selected' : '' }}>Dikembalikan / Lunas</option>
                        <option value="missing" {{ request('status') == 'missing' ? 'selected' : '' }}>Dihilangkan</option>
                    </select>
                </div>

                {{-- Pencarian --}}
                <div class="lg:col-span-2">
                    <label for="search" class="block text-xs font-extrabold text-gray-400 uppercase mb-2">Pencarian Peminjam</label>
                    <div class="relative">
                        <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Cari nama peminjam..."
                               class="w-full pl-4 pr-10 py-2.5 rounded-xl border border-gray-200 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-50 outline-none transition text-sm bg-white">
                        @if(request('search') || request('status') || request('month'))
                            <a href="{{ route('admin.petugas.reports.borrowings.index', ['year' => request('year')]) }}" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-rose-500 font-bold p-1 transition" title="Reset Filter">✖</a>
                        @endif
                    </div>
                </div>

                {{-- Tombol Aksi --}}
                <div class="flex items-center gap-2">
                    <button type="submit" class="flex-1 bg-slate-900 text-white font-bold py-2.5 rounded-xl hover:bg-slate-800 transition shadow-sm text-sm">
                        Cari
                    </button>
                    <a href="{{ route('admin.petugas.reports.borrowings.export', request()->query()) }}" class="bg-emerald-100 text-emerald-700 font-bold py-2.5 px-4 rounded-xl hover:bg-emerald-200 transition shadow-sm text-sm" title="Export Excel">
                        📊 Export
                    </a>
                </div>

            </form>
        </div>

        {{-- Tabel Data --}}
        <div class="bg-white rounded-[1.5rem] shadow-sm border border-gray-100 overflow-hidden flex flex-col">

            <div class="p-6 border-b border-gray-100 bg-emerald-50/50 flex items-center gap-3">
                <span class="text-emerald-600 text-xl">📑</span>
                <h3 class="text-lg font-extrabold text-emerald-900">Data Rekapitulasi</h3>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse min-w-[1200px]">
                    <thead class="bg-gray-50/80 border-b border-gray-100">
                        <tr>
                            <th class="px-5 py-4 text-[10px] font-extrabold text-gray-500 uppercase tracking-wider text-center w-12">No</th>
                            <th class="px-5 py-4 text-[10px] font-extrabold text-gray-500 uppercase tracking-wider">Identitas Peminjam</th>
                            <th class="px-5 py-4 text-[10px] font-extrabold text-gray-500 uppercase tracking-wider">Info Buku & Kode</th>
                            <th class="px-5 py-4 text-[10px] font-extrabold text-gray-500 uppercase tracking-wider text-center">Status</th>
                            <th class="px-5 py-4 text-[10px] font-extrabold text-gray-500 uppercase tracking-wider text-center">Timeline</th>
                            <th class="px-5 py-4 text-[10px] font-extrabold text-gray-500 uppercase tracking-wider">Petugas Approval</th>
                            <th class="px-5 py-4 text-[10px] font-extrabold text-gray-500 uppercase tracking-wider">Petugas Pengembalian</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($borrowings as $borrowing)
                            <tr class="hover:bg-gray-50/80 transition duration-200">

                                {{-- Nomor --}}
                                <td class="px-5 py-4 text-sm font-bold text-gray-400 text-center">
                                    {{ $loop->iteration + $borrowings->firstItem() - 1 }}
                                </td>

                                {{-- Peminjam (Nama, Role, Kelas) --}}
                                <td class="px-5 py-4">
                                    <div class="flex flex-col">
                                        <a href="{{ route('admin.petugas.reports.users.history', $borrowing->user) }}" class="text-sm font-bold text-emerald-600 hover:text-emerald-700 hover:underline transition">
                                            {{ $borrowing->user->name }}
                                        </a>
                                        <div class="flex items-center gap-2 mt-1">
                                            <span class="px-2 py-0.5 rounded text-[9px] font-bold bg-slate-100 text-slate-600 uppercase">{{ $borrowing->user->role }}</span>
                                            <span class="text-xs text-gray-500 font-medium">{{ $borrowing->user->class_info ?? '-' }}</span>
                                        </div>
                                    </div>
                                </td>

                                {{-- Buku & Kode --}}
                                <td class="px-5 py-4">
                                    <div class="text-sm font-bold text-gray-900 truncate max-w-xs" title="{{ $borrowing->bookCopy->book->title }}">
                                        {{ Str::limit($borrowing->bookCopy->book->title, 40) }}
                                    </div>
                                    <span class="inline-block mt-1 px-2 py-0.5 rounded border border-gray-200 bg-gray-50 text-[10px] font-mono text-gray-600 tracking-wider">
                                        {{ $borrowing->bookCopy->book_code }}
                                    </span>
                                </td>

                                {{-- Status --}}
                                <td class="px-5 py-4 text-center">
                                    @if($borrowing->status == 'missing')
                                        <span class="inline-flex px-2.5 py-1 rounded-lg text-[10px] font-bold bg-rose-100 text-rose-700 border border-rose-200 uppercase tracking-widest">
                                            ⚠️ Hilang
                                        </span>
                                    @else
                                        <span class="inline-flex px-2.5 py-1 rounded-lg text-[10px] font-bold bg-emerald-100 text-emerald-700 border border-emerald-200 uppercase tracking-widest">
                                            ✅ Selesai
                                        </span>
                                    @endif
                                </td>

                                {{-- Timeline (Tgl Pinjam & Kembali) --}}
                                <td class="px-5 py-4">
                                    <div class="flex flex-col items-center gap-1 text-xs">
                                        <div class="flex justify-between w-32 border-b border-gray-100 pb-1">
                                            <span class="text-gray-400 font-bold">OUT:</span>
                                            <span class="font-medium text-gray-700">{{ \Carbon\Carbon::parse($borrowing->borrowed_at)->format('d M y') }}</span>
                                        </div>
                                        <div class="flex justify-between w-32 pt-0.5">
                                            <span class="text-gray-400 font-bold">IN:</span>
                                            <span class="font-medium {{ $borrowing->returned_at ? 'text-gray-700' : 'text-rose-500' }}">
                                                {{ $borrowing->returned_at ? \Carbon\Carbon::parse($borrowing->returned_at)->format('d M y') : 'Belum' }}
                                            </span>
                                        </div>
                                    </div>
                                </td>

                                {{-- Petugas Approval --}}
                                <td class="px-5 py-4">
                                    <span class="text-xs font-semibold text-gray-600">
                                        {{ $borrowing->approvedBy->name ?? 'N/A' }}
                                    </span>
                                </td>

                                {{-- Petugas Pengembalian --}}
                                <td class="px-5 py-4">
                                    <span class="text-xs font-semibold text-gray-600">
                                        {{ $borrowing->returnedBy->name ?? 'N/A' }}
                                    </span>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <span class="text-5xl mb-4 opacity-50">📂</span>
                                        <h3 class="text-lg font-bold text-gray-900">Data Tidak Ditemukan</h3>
                                        <p class="text-gray-500 mt-1">Tidak ada data riwayat peminjaman yang cocok dengan filter pencarian Anda.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination (Menggunakan withQueryString agar filter tidak hilang saat pindah halaman) --}}
            @if ($borrowings->hasPages())
                <div class="p-6 border-t border-gray-100 bg-white">
                    {{ $borrowings->withQueryString()->links('pagination::tailwind') }}
                </div>
            @endif
        </div>
    </div>
@endsection
