@extends('layouts.admin')

@section('content')
    <div class="mb-6">
        <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Halo, {{ strtok(Auth::user()->name, " ") }}! 👋</h2>
        <p class="text-gray-500 mt-1 font-medium">Selamat datang di perpustakaan digital. Mau baca buku apa hari ini?</p>
    </div>

    {{-- BARIS 1: BUKU FAVORIT (KIRI) & WIDGET PINJAMAN (KANAN) --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">

        {{-- KIRI: WIDGET 10 BUKU FAVORIT --}}
        <div class="lg:col-span-2 bg-white rounded-[1.5rem] shadow-sm border border-gray-100 p-6 flex flex-col overflow-hidden">
            <div class="flex items-center gap-2 mb-4">
                <span class="text-xl text-rose-500">❤️</span>
                <h3 class="font-extrabold text-gray-900 text-lg">Buku Terpopuler</h3>
            </div>

            @if(isset($favoriteBooks) && $favoriteBooks->isNotEmpty())
                <div class="flex overflow-x-auto gap-4 pb-4 pt-2 snap-x snap-mandatory custom-scrollbar flex-1" style="scroll-behavior: smooth;">
                    @foreach($favoriteBooks as $book)
                        {{-- Link menuju halaman detail buku --}}
                        <a href="{{ route('catalog.show', $book->id) }}" class="block shrink-0 w-[140px] sm:w-[150px] bg-white rounded-xl p-2.5 border border-gray-100 shadow-sm hover:-translate-y-1 hover:shadow-md transition duration-300 snap-start relative group cursor-pointer">

                            {{-- Lencana Peringkat --}}
                            <div class="absolute -top-2 -left-2 w-7 h-7 rounded-full bg-rose-500 text-white font-black text-xs flex items-center justify-center border-4 border-white shadow-sm z-10">
                                #{{ $loop->iteration }}
                            </div>

                            {{-- Gambar Sampul --}}
                            <div class="w-full h-40 rounded-lg overflow-hidden mb-2.5 bg-gray-100 relative">
                                @if($book->cover_image && Storage::disk('public')->exists($book->cover_image))
                                    <img src="{{ Storage::url($book->cover_image) }}" alt="Cover" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                                @else
                                    <img src="https://placehold.co/140x200/eef0f2/6c757d?text=No+Cover" class="w-full h-full object-cover">
                                @endif
                            </div>

                            {{-- Informasi Teks --}}
                            <div class="space-y-1">
                                <span class="inline-block px-1.5 py-0.5 rounded text-[8px] font-bold bg-indigo-50 text-indigo-600 uppercase tracking-widest">
                                    {{ $book->genre->name ?? 'Buku' }}
                                </span>
                                <h4 class="font-bold text-xs text-gray-900 leading-snug line-clamp-2 group-hover:text-indigo-600 transition" title="{{ $book->title }}">{{ $book->title }}</h4>

                                {{-- Info Ketersediaan --}}
                                <div class="mt-1.5 pt-1.5 border-t border-gray-50">
                                    @if($book->available_copies_count > 0)
                                        <span class="text-[9px] font-bold text-emerald-600">Tersedia {{ $book->available_copies_count }}</span>
                                    @else
                                        <span class="text-[9px] font-bold text-rose-600">Sedang Dipinjam</span>
                                    @endif
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="flex-1 flex flex-col items-center justify-center text-center p-4 bg-gray-50 rounded-xl border border-dashed border-gray-200">
                    <span class="text-3xl block mb-2 opacity-50">📚</span>
                    <p class="text-gray-500 text-xs font-medium">Belum ada data buku favorit saat ini.</p>
                </div>
            @endif
        </div>

        {{-- KANAN: WIDGET SEDANG DIPINJAM / KUTIPAN --}}
        <div class="flex flex-col h-full">
            @if(isset($borrowingInfo) && $borrowingInfo->isNotEmpty())
                <div class="bg-white rounded-[1.5rem] shadow-sm p-6 border border-gray-100 flex-1 flex flex-col">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-2">
                            <span class="text-xl">📖</span>
                            <h3 class="font-extrabold text-gray-900 text-lg">Sedang Dipinjam</h3>
                        </div>
                        <span class="bg-indigo-100 text-indigo-700 px-2.5 py-0.5 rounded-lg text-xs font-bold">
                            {{ $borrowingInfo->count() }} Buku
                        </span>
                    </div>

                    <div class="space-y-3 overflow-y-auto pr-2 flex-1 max-h-[280px]">
                        @foreach($borrowingInfo as $active)
                            <div class="flex gap-4 items-center bg-indigo-50/50 p-3 rounded-xl border border-indigo-50 hover:border-indigo-200 transition">
                                <div class="w-12 h-16 shrink-0 rounded-lg overflow-hidden shadow-sm bg-gray-200">
                                    @if($active->bookCopy->book->cover_image)
                                        <img src="{{ asset('storage/' . $active->bookCopy->book->cover_image) }}" alt="Cover" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-[8px] text-gray-400 font-bold bg-gray-100 text-center px-1">NO COVER</div>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="font-bold text-gray-900 text-xs truncate mb-1" title="{{ $active->bookCopy->book->title }}">
                                        {{ $active->bookCopy->book->title }}
                                    </h4>
                                    <div class="text-[10px] text-gray-500 space-y-0.5">
                                        <p><span class="font-semibold text-gray-700">Kode:</span> {{ $active->bookCopy->book_code }}</p>
                                        @php
                                            $due = \Carbon\Carbon::parse($active->due_at);
                                            $isLate = $due->isPast();
                                        @endphp
                                        <p class="{{ $isLate ? 'text-red-500 font-bold' : 'text-emerald-600 font-semibold' }}">
                                            <span class="font-semibold text-gray-700">Tenggat:</span> {{ $due->format('d M Y') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <a href="{{ route('borrow.history') }}" class="mt-4 block w-full text-center bg-gray-50 text-gray-700 font-bold py-2 rounded-xl hover:bg-gray-100 transition shadow-sm text-xs border border-gray-200">
                        Lihat Riwayat Lengkap
                    </a>
                </div>
            @else
                <div class="bg-white rounded-[1.5rem] shadow-sm p-6 border border-gray-100 flex-1 flex flex-col justify-center">
                    <div class="flex items-center gap-2 mb-4">
                        <span class="text-xl">💡</span>
                        <h3 class="font-extrabold text-gray-900 text-lg">Kutipan Hari Ini</h3>
                    </div>
                    <div class="bg-indigo-50 border-l-4 border-indigo-500 p-4 rounded-r-xl mb-4">
                        <p class="text-sm font-medium italic text-gray-700 leading-relaxed">
                            "Membaca adalah jendela dunia. Semakin banyak membaca, semakin banyak kita tahu."
                        </p>
                        <p class="text-[10px] font-bold text-gray-500 mt-2">— Peribahasa</p>
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- BARIS 2: BANNER MULAI EKSPLORASI (CLEAN & MINIMALIST) --}}
    <div class="bg-white rounded-[1.5rem] shadow-sm p-6 sm:p-8 mb-6 border border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-6 relative overflow-hidden">
        {{-- Garis Aksen Tipis di Kiri --}}
        <div class="absolute left-0 top-0 bottom-0 w-2 bg-indigo-600"></div>

        <div class="text-center sm:text-left text-gray-800 max-w-2xl pl-2 sm:pl-4">
            <h3 class="text-xl font-extrabold mb-2 text-gray-900">Mulai Eksplorasi Perpustakaan</h3>
            <p class="text-gray-500 text-sm font-medium leading-relaxed">
                Temukan ribuan koleksi buku menarik, fiksi maupun non-fiksi. Pinjam dengan mudah dan mulai petualangan membacamu hari ini.
            </p>
        </div>

        <div class="shrink-0 w-full sm:w-auto">
            <a href="{{ route('catalog.index') }}" class="flex items-center justify-center gap-2 bg-indigo-600 text-white font-bold py-3 px-8 rounded-xl hover:bg-indigo-700 transition shadow-sm text-sm">
                Katalog Buku <span>&rarr;</span>
            </a>
        </div>
    </div>

    {{-- BARIS 3: INFORMASI PENTING --}}
    <div class="bg-white rounded-[1.5rem] shadow-sm p-6 sm:p-8 border border-gray-100">
        <div class="flex items-center gap-3 mb-6">
            <span class="text-2xl">📢</span>
            <h3 class="text-lg font-extrabold text-gray-900">Informasi Penting</h3>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
            <div class="bg-gray-50 rounded-2xl p-5 border border-gray-100 hover:border-indigo-100 transition flex gap-4 items-start">
                <span class="text-2xl">🧑‍🎓</span>
                <div>
                    <h4 class="font-bold text-gray-900 text-sm mb-1">Update Kelas</h4>
                    <p class="text-xs text-gray-500 leading-relaxed">
                        Jika kamu naik kelas atau pindah jurusan, kamu <strong>wajib</strong> memperbarui data kelas. Silakan edit profil di <a href="{{ route('profile.edit') }}" class="text-indigo-600 font-bold hover:underline">halaman profil</a>.
                    </p>
                </div>
            </div>

            <div class="bg-gray-50 rounded-2xl p-5 border border-gray-100 hover:border-indigo-100 transition flex gap-4 items-start">
                <span class="text-2xl">📥</span>
                <div>
                    <h4 class="font-bold text-gray-900 text-sm mb-1">Cara Pengembalian Buku</h4>
                    <p class="text-xs text-gray-500 leading-relaxed">
                        Untuk mengembalikan buku, silakan datang langsung ke perpustakaan dan serahkan fisik buku kepada petugas yang berjaga.
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<style>
    /* Custom Scrollbar untuk area Top 10 Buku */
    .custom-scrollbar::-webkit-scrollbar {
        height: 6px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 10px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 10px;
    }
    .custom-scrollbar:hover::-webkit-scrollbar-thumb {
        background: #94a3b8;
    }
</style>
@endpush
