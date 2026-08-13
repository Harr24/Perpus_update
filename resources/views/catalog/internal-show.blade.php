@extends('layouts.admin')

@section('content')
    <div class="max-w-6xl mx-auto">
        {{-- Alert Success --}}
        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 text-emerald-700 border border-emerald-100 rounded-xl font-bold flex items-center gap-3">
                <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                {{ session('success') }}
            </div>
        @endif

        {{-- Alert Error --}}
        @if(session('error'))
            <div class="mb-6 p-4 bg-rose-50 text-rose-700 border border-rose-100 rounded-xl font-bold flex items-center gap-3">
                <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                {{ session('error') }}
            </div>
        @endif

        {{-- Card Utama Detail Buku --}}
        <div class="bg-white rounded-[1.5rem] shadow-sm border border-gray-100 overflow-hidden mb-8">
            <div class="p-8 md:p-10">
                <div class="grid grid-cols-1 md:grid-cols-12 gap-10">

                    {{-- Kolom Kiri: Cover Buku --}}
                    <div class="md:col-span-4 flex justify-center md:justify-start items-start">
                        <div class="w-full max-w-[280px] rounded-2xl overflow-hidden shadow-xl border-4 border-gray-50 relative group">
                            <img src="{{ $book->cover_image ? asset('storage/' . $book->cover_image) : 'https://placehold.co/300x450/E91E63/FFFFFF?text=No+Cover' }}"
                                 alt="Sampul {{ $book->title }}"
                                 class="w-full h-auto object-cover group-hover:scale-105 transition duration-500">
                        </div>
                    </div>

                    {{-- Kolom Kanan: Informasi Buku --}}
                    <div class="md:col-span-8 flex flex-col">
                        <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 tracking-tight leading-tight">{{ $book->title }}</h1>
                        <p class="text-lg text-gray-500 font-medium mt-2 mb-6">Oleh <span class="font-bold text-gray-700">{{ $book->author }}</span></p>

                        <div class="flex flex-wrap items-center gap-3 mb-8">
                            {{-- Badge Genre --}}
                            <span class="inline-flex items-center px-3.5 py-1.5 rounded-full text-xs font-bold bg-rose-50 text-rose-700 border border-rose-100 tracking-wide uppercase">
                                {{ $book->genre->name }}
                            </span>

                            {{-- Badge Tipe Buku --}}
                            @switch($book->book_type)
                                @case('paket')
                                    <span class="inline-flex items-center px-3.5 py-1.5 rounded-full text-xs font-bold bg-sky-50 text-sky-700 border border-sky-100 tracking-wide uppercase">
                                        Buku Paket
                                    </span>
                                    @break
                                @case('laporan')
                                    <span class="inline-flex items-center px-3.5 py-1.5 rounded-full text-xs font-bold bg-slate-100 text-slate-700 border border-slate-200 tracking-wide uppercase">
                                        Buku Laporan
                                    </span>
                                    @break
                                @case('reguler')
                                    <span class="inline-flex items-center px-3.5 py-1.5 rounded-full text-xs font-bold bg-indigo-50 text-indigo-700 border border-indigo-100 tracking-wide uppercase">
                                        Buku Reguler
                                    </span>
                                    @break
                            @endswitch

                            {{-- Badge Lokasi Rak --}}
                            <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-100 tracking-wide">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                Rak: {{ optional($book->shelf)->name ?? 'Belum Diatur' }}
                            </span>
                        </div>

                        {{-- Sinopsis --}}
                        @if ($book->synopsis)
                            <div class="bg-gray-50/50 border border-gray-100 rounded-2xl p-6 flex-grow">
                                <h3 class="text-sm font-extrabold text-gray-900 uppercase tracking-widest mb-3 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path></svg>
                                    Sinopsis
                                </h3>
                                <p class="text-gray-600 leading-relaxed text-sm whitespace-pre-wrap">{{ $book->synopsis }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        @auth
            @php
                // Cek HANYA apakah buku ini adalah 'paket'
                $isBookPackage = ($book->book_type == 'paket');
            @endphp

            {{-- Form Pinjam Buku Paket Khusus Guru --}}
            @if(Auth::user()->role == 'guru' && $isBookPackage)
                <div class="bg-gradient-to-br from-rose-50 to-white rounded-[1.5rem] p-8 border-2 border-rose-200 shadow-sm mb-8 relative overflow-hidden">
                    {{-- Dekorasi Latar --}}
                    <div class="absolute -right-10 -top-10 text-rose-100 opacity-50">
                        <svg class="w-48 h-48" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path></svg>
                    </div>

                    <div class="relative z-10">
                        <h3 class="text-xl font-extrabold text-rose-800 mb-2 flex items-center gap-2">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            Pinjam Buku Paket Massal
                        </h3>
                        <p class="text-sm font-medium text-rose-600/80 mb-6">Akses khusus Guru: Anda dapat meminjam beberapa eksemplar buku ini sekaligus untuk didistribusikan di kelas.</p>

                        {{-- PERUBAHAN DI SINI: Tambah onsubmit bawaan --}}
                        <form action="{{ route('borrow.store.bulk') }}" method="POST" onsubmit="return confirm('Anda yakin ingin meminjam ' + document.getElementById('quantity').value + ' eksemplar buku paket ini secara massal?');" class="flex flex-col md:flex-row gap-4 items-end">
                            @csrf
                            <input type="hidden" name="book_id" value="{{ $book->id }}">

                            <div class="w-full md:w-1/2">
                                <label for="quantity" class="block text-sm font-bold text-rose-900 mb-2">Jumlah Eksemplar:</label>
                                <input type="number" name="quantity" id="quantity"
                                       min="1" max="{{ $book->available_copies_count }}"
                                       placeholder="Maksimal: {{ $book->available_copies_count }} eksemplar"
                                       required
                                       class="w-full border-2 border-rose-200 bg-white rounded-xl py-3 px-4 text-sm font-bold text-rose-900 focus:ring-4 focus:ring-rose-100 focus:border-rose-400 outline-none transition shadow-sm placeholder-rose-300">
                            </div>

                            <div class="w-full md:w-1/2">
                                <button type="submit" class="w-full flex justify-center items-center gap-2 bg-rose-600 text-white font-extrabold py-3 px-6 rounded-xl hover:bg-rose-700 transition shadow-md hover:shadow-lg border border-transparent">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                    Ajukan Peminjaman
                                </button>
                            </div>
                        </form>
                        <p class="text-xs font-bold text-rose-500 mt-3">Tersedia {{ $book->available_copies_count }} eksemplar yang siap dipinjam hari ini.</p>
                    </div>
                </div>
            @endif

            {{-- Tabel Pinjam Satuan --}}
            <div class="bg-white rounded-[1.5rem] shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex items-center justify-between bg-gray-50/50">
                    <h3 class="text-lg font-extrabold text-gray-900">Daftar Eksemplar Fisik</h3>
                    <span class="text-xs font-bold text-gray-500 uppercase tracking-widest">Pinjam Satuan</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-white border-b border-gray-100">
                            <tr>
                                <th class="px-6 py-4 text-xs font-extrabold text-gray-500 uppercase tracking-wider">Kode Eksemplar</th>
                                <th class="px-6 py-4 text-xs font-extrabold text-gray-500 uppercase tracking-wider">Status Ketersediaan</th>
                                <th class="px-6 py-4 text-xs font-extrabold text-gray-500 uppercase tracking-wider text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 text-gray-700">
                            @forelse ($book->copies as $copy)
                                <tr class="hover:bg-gray-50/80 transition duration-200">
                                    <td class="px-6 py-4 font-mono text-sm font-bold text-gray-800">
                                        {{ $copy->book_code }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($copy->status == 'tersedia')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg text-[11px] font-bold uppercase tracking-widest bg-emerald-50 text-emerald-700 border border-emerald-100">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Tersedia
                                            </span>
                                        @elseif($copy->status == 'pending')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg text-[11px] font-bold uppercase tracking-widest bg-amber-50 text-amber-700 border border-amber-100">
                                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Diajukan
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg text-[11px] font-bold uppercase tracking-widest bg-slate-100 text-slate-600 border border-slate-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span> Dipinjam
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        @if($copy->status == 'tersedia')
                                            <form action="{{ route('borrow.store', $copy) }}" method="POST" onsubmit="return confirm('Anda yakin ingin meminjam eksemplar ini?');" class="m-0 inline-block">
                                                @csrf
                                                <button type="submit" class="inline-flex items-center gap-2 bg-slate-900 text-white font-bold py-2 px-4 rounded-xl hover:bg-slate-800 transition shadow-sm text-xs border border-transparent">
                                                    Pinjam Eksemplar Ini
                                                </button>
                                            </form>
                                        @else
                                            <button disabled class="inline-flex items-center gap-2 bg-gray-100 text-gray-400 font-bold py-2 px-4 rounded-xl cursor-not-allowed text-xs border border-gray-200">
                                                Tidak Tersedia
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                            <h3 class="text-sm font-bold text-gray-900">Salinan Kosong</h3>
                                            <p class="text-xs text-gray-500 mt-1">Belum ada eksemplar fisik yang didaftarkan untuk buku ini.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        @endauth

    </div>
@endsection
