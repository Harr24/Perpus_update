@extends('layouts.admin')

@section('content')
    {{-- Header Halaman --}}
    <div class="mb-8">
        <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Riwayat Peminjaman</h2>
        <p class="text-gray-500 mt-1 font-medium">Pantau daftar buku yang sedang dan pernah Anda pinjam di sini.</p>
    </div>

    {{-- Alert Notifikasi --}}
    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 text-emerald-700 border border-emerald-100 rounded-xl font-bold flex items-center gap-3">
            <span class="text-xl">✅</span> {{ session('success') }}
        </div>
    @endif

    {{-- Kontainer Tabel Utama --}}
    <div class="bg-white rounded-[1.5rem] shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50/50 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-5 text-xs font-extrabold text-gray-500 uppercase tracking-wider">No.</th>
                        <th class="px-6 py-5 text-xs font-extrabold text-gray-500 uppercase tracking-wider">Judul Buku</th>
                        <th class="px-6 py-5 text-xs font-extrabold text-gray-500 uppercase tracking-wider">Kode Buku</th>
                        <th class="px-6 py-5 text-xs font-extrabold text-gray-500 uppercase tracking-wider">Tgl Pinjam</th>
                        <th class="px-6 py-5 text-xs font-extrabold text-gray-500 uppercase tracking-wider">Jatuh Tempo</th>
                        <th class="px-6 py-5 text-xs font-extrabold text-gray-500 uppercase tracking-wider">Tgl Kembali</th>
                        <th class="px-6 py-5 text-xs font-extrabold text-gray-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($borrowings as $index => $borrow)
                        @php
                            $isOverdue = $borrow->status == 'dipinjam' && \Carbon\Carbon::parse($borrow->due_at)->lt(now());
                            $isRejected = $borrow->status == 'rejected';
                        @endphp

                        <tr class="hover:bg-gray-50/50 transition duration-200 {{ $isRejected ? 'opacity-60' : '' }}">
                            <td class="px-6 py-4 text-sm text-gray-600 font-medium">
                                {{ $index + 1 }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm font-bold text-gray-900 line-clamp-2">
                                    {{ $borrow->bookCopy->book->title }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-lg text-xs font-bold font-mono">
                                    {{ $borrow->bookCopy->book_code }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600 font-medium">
                                {{ \Carbon\Carbon::parse($borrow->borrowed_at)->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 text-sm font-medium {{ $isOverdue ? 'text-red-600 font-bold' : 'text-gray-600' }}">
                                {{ $borrow->due_at ? \Carbon\Carbon::parse($borrow->due_at)->format('d M Y') : '-' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600 font-medium">
                                @if($borrow->returned_at)
                                    {{ \Carbon\Carbon::parse($borrow->returned_at)->format('d M Y') }}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @switch($borrow->status)
                                    @case('pending')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-amber-50 text-amber-700 text-xs font-bold border border-amber-100">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Menunggu
                                        </span>
                                        @break

                                    @case('rejected')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-rose-50 text-rose-700 text-xs font-bold border border-rose-100">
                                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Ditolak
                                        </span>
                                        @break

                                    @case('dipinjam')
                                        @if($isOverdue)
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-red-50 text-red-700 text-xs font-bold border border-red-100">
                                                <span class="w-1.5 h-1.5 rounded-full bg-red-500 animate-pulse"></span> Terlambat
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-blue-50 text-blue-700 text-xs font-bold border border-blue-100">
                                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span> Dipinjam
                                            </span>
                                        @endif
                                        @break

                                    @case('returned')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-emerald-50 text-emerald-700 text-xs font-bold border border-emerald-100">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Kembali
                                        </span>
                                        @break
                                @endswitch
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <span class="text-4xl mb-3">📭</span>
                                    <h3 class="text-lg font-bold text-gray-900">Belum ada riwayat</h3>
                                    <p class="text-gray-500 mt-1">Anda belum pernah meminjam buku. Yuk, mulai membaca!</p>
                                    <a href="{{ route('catalog.index') }}" class="mt-4 inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold rounded-xl transition">
                                        Lihat Katalog Buku
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
