@extends('layouts.admin')

@section('content')
    <div class="max-w-7xl mx-auto">

        {{-- Header Halaman --}}
        <div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Riwayat Denda</h2>
                <p class="text-gray-500 mt-1 font-medium">Daftar lengkap transaksi denda yang telah diselesaikan.</p>
            </div>
            <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 bg-white text-gray-700 border border-gray-200 font-bold py-2.5 px-5 rounded-xl hover:bg-gray-50 transition shadow-sm text-sm">
                <span>⬅️</span> Kembali
            </a>
        </div>

        {{-- Filter Bar --}}
        <div class="bg-white p-6 rounded-[1.5rem] shadow-sm border border-gray-100 mb-8">
            <form action="{{ route('admin.superadmin.fines.history') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-xs font-extrabold text-gray-400 uppercase mb-2">Cari</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama / Judul..."
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-slate-500 focus:ring-4 focus:ring-slate-50 outline-none transition text-sm">
                </div>
                <div>
                    <label class="block text-xs font-extrabold text-gray-400 uppercase mb-2">Tahun</label>
                    <select name="year" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-slate-500 focus:ring-4 focus:ring-slate-50 outline-none transition text-sm cursor-pointer">
                        <option value="">Semua Tahun</option>
                        @foreach ($years as $year)
                            <option value="{{ $year->year }}" {{ request('year') == $year->year ? 'selected' : '' }}>{{ $year->year }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-extrabold text-gray-400 uppercase mb-2">Bulan</label>
                    <select name="month" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-slate-500 focus:ring-4 focus:ring-slate-50 outline-none transition text-sm cursor-pointer">
                        <option value="">Semua Bulan</option>
                        @foreach ([1=>'Jan', 2=>'Feb', 3=>'Mar', 4=>'Apr', 5=>'Mei', 6=>'Jun', 7=>'Jul', 8=>'Agu', 9=>'Sep', 10=>'Okt', 11=>'Nov', 12=>'Des'] as $num => $name)
                            <option value="{{ $num }}" {{ request('month') == $num ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-end gap-2">
                    <button type="submit" class="flex-1 bg-slate-900 text-white font-bold py-2.5 rounded-xl hover:bg-slate-800 transition text-sm">Filter</button>
                    <a href="{{ route('admin.superadmin.fines.export', request()->query()) }}" class="bg-emerald-600 text-white font-bold py-2.5 px-4 rounded-xl hover:bg-emerald-700 transition text-sm" title="Export Excel">📊</a>
                </div>
            </form>
        </div>

        {{-- Tabel Riwayat --}}
        <div class="bg-white rounded-[1.5rem] shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-50/50 border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-5 text-xs font-extrabold text-gray-500 uppercase tracking-wider">Peminjam</th>
                            <th class="px-6 py-5 text-xs font-extrabold text-gray-500 uppercase tracking-wider">Kelas/Mapel</th>
                            <th class="px-6 py-5 text-xs font-extrabold text-gray-500 uppercase tracking-wider">Judul Buku</th>
                            <th class="px-6 py-5 text-xs font-extrabold text-gray-500 uppercase tracking-wider text-right">Denda</th>
                            <th class="px-6 py-5 text-xs font-extrabold text-gray-500 uppercase tracking-wider">Tgl Lunas</th>
                            <th class="px-6 py-5 text-xs font-extrabold text-gray-500 uppercase tracking-wider text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">
                        @forelse ($paidFines as $fine)
                            @php $lastPayment = $fine->finePayments->last(); @endphp
                            <tr class="hover:bg-gray-50/80 transition duration-200">
                                {{-- Gunakan Nullsafe Operator (?->) agar tidak crash jika user dihapus --}}
                                <td class="px-6 py-4 text-sm font-bold text-gray-900">{{ $fine->user?->name ?? 'Anggota Dihapus' }}</td>
                                <td class="px-6 py-4 text-sm font-medium text-gray-600">{{ $fine->user?->class_info ?? '-' }}</td>

                                <td class="px-6 py-4">
                                    {{-- Gunakan Nullsafe Operator (?->) agar tidak crash jika buku/eksemplar dihapus --}}
                                    <div class="text-sm font-bold text-gray-900">{{ $fine->bookCopy?->book?->title ?? 'Buku Dihapus/Hilang' }}</div>
                                    <div class="text-[10px] font-mono text-gray-400 uppercase">{{ $fine->bookCopy?->book_code ?? '-' }}</div>
                                </td>

                                <td class="px-6 py-4 text-sm font-extrabold text-rose-600 text-right">Rp{{ number_format($fine->fine_amount, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 text-sm font-medium text-gray-600">
                                    {{ $lastPayment ? $lastPayment->created_at->format('d M Y') : 'N/A' }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <form action="{{ route('admin.superadmin.fines.destroy', $fine->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus riwayat ini?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-rose-500 hover:text-rose-700 font-bold text-xs">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-gray-400 font-bold">Tidak ada riwayat denda.</td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot class="bg-gray-50 border-t border-gray-100">
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-right font-extrabold text-gray-900">TOTAL PEMASUKAN</td>
                            <td class="px-6 py-4 text-right font-extrabold text-emerald-600 text-lg">Rp {{ number_format($totalFine, 0, ',', '.') }}</td>
                            <td colspan="2"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            @if ($paidFines->hasPages())
                <div class="p-6 border-t border-gray-100">
                    {{ $paidFines->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
