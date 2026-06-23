@extends('layouts.admin')

@section('content')
    <div class="max-w-7xl mx-auto">

        {{-- Header Halaman --}}
        <div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Katalog Koleksi Buku</h2>
                <p class="text-gray-500 mt-1 font-medium">Kelola daftar seluruh koleksi buku yang tersedia di perpustakaan.</p>
            </div>
            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 bg-white text-gray-700 border border-gray-200 font-bold py-2.5 px-4 rounded-xl hover:bg-gray-50 transition shadow-sm text-sm">
                    <span>⬅️</span> Kembali
                </a>
                <a href="{{ route('admin.petugas.books.create') }}" class="inline-flex items-center gap-2 bg-emerald-600 text-white font-bold py-2.5 px-5 rounded-xl hover:bg-emerald-700 transition shadow-sm hover:shadow-md text-sm">
                    <span>➕</span> Tambah 1 Buku
                </a>
                <a href="{{ route('admin.petugas.books.create.bulk') }}" class="inline-flex items-center gap-2 bg-sky-500 text-white font-bold py-2.5 px-5 rounded-xl hover:bg-sky-600 transition shadow-sm hover:shadow-md text-sm">
                    <span>📚</span> Tambah Banyak
                </a>
            </div>
        </div>

        {{-- Alert Notifikasi --}}
        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 text-emerald-700 border border-emerald-100 rounded-xl font-bold flex items-center gap-3 shadow-sm">
                <span class="text-xl">✅</span> {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-6 p-4 bg-rose-50 text-rose-700 border border-rose-100 rounded-xl font-bold flex items-center gap-3 shadow-sm">
                <span class="text-xl">⚠️</span> {{ session('error') }}
            </div>
        @endif

        {{-- Form Pencarian & Filter --}}
        <div class="bg-white p-6 rounded-[1.5rem] shadow-sm border border-gray-100 mb-8">
            <form action="{{ route('admin.petugas.books.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">

                {{-- Filter Genre --}}
                <div class="w-full md:w-1/3 shrink-0">
                    <label class="block text-xs font-extrabold text-gray-400 uppercase mb-2">Filter Kategori</label>
                    <div class="relative">
                        <select name="genre_id" class="w-full pl-4 pr-10 py-3 rounded-xl border border-gray-200 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-50 outline-none transition text-sm font-bold text-gray-700 appearance-none bg-gray-50 cursor-pointer">
                            <option value="">-- Semua Genre --</option>
                            @foreach ($genres as $genre)
                                <option value="{{ $genre->id }}" {{ request('genre_id') == $genre->id ? 'selected' : '' }}>
                                    {{ $genre->name }}
                                </option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                        </div>
                    </div>
                </div>

                {{-- Search Box --}}
                <div class="flex-grow flex items-end">
                    <div class="w-full">
                        <label class="block text-xs font-extrabold text-gray-400 uppercase mb-2">Cari Buku</label>
                        <div class="flex">
                            <div class="relative flex-grow">
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Ketik judul buku, nama penulis, atau kode..."
                                       class="w-full px-4 py-3 rounded-l-xl border border-gray-200 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-50 outline-none transition text-sm bg-gray-50 focus:bg-white">
                                @if(request('search') || request('genre_id'))
                                    <a href="{{ route('admin.petugas.books.index') }}" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-rose-500 font-bold p-1 transition" title="Hapus Filter">✖</a>
                                @endif
                            </div>
                            <button type="submit" class="bg-slate-900 text-white font-bold py-3 px-6 rounded-r-xl hover:bg-slate-800 transition shadow-sm text-sm border border-transparent border-l-0 whitespace-nowrap">
                                Cari
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        {{-- Tabel Data --}}
        <div class="bg-white rounded-[1.5rem] shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-50/50 border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-5 text-xs font-extrabold text-gray-500 uppercase tracking-wider text-center w-16">No</th>
                            <th class="px-6 py-5 text-xs font-extrabold text-gray-500 uppercase tracking-wider">Info Buku</th>
                            <th class="px-6 py-5 text-xs font-extrabold text-gray-500 uppercase tracking-wider text-center">Genre & Rak</th>
                            <th class="px-6 py-5 text-xs font-extrabold text-gray-500 uppercase tracking-wider text-center">Detail Koleksi</th>
                            <th class="px-6 py-5 text-xs font-extrabold text-gray-500 uppercase tracking-wider text-right w-40">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($books as $book)
                            <tr class="hover:bg-gray-50/80 transition duration-200">

                                {{-- Nomor Urut --}}
                                <td class="px-6 py-4 text-sm font-bold text-gray-400 text-center">
                                    {{ $loop->iteration + ($books->currentPage() - 1) * $books->perPage() }}
                                </td>

                                {{-- Cover & Info Buku --}}
                                <td class="px-6 py-4">
                                    <div class="flex items-start gap-4">
                                        {{-- Sampul --}}
                                        <div class="w-16 h-24 rounded-lg overflow-hidden bg-gray-100 border border-gray-200 shadow-sm shrink-0 flex items-center justify-center">
                                            @if($book->cover_image && Storage::disk('public')->exists($book->cover_image))
                                                <img src="{{ Storage::url($book->cover_image) }}" alt="Cover" class="w-full h-full object-cover">
                                            @else
                                                <span class="text-[10px] font-bold text-gray-400 uppercase text-center p-2">No<br>Cover</span>
                                            @endif
                                        </div>
                                        {{-- Detail Teks --}}
                                        <div class="min-w-0 flex flex-col justify-center py-1">
                                            <h4 class="text-sm font-extrabold text-gray-900 leading-snug line-clamp-2" title="{{ $book->title }}">{{ $book->title }}</h4>
                                            <p class="text-xs font-medium text-gray-500 mt-1">✒️ {{ $book->author ?? 'Penulis Anonim' }}</p>
                                            <p class="text-xs text-gray-400 mt-0.5">📅 Terbit: {{ $book->publication_year ?? '-' }}</p>
                                        </div>
                                    </div>
                                </td>

                                {{-- Genre & Lokasi Rak --}}
                                <td class="px-6 py-4 text-center space-y-2">
                                    <div class="inline-flex items-center px-2.5 py-1 rounded-md text-[10px] font-bold bg-indigo-50 text-indigo-700 uppercase tracking-widest border border-indigo-100" title="Kategori Genre">
                                        {{ $book->genre->name ?? 'TANPA GENRE' }}
                                    </div>
                                    <div class="inline-flex items-center px-2.5 py-1 rounded-md text-[10px] font-bold bg-slate-100 text-slate-700 uppercase tracking-widest border border-slate-200" title="Lokasi Rak Fisik">
                                        📍 RAK {{ $book->shelf->name ?? 'N/A' }}
                                    </div>
                                </td>

                                {{-- Detail Koleksi (Stok & Tipe) --}}
                                <td class="px-6 py-4 text-center">
                                    <div class="flex flex-col items-center gap-2">

                                        {{-- Badge Tipe Buku --}}
                                        @switch($book->book_type)
                                            @case('reguler')
                                                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-sky-100 text-sky-700 border border-sky-200">REGULER</span>
                                                @break
                                            @case('paket')
                                                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-amber-100 text-amber-700 border border-amber-200">PAKET</span>
                                                @break
                                            @case('laporan')
                                                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-purple-100 text-purple-700 border border-purple-200">LAPORAN</span>
                                                @break
                                            @default
                                                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-gray-100 text-gray-700 border border-gray-200">{{ strtoupper($book->book_type) }}</span>
                                        @endswitch

                                        {{-- Indikator Stok --}}
                                        <div class="flex items-center gap-3 bg-gray-50 border border-gray-100 rounded-lg px-3 py-1.5 shadow-sm mt-1">
                                            <div class="text-center" title="Total Fisik Buku">
                                                <span class="block text-[10px] font-extrabold text-gray-400 uppercase">Total</span>
                                                <span class="block text-sm font-black text-slate-800">{{ $book->copies_count }}</span>
                                            </div>
                                            <div class="w-px h-6 bg-gray-200"></div>
                                            <div class="text-center" title="Sedang Dipinjam">
                                                <span class="block text-[10px] font-extrabold text-gray-400 uppercase">Keluar</span>
                                                <span class="block text-sm font-black {{ $book->borrowed_copies_count > 0 ? 'text-rose-600' : 'text-gray-400' }}">
                                                    {{ $book->borrowed_copies_count }}
                                                </span>
                                            </div>
                                        </div>

                                    </div>
                                </td>

                                {{-- Aksi --}}
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-1">
                                        <a href="{{ route('admin.petugas.books.show', $book) }}" class="inline-flex items-center justify-center w-8 h-8 bg-sky-50 text-sky-600 hover:bg-sky-100 rounded-lg transition border border-sky-100" title="Lihat Detail">
                                            👁️
                                        </a>
                                        <a href="{{ route('admin.petugas.books.edit', $book) }}" class="inline-flex items-center justify-center w-8 h-8 bg-amber-50 text-amber-600 hover:bg-amber-100 rounded-lg transition border border-amber-100" title="Edit Buku">
                                            ✏️
                                        </a>

                                        @if($book->borrowed_copies_count == 0)
                                            <form action="{{ route('admin.petugas.books.destroy', $book) }}" method="POST" class="form-delete-book m-0" data-title="{{ $book->title }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center justify-center w-8 h-8 bg-rose-50 text-rose-600 hover:bg-rose-100 hover:text-rose-700 rounded-lg transition border border-rose-100" title="Hapus Buku">
                                                    🗑️
                                                </button>
                                            </form>
                                        @else
                                            <button type="button" disabled class="inline-flex items-center justify-center w-8 h-8 bg-gray-100 text-gray-400 rounded-lg border border-gray-200 cursor-not-allowed opacity-50" title="Tidak dapat dihapus: Ada salinan yang sedang dipinjam">
                                                🗑️
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <span class="text-5xl mb-4 opacity-50">📚</span>
                                        @if(request('search') || request('genre_id'))
                                            <h3 class="text-lg font-bold text-gray-900">Buku Tidak Ditemukan</h3>
                                            <p class="text-gray-500 mt-1 mb-4">Tidak ada buku yang sesuai dengan filter pencarian Anda.</p>
                                            <a href="{{ route('admin.petugas.books.index') }}" class="text-emerald-600 font-bold hover:underline">Hapus Filter Pencarian</a>
                                        @else
                                            <h3 class="text-lg font-bold text-gray-900">Katalog Kosong</h3>
                                            <p class="text-gray-500 mt-1 mb-4">Belum ada data buku yang terdaftar di perpustakaan.</p>
                                            <a href="{{ route('admin.petugas.books.create') }}" class="inline-flex items-center gap-2 bg-emerald-600 text-white font-bold py-2.5 px-5 rounded-xl hover:bg-emerald-700 transition shadow-sm">
                                                Tambah Buku Sekarang
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

           #paginasi
            @if ($books->hasPages())
                <div class="p-6 border-t border-gray-100 bg-white">
                    {{ $books->withQueryString()->links('pagination::tailwind') }}
                </div>
            @endif

        </div>
    </div>
@endsection

@push('scripts')
    {{-- SweetAlert2 untuk Konfirmasi Hapus --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteForms = document.querySelectorAll('.form-delete-book');

            deleteForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const bookTitle = this.dataset.title;

                    Swal.fire({
                        title: 'Hapus Buku Ini?',
                        html: `Anda akan menghapus buku <strong>"${bookTitle}"</strong> dan seluruh riwayat salinannya secara permanen.`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#e11d48', // Rose-600
                        cancelButtonColor: '#6b7280', // Gray-500
                        confirmButtonText: 'Ya, Hapus Permanen',
                        cancelButtonText: 'Batal',
                        borderRadius: '1.5rem'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
@endpush
