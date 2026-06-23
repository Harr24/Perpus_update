@extends('layouts.admin')

@section('content')
    <div class="max-w-7xl mx-auto">

        {{-- Header Halaman --}}
        <div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Informasi Detail Buku</h2>
                <p class="text-gray-500 mt-1 font-medium">Tinjauan lengkap data buku dan status ketersediaan setiap salinannya.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.petugas.books.index') }}" class="inline-flex items-center gap-2 bg-white text-gray-700 border border-gray-200 font-bold py-2.5 px-5 rounded-xl hover:bg-gray-50 transition shadow-sm text-sm">
                    <span>⬅️</span> Kembali
                </a>
                <a href="{{ route('admin.petugas.books.edit', $book) }}" class="inline-flex items-center gap-2 bg-amber-50 text-amber-600 border border-amber-200 font-bold py-2.5 px-5 rounded-xl hover:bg-amber-100 transition shadow-sm text-sm">
                    <span>✏️</span> Edit Buku
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">

            {{-- KOLOM KIRI: SAMPUL & STATISTIK --}}
            <div class="lg:col-span-1 space-y-6">

                {{-- Card Cover --}}
                <div class="bg-white rounded-[1.5rem] shadow-sm border border-gray-100 p-6 flex flex-col items-center">
                    <div class="w-48 h-72 rounded-xl overflow-hidden shadow-md border border-gray-200 bg-gray-50 mb-6 flex items-center justify-center">
                        @if($book->cover_image && Storage::disk('public')->exists($book->cover_image))
                            <img src="{{ Storage::url($book->cover_image) }}" alt="Cover Buku" class="w-full h-full object-cover">
                        @else
                            <span class="text-sm font-bold text-gray-400 uppercase tracking-widest text-center">No<br>Cover</span>
                        @endif
                    </div>

                    <div class="w-full space-y-3">
                        <div class="flex justify-between items-center p-3 bg-gray-50 rounded-xl border border-gray-100">
                            <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">Total Eksemplar</span>
                            <span class="text-lg font-black text-gray-900">{{ $book->stock }}</span>
                        </div>
                        <div class="flex justify-between items-center p-3 bg-emerald-50 rounded-xl border border-emerald-100">
                            <span class="text-xs font-bold text-emerald-700 uppercase tracking-wider">Tersedia</span>
                            <span class="text-lg font-black text-emerald-600">{{ $book->copies->where('status', 'tersedia')->count() }}</span>
                        </div>
                        <div class="flex justify-between items-center p-3 bg-amber-50 rounded-xl border border-amber-100">
                            <span class="text-xs font-bold text-amber-700 uppercase tracking-wider">Sedang Dipinjam</span>
                            <span class="text-lg font-black text-amber-600">{{ $book->borrowed_copies_count }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- KOLOM KANAN: IDENTITAS & SINOPSIS --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- Card Info Utama --}}
                <div class="bg-white rounded-[1.5rem] shadow-sm border border-gray-100 p-6 sm:p-8">

                    {{-- Badges Atas --}}
                    <div class="flex flex-wrap gap-2 mb-4">
                        <span class="px-3 py-1 rounded-lg text-xs font-bold bg-indigo-50 text-indigo-700 border border-indigo-100">
                            📂 {{ optional($book->genre)->name ?? 'TANPA GENRE' }}
                        </span>
                        <span class="px-3 py-1 rounded-lg text-xs font-bold bg-slate-100 text-slate-700 border border-slate-200">
                            📍 RAK {{ optional($book->shelf)->name ?? 'BELUM DIATUR' }}
                        </span>

                        @switch($book->book_type)
                            @case('reguler')
                                <span class="px-3 py-1 rounded-lg text-xs font-bold bg-sky-100 text-sky-700 border border-sky-200">📖 BUKU REGULER</span>
                                @break
                            @case('paket')
                                <span class="px-3 py-1 rounded-lg text-xs font-bold bg-amber-100 text-amber-700 border border-amber-200">📚 BUKU PAKET</span>
                                @break
                            @case('laporan')
                                <span class="px-3 py-1 rounded-lg text-xs font-bold bg-purple-100 text-purple-700 border border-purple-200">📝 BUKU LAPORAN</span>
                                @break
                            @default
                                <span class="px-3 py-1 rounded-lg text-xs font-bold bg-gray-100 text-gray-700 border border-gray-200">{{ strtoupper($book->book_type) }}</span>
                        @endswitch
                    </div>

                    {{-- Judul & Penulis --}}
                    <h1 class="text-2xl sm:text-4xl font-black text-gray-900 leading-tight mb-2">{{ $book->title }}</h1>
                    <p class="text-lg font-bold text-gray-500 mb-6">Oleh: <span class="text-gray-800">{{ $book->author }}</span></p>

                    <div class="h-px w-full bg-gray-100 mb-6"></div>

                    {{-- Sinopsis --}}
                    <div>
                        <h4 class="text-sm font-extrabold text-gray-900 uppercase tracking-widest mb-3">Sinopsis</h4>
                        @if ($book->synopsis)
                            <p class="text-sm text-gray-600 leading-relaxed whitespace-pre-wrap">{{ $book->synopsis }}</p>
                        @else
                            <p class="text-sm text-gray-400 italic">Sinopsis tidak tersedia untuk buku ini.</p>
                        @endif
                    </div>

                </div>
            </div>
        </div>

        {{-- BAGIAN BAWAH: TABEL DAFTAR SALINAN --}}
        <div class="bg-white rounded-[1.5rem] shadow-sm border border-gray-100 overflow-hidden">

            <div class="p-6 border-b border-gray-100 bg-slate-900 flex justify-between items-center">
                <h3 class="text-lg font-extrabold text-white flex items-center gap-3">
                    <span>📑</span> Daftar Salinan Fisik (Eksemplar)
                </h3>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-50/50 border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-4 text-xs font-extrabold text-gray-500 uppercase tracking-wider w-16 text-center">No</th>
                            <th class="px-6 py-4 text-xs font-extrabold text-gray-500 uppercase tracking-wider">Kode Buku</th>
                            <th class="px-6 py-4 text-xs font-extrabold text-gray-500 uppercase tracking-wider w-32 text-center">Status</th>
                            <th class="px-6 py-4 text-xs font-extrabold text-gray-500 uppercase tracking-wider">Keterangan Tambahan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($book->copies as $copy)
                            <tr class="hover:bg-gray-50/50 transition duration-200">

                                {{-- No --}}
                                <td class="px-6 py-4 text-sm font-bold text-gray-400 text-center">{{ $loop->iteration }}</td>

                                {{-- Kode --}}
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold font-mono bg-slate-100 text-slate-700 border border-slate-200">
                                        {{ $copy->book_code }}
                                    </span>
                                </td>

                                {{-- Status --}}
                                <td class="px-6 py-4 text-center">
                                    @if($copy->status == 'tersedia')
                                        <span class="inline-flex px-3 py-1 rounded-lg text-[10px] font-bold bg-emerald-100 text-emerald-700 uppercase tracking-widest border border-emerald-200">Tersedia</span>
                                    @elseif ($copy->status == 'dipinjam')
                                        <span class="inline-flex px-3 py-1 rounded-lg text-[10px] font-bold bg-amber-100 text-amber-700 uppercase tracking-widest border border-amber-200">Dipinjam</span>
                                    @elseif ($copy->status == 'hilang')
                                        <span class="inline-flex px-3 py-1 rounded-lg text-[10px] font-bold bg-gray-800 text-white uppercase tracking-widest border border-gray-700">Hilang</span>
                                    @elseif ($copy->status == 'overdue')
                                        <span class="inline-flex px-3 py-1 rounded-lg text-[10px] font-bold bg-rose-100 text-rose-700 uppercase tracking-widest border border-rose-200">Terlambat</span>
                                    @else
                                        <span class="inline-flex px-3 py-1 rounded-lg text-[10px] font-bold bg-sky-100 text-sky-700 uppercase tracking-widest border border-sky-200">{{ strtoupper($copy->status) }}</span>
                                    @endif
                                </td>

                                {{-- Keterangan / Info Peminjam --}}
                                <td class="px-6 py-4">
                                    @php $borrowing = $copy->borrowings->first(); @endphp

                                    {{-- Info Jika Dipinjam / Telat --}}
                                    @if(in_array($copy->status, ['dipinjam', 'overdue']) && $borrowing && $borrowing->user)
                                        <div class="flex items-start gap-3 p-3 bg-amber-50/50 rounded-xl border border-amber-100/50 max-w-sm">
                                            <div class="w-8 h-8 rounded-full bg-amber-100 text-amber-700 flex items-center justify-center font-bold text-xs shrink-0">
                                                {{ strtoupper(substr($borrowing->user->name, 0, 2)) }}
                                            </div>
                                            <div class="min-w-0">
                                                <p class="text-xs font-bold text-gray-900 truncate">{{ $borrowing->user->name }}</p>
                                                <p class="text-[10px] font-medium text-gray-500 truncate">{{ $borrowing->user->class_info ?? '-' }}</p>
                                                @if($borrowing->due_date)
                                                    <p class="text-[10px] font-bold text-rose-600 mt-1">Wajib Kembali: {{ \Carbon\Carbon::parse($borrowing->due_date)->format('d M Y') }}</p>
                                                @endif
                                            </div>
                                        </div>

                                    {{-- Info Jika Hilang --}}
                                    @elseif($copy->status == 'hilang' && $borrowing && $borrowing->user)
                                        <div class="flex items-start gap-3 p-3 bg-gray-50 rounded-xl border border-gray-200 max-w-sm">
                                            <div class="w-8 h-8 rounded-full bg-gray-200 text-gray-600 flex items-center justify-center font-bold text-xs shrink-0">
                                                ❌
                                            </div>
                                            <div class="min-w-0">
                                                <p class="text-[10px] font-bold text-rose-600 uppercase tracking-wider mb-0.5">Dihilangkan Oleh:</p>
                                                <p class="text-xs font-bold text-gray-900 truncate">{{ $borrowing->user->name }}</p>
                                                <p class="text-[10px] font-medium text-gray-500 truncate">{{ $borrowing->user->class_info ?? '-' }}</p>
                                                <p class="text-[10px] font-bold text-gray-400 mt-1">Lapor: {{ \Carbon\Carbon::parse($borrowing->returned_at)->format('d M Y') }}</p>
                                            </div>
                                        </div>

                                    {{-- Jika Tersedia --}}
                                    @else
                                        <span class="text-xs text-gray-400 italic">Siap dipinjam</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center">
                                    <span class="text-gray-400 font-bold text-sm">Belum ada data eksemplar untuk buku ini.</span>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
