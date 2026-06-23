@extends('layouts.admin')

@section('content')
    <div class="max-w-7xl mx-auto">

        {{-- Header Halaman --}}
        <div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Riwayat Pembayaran</h2>
                <p class="text-gray-500 mt-1 font-medium">Log transaksi masuk untuk denda keterlambatan (termasuk cicilan).</p>
            </div>
            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 bg-white text-gray-700 border border-gray-200 font-bold py-2.5 px-4 rounded-xl hover:bg-gray-50 transition shadow-sm text-sm">
                    <span>⬅️</span> Kembali
                </a>
                <a href="{{ route('admin.petugas.fines.index') }}" class="inline-flex items-center gap-2 bg-rose-50 text-rose-600 border border-rose-200 font-bold py-2.5 px-5 rounded-xl hover:bg-rose-100 transition shadow-sm text-sm">
                    <span>💸</span> Bayar Denda
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

        {{-- Filter Bar --}}
        <div class="bg-white p-6 rounded-[1.5rem] shadow-sm border border-gray-100 mb-8">
            <form action="{{ route('admin.petugas.fines.history') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                <div>
                    <label class="block text-xs font-extrabold text-gray-400 uppercase mb-2">Cari</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama / Judul buku..."
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-slate-500 focus:ring-4 focus:ring-slate-50 outline-none transition text-sm">
                </div>
                <div>
                    <label class="block text-xs font-extrabold text-gray-400 uppercase mb-2">Tahun Bayar</label>
                    <select name="year" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-slate-500 focus:ring-4 focus:ring-slate-50 outline-none transition text-sm cursor-pointer">
                        <option value="">Semua Tahun</option>
                        @foreach ($years as $year)
                            <option value="{{ $year->year }}" {{ request('year') == $year->year ? 'selected' : '' }}>{{ $year->year }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-extrabold text-gray-400 uppercase mb-2">Bulan Bayar</label>
                    <select name="month" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-slate-500 focus:ring-4 focus:ring-slate-50 outline-none transition text-sm cursor-pointer">
                        <option value="">Semua Bulan</option>
                        @foreach ([1=>'Jan', 2=>'Feb', 3=>'Mar', 4=>'Apr', 5=>'Mei', 6=>'Jun', 7=>'Jul', 8=>'Agu', 9=>'Sep', 10=>'Okt', 11=>'Nov', 12=>'Des'] as $num => $name)
                            <option value="{{ $num }}" {{ request('month') == $num ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-center gap-2">
                    <button type="submit" class="flex-1 bg-slate-900 text-white font-bold py-2.5 rounded-xl hover:bg-slate-800 transition shadow-sm text-sm">Filter</button>
                    <a href="{{ route('admin.petugas.fines.export', request()->query()) }}" class="bg-emerald-600 text-white font-bold py-2.5 px-4 rounded-xl hover:bg-emerald-700 transition shadow-sm text-sm" title="Export Excel">📊</a>
                    @if(request()->has('search') || request()->has('year') || request()->has('month'))
                        <a href="{{ route('admin.petugas.fines.history') }}" class="bg-gray-100 text-gray-500 font-bold py-2.5 px-4 rounded-xl hover:bg-gray-200 transition shadow-sm text-sm" title="Reset Filter">✖</a>
                    @endif
                </div>
            </form>
        </div>

        {{-- Tabel Riwayat --}}
        <div class="bg-white rounded-[1.5rem] shadow-sm border border-gray-100 overflow-hidden flex flex-col">

            <div class="p-6 border-b border-gray-100 bg-emerald-50/50 flex items-center gap-3">
                <span class="text-emerald-600 text-xl">🧾</span>
                <h3 class="text-lg font-extrabold text-emerald-900">Log Transaksi Masuk</h3>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-50/50 border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-5 text-xs font-extrabold text-gray-500 uppercase tracking-wider">Tgl Bayar</th>
                            <th class="px-6 py-5 text-xs font-extrabold text-gray-500 uppercase tracking-wider">Peminjam</th>
                            <th class="px-6 py-5 text-xs font-extrabold text-gray-500 uppercase tracking-wider">Buku</th>
                            <th class="px-6 py-5 text-xs font-extrabold text-gray-500 uppercase tracking-wider text-right">Nominal Masuk</th>
                            <th class="px-6 py-5 text-xs font-extrabold text-gray-500 uppercase tracking-wider text-center">Petugas</th>
                            <th class="px-6 py-5 text-xs font-extrabold text-gray-500 uppercase tracking-wider text-center">Status Peminjaman</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($payments as $payment)
                            <tr class="hover:bg-gray-50/80 transition duration-200">

                                {{-- Tanggal --}}
                                <td class="px-6 py-4">
                                    <div class="text-sm font-bold text-gray-900">{{ $payment->created_at->format('d M Y') }}</div>
                                    <div class="text-[10px] font-bold text-gray-400 uppercase mt-0.5">Pukul {{ $payment->created_at->format('H:i') }}</div>
                                </td>

                                {{-- Peminjam --}}
                                <td class="px-6 py-4">
                                    <div class="text-sm font-bold text-gray-900">{{ $payment->borrowing->user->name ?? 'User Terhapus' }}</div>
                                    <div class="text-xs text-gray-500 font-medium mt-0.5">{{ $payment->borrowing->user->class_info ?? '-' }}</div>
                                </td>

                                {{-- Buku --}}
                                <td class="px-6 py-4">
                                    <div class="text-sm font-bold text-gray-700 truncate" style="max-width: 200px;" title="{{ $payment->borrowing->bookCopy->book->title ?? 'Buku Dihapus' }}">
                                        {{ $payment->borrowing->bookCopy->book->title ?? 'Buku Dihapus' }}
                                    </div>
                                    <div class="text-[10px] font-mono text-gray-400 mt-0.5 tracking-wider">
                                        {{ $payment->borrowing->bookCopy->book_code ?? '-' }}
                                    </div>
                                </td>

                                {{-- Nominal --}}
                                <td class="px-6 py-4 text-right">
                                    <span class="inline-flex items-center gap-1 text-sm font-extrabold text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-lg border border-emerald-100">
                                        <span>+</span> Rp {{ number_format($payment->amount_paid, 0, ',', '.') }}
                                    </span>
                                </td>

                                {{-- Petugas --}}
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex px-2.5 py-1 rounded-lg text-[10px] font-bold bg-slate-100 text-slate-600 border border-slate-200">
                                        {{ $payment->processedBy->name ?? 'Sistem' }}
                                    </span>
                                </td>

                                {{-- Status Lunas/Belum --}}
                                <td class="px-6 py-4 text-center">
                                    @if(optional($payment->borrowing)->fine_status == 'paid')
                                        <span class="inline-flex items-center px-2.5 py-1.5 rounded-lg text-[10px] font-bold bg-emerald-100 text-emerald-700 uppercase tracking-widest">
                                            Lunas
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1.5 rounded-lg text-[10px] font-bold bg-amber-100 text-amber-700 uppercase tracking-widest">
                                            Belum Lunas
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <span class="text-5xl mb-4 opacity-50">🧾</span>
                                        <h3 class="text-lg font-bold text-gray-900">Belum ada riwayat</h3>
                                        <p class="text-gray-500 mt-1">Belum ada data pembayaran denda yang tercatat.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                    {{-- Total Footer --}}
                    @if($payments->isNotEmpty())
                        <tfoot class="bg-slate-50 border-t border-gray-100">
                            <tr>
                                <td colspan="3" class="px-6 py-5 text-right text-xs font-extrabold text-gray-500 uppercase tracking-wider">
                                    Total Uang Masuk (Sesuai Filter):
                                </td>
                                <td class="px-6 py-5 text-right text-lg font-extrabold text-emerald-600">
                                    Rp {{ number_format($totalIncome, 0, ',', '.') }}
                                </td>
                                <td colspan="2"></td>
                            </tr>
                        </tfoot>
                    @endif
                </table>
            </div>

            {{-- Pagination --}}
            @if ($payments->hasPages())
                <div class="p-6 border-t border-gray-100 bg-white">
                    {{ $payments->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
