@extends('layouts.admin')

@section('content')
    <div class="mb-6">
        <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight flex items-center gap-2">
            Halo, {{ strtok(Auth::user()->name, " ") }}!
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7 text-amber-500">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.05 4.575a1.575 1.575 0 10-3.15 0v3m3.15-3v-1.5a1.575 1.575 0 013.15 0v1.5m-3.15 0l.075 5.925m3.075.75V4.575m0 0a1.575 1.575 0 013.15 0V15M6.9 7.575a1.575 1.575 0 10-3.15 0v8.175a6.75 6.75 0 006.75 6.75h2.018a5.25 5.25 0 003.712-1.538l1.732-1.732a5.25 5.25 0 001.538-3.712l.003-2.024a.668.668 0 01.198-.472l.02-.02c.415-.414.647-.976.647-1.561a2.25 2.25 0 00-2.25-2.25c-.414 0-.822.11-1.185.319m-4.965 3.065a2.25 2.25 0 00-4.5 0" />
            </svg>
        </h2>
        <p class="text-gray-500 mt-1 font-medium">Selamat datang di perpustakaan digital. Mau baca buku apa hari ini?</p>
    </div>

    {{-- BARIS 1: BUKU FAVORIT (KIRI) & WIDGET PINJAMAN (KANAN) --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">

        {{-- KIRI: WIDGET 10 BUKU FAVORIT --}}
        <div class="lg:col-span-2 bg-white rounded-[1.5rem] shadow-sm border border-gray-100 p-6 flex flex-col overflow-hidden">
            <div class="flex items-center gap-2 mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-rose-500">
                    <path d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.704 0l-.003-.001z" />
                </svg>
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
                    {{-- Icon: books/rectangle-stack (pengganti emoji 📚) --}}
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 mb-2 text-gray-400 opacity-50">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 6.878V6a2.25 2.25 0 012.25-2.25h7.5A2.25 2.25 0 0118 6v.878m-12 0c.235-.083.487-.128.75-.128h10.5c.263 0 .515.045.75.128m-12 0A2.25 2.25 0 004.5 9v.878m13.5-3A2.25 2.25 0 0119.5 9v.878m0 0a2.246 2.246 0 00-.75-.128H5.25c-.263 0-.515.045-.75.128m15 0A2.25 2.25 0 0121 12v6a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 18v-6c0-.98.626-1.813 1.5-2.122" />
                    </svg>
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
                            {{-- Icon: book-open (pengganti emoji 📖) --}}
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-indigo-600">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                            </svg>
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
                        {{-- Icon: light-bulb (pengganti emoji 💡) --}}
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-amber-500">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 001.5-.189m-1.5.189a6.01 6.01 0 01-1.5-.189m3.75 7.478a12.06 12.06 0 01-4.5 0m3.75 2.383a14.406 14.406 0 01-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 10-7.517 0c.85.493 1.509 1.333 1.509 2.316V18" />
                        </svg>
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
            <a href="{{ route('internal.catalog.all') }}" class="flex items-center justify-center gap-2 bg-indigo-600 text-white font-bold py-3 px-8 rounded-xl hover:bg-indigo-700 transition shadow-sm text-sm">
                Katalog Buku <span>&rarr;</span>
            </a>
        </div>
    </div>

    {{-- BARIS 3: INFORMASI PENTING --}}
    <div class="bg-white rounded-[1.5rem] shadow-sm p-6 sm:p-8 border border-gray-100">
        <div class="flex items-center gap-3 mb-6">
            {{-- Icon: megaphone (pengganti emoji 📢) --}}
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7 text-indigo-600">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.34 15.84c-.688-.06-1.386-.09-2.09-.09H7.5a4.5 4.5 0 110-9h.75c.704 0 1.402-.03 2.09-.09m0 9.18c.253.962.584 1.892.985 2.783.247.55.06 1.21-.463 1.511l-.657.38c-.551.318-1.26.117-1.527-.461a20.845 20.845 0 01-1.44-4.282m3.102.069a18.03 18.03 0 01-.59-4.59c0-1.586.205-3.124.59-4.59m0 9.18a23.848 23.848 0 018.835 2.535M10.34 6.66a23.847 23.847 0 008.835-2.535m0 0A23.74 23.74 0 0018.795 3m.38 1.125a23.91 23.91 0 011.014 5.395m-1.014 8.855c-.118.38-.245.754-.38 1.125m.38-1.125a23.91 23.91 0 001.014-5.395m0-3.46c.495.413.811 1.035.811 1.73 0 .695-.316 1.317-.811 1.73m0-3.46a24.347 24.347 0 010 3.46" />
            </svg>
            <h3 class="text-lg font-extrabold text-gray-900">Informasi Penting</h3>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
            <div class="bg-gray-50 rounded-2xl p-5 border border-gray-100 hover:border-indigo-100 transition flex gap-4 items-start">
                {{-- Icon: academic-cap (pengganti emoji 🧑‍🎓) --}}
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7 shrink-0 text-indigo-600">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5" />
                </svg>
                <div>
                    <h4 class="font-bold text-gray-900 text-sm mb-1">Update Kelas</h4>
                    <p class="text-xs text-gray-500 leading-relaxed">
                        Jika kamu pindah jurusan, kamu <strong>wajib</strong> memperbarui data kelas, Hubungi Admin perpustakaan <a href="{{ route('profile.edit') }}" class="text-indigo-600 font-bold hover:underline">halaman profil</a>.
                    </p>
                </div>
            </div>

            <div class="bg-gray-50 rounded-2xl p-5 border border-gray-100 hover:border-indigo-100 transition flex gap-4 items-start">
                {{-- Icon: arrow-down-tray (pengganti emoji 📥) --}}
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7 shrink-0 text-indigo-600">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                </svg>
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
