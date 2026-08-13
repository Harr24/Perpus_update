@extends('layouts.admin')

@section('content')
    <div class="max-w-7xl mx-auto">

        {{-- Header Halaman --}}
        <div class="mb-8">
            <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 tracking-tight">Katalog Buku</h2>
            <p class="text-gray-500 mt-2 font-medium">Jelajahi, cari, dan temukan koleksi buku favorit Anda.</p>
        </div>

        {{-- Form Pencarian Terpusat --}}
        <div class="max-w-2xl mx-auto mb-10">
            <form action="{{ url()->current() }}" method="GET" class="relative group">
                @if(request('genre'))
                    <input type="hidden" name="genre" value="{{ request('genre') }}">
                @endif
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400 group-focus-within:text-rose-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari berdasarkan judul atau penulis..."
                       class="w-full pl-12 pr-24 py-4 rounded-2xl border-2 border-gray-100 bg-white text-gray-900 font-medium focus:outline-none focus:border-rose-300 focus:ring-4 focus:ring-rose-50 shadow-sm transition-all text-sm placeholder-gray-400">
                <button type="submit" class="absolute inset-y-1.5 right-1.5 px-6 bg-gray-900 hover:bg-gray-800 text-white text-sm font-bold rounded-xl transition-colors shadow-sm">
                    Cari
                </button>
            </form>
        </div>

        {{-- Filter Kategori (Horizontal Scroll) --}}
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-extrabold text-gray-900 uppercase tracking-widest">Saring Kategori</h3>
            </div>

            <div class="flex overflow-x-auto pb-4 gap-4 custom-scrollbar snap-x">

                {{-- Tombol Semua --}}
                <a href="{{ url()->current() }}?search={{ request('search') }}"
                   class="snap-start shrink-0 flex flex-col items-center justify-center w-28 p-3 rounded-2xl border-2 transition-all duration-200 {{ !request('genre') ? 'border-rose-500 bg-rose-50 shadow-md transform -translate-y-1' : 'border-gray-100 bg-white hover:border-rose-200 hover:bg-rose-50/50 hover:-translate-y-1' }}">
                    <div class="w-12 h-12 rounded-full flex items-center justify-center mb-2 overflow-hidden {{ !request('genre') ? 'bg-rose-200/50 text-rose-700' : 'bg-gray-100 text-gray-500' }}">
                        <span class="font-bold text-xs">ALL</span>
                    </div>
                    <span class="text-xs font-bold text-center {{ !request('genre') ? 'text-rose-700' : 'text-gray-700' }}">Semua</span>
                </a>

                {{-- Looping Genre --}}
                @foreach ($genres as $genre)
                    <a href="{{ url()->current() }}?genre={{ urlencode($genre->name) }}&search={{ request('search') }}"
                       class="snap-start shrink-0 flex flex-col items-center justify-center w-28 p-3 rounded-2xl border-2 transition-all duration-200 {{ request('genre') == $genre->name ? 'border-rose-500 bg-rose-50 shadow-md transform -translate-y-1' : 'border-gray-100 bg-white hover:border-rose-200 hover:bg-rose-50/50 hover:-translate-y-1' }}">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center mb-2 overflow-hidden relative shadow-inner {{ request('genre') == $genre->name ? 'bg-rose-200/50 text-rose-700' : 'bg-pink-100/50 text-pink-700' }}">
                            @if($genre->icon)
                                <img src="{{ asset('storage/' . $genre->icon) }}" alt="{{ $genre->name }}" class="w-full h-full object-cover">
                            @else
                                <span class="font-extrabold text-sm">{{ $genre->genre_code ?? substr($genre->name, 0, 2) }}</span>
                            @endif
                        </div>
                        <span class="text-[11px] font-bold text-center truncate w-full px-1 {{ request('genre') == $genre->name ? 'text-rose-700' : 'text-gray-700' }}">
                            {{ $genre->name }}
                        </span>
                    </a>
                @endforeach
            </div>
        </div>

        {{-- Notifikasi Filter Aktif --}}
        @if(request('search') || request('genre'))
            <div class="mb-8 p-4 bg-sky-50 border border-sky-100 rounded-xl flex flex-wrap items-center justify-between gap-4 shadow-sm">
                <div class="flex items-center gap-3 text-sm font-medium text-sky-800">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                    <span>Menampilkan hasil untuk:
                        @if(request('search')) <strong class="bg-sky-100 px-2 py-0.5 rounded text-sky-900">"{{ request('search') }}"</strong> @endif
                        @if(request('genre')) kategori <strong class="bg-sky-100 px-2 py-0.5 rounded text-sky-900">{{ request('genre') }}</strong> @endif
                    </span>
                </div>
                <a href="{{ url()->current() }}" class="text-xs font-bold bg-white text-rose-600 hover:text-white hover:bg-rose-500 border border-rose-200 hover:border-transparent px-3 py-1.5 rounded-lg transition-colors">
                    Hapus Filter ✕
                </a>
            </div>
        @endif

        {{-- Grid Daftar Buku --}}
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-5 md:gap-6">
            @forelse ($books as $book)
                {{-- KARTU BUKU TAILWIND --}}
                <a href="{{ route('catalog.show', $book->id) }}" class="group flex flex-col bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:border-rose-200 hover:-translate-y-1.5 transition-all duration-300 overflow-hidden h-full">

                    {{-- Area Gambar Sampul (Rasio Aspek Konsisten) --}}
                    <div class="relative w-full pt-[140%] overflow-hidden bg-gray-50 border-b border-gray-100">
                        <img src="{{ $book->cover_image ? asset('storage/' . $book->cover_image) : 'https://placehold.co/300x450/E91E63/FFFFFF?text=No+Cover' }}"
                             alt="{{ $book->title }}"
                             class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 ease-in-out">

                        {{-- Overlay Tipe Buku (Misal: Buku Paket) --}}
                        @if($book->book_type == 'paket')
                            <div class="absolute top-2 right-2 bg-indigo-500 text-white text-[9px] font-bold px-2 py-1 rounded-md shadow-sm uppercase tracking-widest">
                                Paket
                            </div>
                        @endif
                    </div>

                    {{-- Area Konten Kartu --}}
                    <div class="p-4 flex flex-col flex-grow">
                        <span class="text-[10px] font-extrabold text-rose-600 uppercase tracking-wider mb-1 line-clamp-1">
                            {{ $book->genre->name }}
                        </span>

                        <h3 class="text-sm font-bold text-gray-900 leading-snug mb-1 line-clamp-2 group-hover:text-rose-600 transition-colors">
                            {{ $book->title }}
                        </h3>

                        <p class="text-xs font-medium text-gray-500 mb-3 line-clamp-1">
                            {{ $book->author }}
                        </p>

                        {{-- Area Bawah: Status Ketersediaan --}}
                        <div class="mt-auto pt-3 border-t border-gray-100 flex items-center justify-between">
                            @if($book->available_copies_count > 0)
                                <span class="inline-flex items-center gap-1 text-[10px] font-bold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-md">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                    Tersedia ({{ $book->available_copies_count }})
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 text-[10px] font-bold text-gray-500 bg-gray-100 px-2 py-1 rounded-md">
                                    <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                                    Kosong
                                </span>
                            @endif
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-full">
                    <div class="flex flex-col items-center justify-center p-12 bg-white rounded-[1.5rem] border border-gray-100 border-dashed text-center">
                        <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-1">Buku Tidak Ditemukan</h3>
                        <p class="text-sm text-gray-500 max-w-sm">Maaf, tidak ada buku yang sesuai dengan kata kunci atau filter kategori Anda. Silakan coba pencarian lain.</p>
                    </div>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if($books->hasPages())
            <div class="mt-10 p-4 bg-white rounded-2xl shadow-sm border border-gray-100">
                {{ $books->appends(request()->query())->links('pagination::tailwind') }}
            </div>
        @endif

    </div>

    {{-- Script untuk Custom Scrollbar --}}
    <style>
        .custom-scrollbar::-webkit-scrollbar { height: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; border-radius: 8px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background-color: #e5e7eb; border-radius: 8px; }
        .custom-scrollbar:hover::-webkit-scrollbar-thumb { background-color: #d1d5db; }
    </style>
@endsection
