@extends('layouts.admin')

@section('content')
    <div class="max-w-7xl mx-auto">

        {{-- Header Halaman --}}
        <div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Riwayat Peminjaman</h2>
                <p class="text-gray-500 mt-1 font-medium">Jejak rekam aktivitas peminjaman buku milik anggota perpustakaan.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.petugas.reports.borrowings.index') }}" class="inline-flex items-center gap-2 bg-white text-gray-700 border border-gray-200 font-bold py-2.5 px-5 rounded-xl hover:bg-gray-50 transition shadow-sm text-sm">
                    <span>⬅️</span> Kembali ke Laporan
                </a>
            </div>
        </div>

        {{-- PROFIL USER CARD --}}
        <div class="bg-white rounded-[1.5rem] shadow-sm border border-gray-100 p-6 sm:p-8 mb-8 flex flex-col md:flex-row gap-6 items-center md:items-start relative overflow-hidden z-0">
            <div class="absolute top-0 right-0 w-64 h-64 bg-emerald-50 rounded-full blur-3xl -z-10 -mt-20 -mr-20 pointer-events-none"></div>

            <div class="w-24 h-24 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center text-3xl font-black shrink-0 border-4 border-white shadow-md">
                {{ strtoupper(substr($user->name, 0, 2)) }}
            </div>

            <div class="flex-grow text-center md:text-left space-y-3 w-full">
                <div>
                    <div class="flex flex-col md:flex-row items-center justify-center md:justify-start gap-3 mb-1">
                        <h3 class="text-2xl font-black text-gray-900">{{ $user->name }}</h3>
                        <span class="px-2.5 py-0.5 rounded-lg text-[10px] font-bold bg-slate-800 text-white uppercase tracking-widest">{{ $user->role }}</span>
                    </div>
                    <p class="text-sm font-bold text-emerald-600">{{ $user->class_info ?? ($user->class_name ?? 'Informasi kelas tidak tersedia') }}</p>
                </div>

                <div class="flex flex-wrap items-center justify-center md:justify-start gap-3 text-sm font-medium text-gray-600">
                    <div class="flex items-center gap-1.5 bg-gray-50 px-3 py-1.5 rounded-lg border border-gray-200">
                        <span>📧</span> {{ $user->email }}
                    </div>

                    @if($user->phone_number)
                        @php
                            // Format Nomor WA
                            $cleanedPhone = preg_replace('/[^0-9]/', '', $user->phone_number);
                            $waNumber = (substr($cleanedPhone, 0, 1) === '0') ? '62' . substr($cleanedPhone, 1) : $cleanedPhone;
                        @endphp
                        <a href="https://wa.me/{{ $waNumber }}" target="_blank" class="flex items-center gap-1.5 bg-emerald-50 text-emerald-700 hover:bg-emerald-100 px-3 py-1.5 rounded-lg border border-emerald-200 transition font-bold" title="Klik untuk Chat WA">
                            <span>💬</span> {{ $user->phone_number }}
                        </a>
                    @else
                        <div class="flex items-center gap-1.5 bg-gray-50 px-3 py-1.5 rounded-lg border border-gray-200 text-gray-400 italic">
                            <span>📱</span> Nomor WA Kosong
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- TABEL RIWAYAT BUKU --}}
        <div class="bg-white rounded-[1.5rem] shadow-sm border border-gray-100 overflow-hidden flex flex-col">
            <div class="p-6 border-b border-gray-100 bg-slate-900 flex items-center justify-between gap-3">
                <h3 class="text-lg font-extrabold text-white flex items-center gap-2">
                    <span class="text-amber-400 text-xl">🕒</span>
                    Riwayat Transaksi Buku
                </h3>
                <span class="px-2.5 py-0.5 rounded-lg bg-white/20 text-white text-xs font-bold">{{ $history->count() }} Total Peminjaman</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse min-w-[800px]">
                    <thead class="bg-gray-50/80 border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-4 text-[10px] font-extrabold text-gray-500 uppercase tracking-wider text-center w-16">No</th>
                            <th class="px-6 py-4 text-[10px] font-extrabold text-gray-500 uppercase tracking-wider">Informasi Buku</th>
                            <th class="px-6 py-4 text-[10px] font-extrabold text-gray-500 uppercase tracking-wider">Timeline Peminjaman</th>
                            <th class="px-6 py-4 text-[10px] font-extrabold text-gray-500 uppercase tracking-wider text-right">Status Akhir</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($history as $item)
                            <tr class="hover:bg-gray-50/80 transition duration-200">

                                {{-- No --}}
                                <td class="px-6 py-4 text-sm font-bold text-gray-400 text-center">
                                    {{ $loop->iteration }}
                                </td>

                                {{-- Judul & Kode --}}
                                <td class="px-6 py-4">
                                    <div class="text-sm font-bold text-gray-900 leading-snug truncate max-w-sm" title="{{ $item->bookCopy->book->title }}">
                                        {{ $item->bookCopy->book->title }}
                                    </div>
                                    <span class="inline-block mt-1 px-2 py-0.5 rounded border border-gray-200 bg-gray-50 text-[10px] font-mono text-gray-600 tracking-wider">
                                        {{ $item->bookCopy->book_code }}
                                    </span>
                                </td>

                                {{-- Timeline --}}
                                <td class="px-6 py-4">
                                    <div class="flex flex-col gap-1.5 text-xs">
                                        <div class="flex items-center gap-2">
                                            <span class="w-10 text-[10px] font-extrabold text-gray-400 uppercase">Pinjam</span>
                                            <span class="font-bold text-gray-700 bg-slate-100 px-2 py-0.5 rounded border border-slate-200">
                                                {{ \Carbon\Carbon::parse($item->borrowed_at)->format('d M Y') }}
                                            </span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <span class="w-10 text-[10px] font-extrabold text-gray-400 uppercase">Kembali</span>
                                            @if($item->returned_at)
                                                <span class="font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded border border-emerald-100">
                                                    {{ \Carbon\Carbon::parse($item->returned_at)->format('d M Y') }}
                                                </span>
                                            @else
                                                <span class="font-bold text-rose-600 bg-rose-50 px-2 py-0.5 rounded border border-rose-100 italic">
                                                    Belum Kembali
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                {{-- Status --}}
                                <td class="px-6 py-4 text-right">
                                    @if(in_array($item->status, ['returned', 'dikembalikan']))
                                        <span class="inline-flex px-3 py-1 rounded-lg text-[10px] font-bold bg-emerald-100 text-emerald-700 border border-emerald-200 uppercase tracking-widest">
                                            ✅ Dikembalikan
                                        </span>
                                    @elseif(in_array($item->status, ['borrowed', 'dipinjam', 'overdue']))
                                        <span class="inline-flex px-3 py-1 rounded-lg text-[10px] font-bold bg-amber-100 text-amber-700 border border-amber-200 uppercase tracking-widest">
                                            ⏳ Sedang Dipinjam
                                        </span>
                                    @elseif(in_array($item->status, ['missing', 'hilang']))
                                        <span class="inline-flex px-3 py-1 rounded-lg text-[10px] font-bold bg-rose-100 text-rose-700 border border-rose-200 uppercase tracking-widest">
                                            ⚠️ Hilang
                                        </span>
                                    @else
                                        <span class="inline-flex px-3 py-1 rounded-lg text-[10px] font-bold bg-gray-100 text-gray-700 border border-gray-200 uppercase tracking-widest">
                                            {{ strtoupper($item->status) }}
                                        </span>
                                    @endif
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <span class="text-5xl mb-4 opacity-50">📂</span>
                                        <h3 class="text-lg font-bold text-gray-900">Rekam Jejak Bersih</h3>
                                        <p class="text-gray-500 mt-1">Pengguna ini belum pernah melakukan peminjaman buku.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
