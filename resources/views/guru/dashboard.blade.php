@extends('layouts.admin')

@section('content')
    <div class="mb-8">
        <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Selamat Datang, {{ strtok(Auth::user()->name, " ") }}! 👋</h2>
        <p class="text-gray-500 mt-1 font-medium">Dashboard khusus Guru. Silakan pilih menu untuk memulai aktivitas Anda.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

        {{-- BAGIAN KIRI: MENU CEPAT --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-[1.5rem] shadow-sm p-8 border border-gray-100 flex flex-col md:flex-row gap-8 items-center md:items-start h-full">
                <div class="w-24 h-24 shrink-0 bg-rose-50 rounded-full flex items-center justify-center text-4xl">
                    📚
                </div>
                <div>
                    <h3 class="text-xl font-extrabold text-gray-900 mb-2">Materi Pembelajaran</h3>
                    <p class="text-gray-500 text-sm leading-relaxed mb-4">Tambahkan materi, tugas, atau bahan bacaan referensi untuk menunjang pembelajaran siswa Anda di sini.</p>
                    <a href="{{ route('guru.materials.index') }}" class="inline-block bg-rose-600 text-white font-bold py-2.5 px-6 rounded-xl hover:bg-rose-700 transition shadow-sm hover:shadow-md">
                        Kelola Materi
                    </a>
                </div>
            </div>
        </div>

        {{-- BAGIAN KANAN: WIDGET PINJAMAN ATAU KUTIPAN --}}
        <div class="flex flex-col h-full">

            @if(isset($borrowingInfo) && $borrowingInfo->isNotEmpty())
                {{-- JIKA SEDANG MEMINJAM BUKU: TAMPILKAN WIDGET PINJAMAN --}}
                <div class="bg-white rounded-[1.5rem] shadow-sm p-6 border border-gray-100 flex-1 flex flex-col">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-2">
                            <span class="text-xl">📖</span>
                            <h3 class="font-extrabold text-gray-900 text-lg">Sedang Dipinjam</h3>
                        </div>
                        <span class="bg-rose-100 text-rose-700 px-2.5 py-0.5 rounded-lg text-xs font-bold">
                            {{ $borrowingInfo->sum('count') }} Buku
                        </span>
                    </div>

                    <div class="space-y-3 overflow-y-auto pr-2 flex-1">
                        @foreach($borrowingInfo as $activeGroup)
                            <div class="flex gap-4 items-center bg-rose-50/50 p-3 rounded-xl border border-rose-50 hover:border-rose-200 transition">
                                <div class="w-16 h-24 shrink-0 rounded-lg overflow-hidden shadow-sm bg-gray-200">
                                    @if($activeGroup->book->cover_image)
                                        <img src="{{ asset('storage/' . $activeGroup->book->cover_image) }}" alt="Cover" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-xs text-gray-400 font-bold bg-gray-100 text-center px-1">NO COVER</div>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="font-bold text-gray-900 text-sm truncate mb-1" title="{{ $activeGroup->book->title }}">
                                        {{ $activeGroup->book->title }}
                                    </h4>
                                    <div class="text-[11px] text-gray-500 space-y-1">
                                        <p><span class="font-semibold text-gray-700">Jumlah:</span> {{ $activeGroup->count }} Eksemplar</p>
                                        @php
                                            $due = \Carbon\Carbon::parse($activeGroup->latest_due);
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

                    <a href="{{ route('borrow.history') }}" class="mt-4 block w-full text-center bg-rose-50 text-rose-600 font-bold py-2.5 rounded-xl hover:bg-rose-100 transition shadow-sm text-sm">
                        Lihat Riwayat Lengkap
                    </a>
                </div>

            @else
                {{-- JIKA TIDAK MEMINJAM BUKU: TAMPILKAN KUTIPAN --}}
                <div class="bg-white rounded-[1.5rem] shadow-sm p-8 border border-gray-100 flex-1 flex flex-col justify-center">
                    <div class="flex items-center gap-2 mb-6">
                        <span class="text-2xl">💡</span>
                        <h3 class="font-extrabold text-gray-900 text-xl">Kutipan Hari Ini</h3>
                    </div>
                    <div class="bg-rose-50 border-l-4 border-rose-500 p-5 rounded-r-xl mb-6">
                        <p class="text-sm font-medium italic text-gray-700 leading-relaxed">
                            "Membaca adalah jendela dunia. Semakin banyak membaca, semakin banyak kita tahu."
                        </p>
                        <p class="text-xs font-bold text-gray-500 mt-3">— Peribahasa</p>
                    </div>
                    <a href="{{ route('catalog.index') }}" class="block w-full text-center bg-emerald-500 text-white font-bold py-3 rounded-xl hover:bg-emerald-600 transition shadow-sm">
                        Mulai Membaca Buku
                    </a>
                </div>
            @endif

        </div>
    </div>

    {{-- BAWAH: INFORMASI PENTING --}}
    <div class="bg-white rounded-[1.5rem] shadow-sm p-8 border border-gray-100">
        <div class="flex items-center gap-3 mb-6">
            <span class="text-2xl">📢</span>
            <h3 class="text-xl font-extrabold text-gray-900">Informasi Penting</h3>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100 hover:border-rose-100 transition">
                <div class="flex gap-4">
                    <span class="text-2xl mt-1">👨‍🏫</span>
                    <div>
                        <h4 class="font-bold text-gray-900 mb-1">Update Data Guru</h4>
                        <p class="text-sm text-gray-500 leading-relaxed">
                            Pastikan mata pelajaran yang Anda ampu sudah sesuai. Silakan edit profil di <a href="{{ route('profile.edit') }}" class="text-rose-600 font-bold hover:underline">halaman profil Anda</a>.
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100 hover:border-rose-100 transition">
                <div class="flex gap-4">
                    <span class="text-2xl mt-1">📥</span>
                    <div>
                        <h4 class="font-bold text-gray-900 mb-1">Pengembalian Buku</h4>
                        <p class="text-sm text-gray-500 leading-relaxed">
                            Untuk mengembalikan buku, silakan datang langsung ke perpustakaan dan serahkan buku Anda kepada petugas yang berjaga.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
