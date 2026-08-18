@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-8">
        <h2 class="text-3xl font-extrabold text-gray-900 flex items-center gap-3">
            {{-- Heroicon: Bolt (Petir) --}}
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-8 h-8 text-emerald-500">
                <path stroke-linecap="round" stroke-linejoin="round" d="m3.75 13.5 10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75Z" />
            </svg>
            Peminjaman Ekspres
        </h2>
        <p class="text-gray-500 mt-2 font-medium">Tahap 1: Cari dan pilih anggota yang akan meminjam buku di meja layanan.</p>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 text-emerald-700 rounded-2xl font-bold flex items-center gap-3 shadow-sm border border-emerald-100">
            {{-- Heroicon: Check Circle --}}
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-6 shrink-0">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-[1.5rem] shadow-sm border border-gray-100 p-8">
        <form action="{{ route('admin.petugas.direct_borrow.create') }}" method="GET" class="mb-8">
            <label class="block text-sm font-extrabold text-gray-900 uppercase tracking-wider mb-4">Pencarian Anggota</label>
            <div class="flex gap-3">
                <div class="relative flex-1">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                        {{-- Heroicon: Magnifying Glass (di dalam input) --}}
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-gray-400">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ $search }}" placeholder="Ketik nama anggota..." class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-base rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block pl-11 p-4 shadow-sm" required autofocus>
                </div>

                <button type="submit" class="bg-emerald-600 text-white font-bold py-4 px-8 rounded-xl hover:bg-emerald-700 transition shadow-md shadow-emerald-200 flex items-center gap-2">
                    Cari
                </button>
            </div>
        </form>

        @if($search)
            <div class="space-y-4">
                <h3 class="text-sm font-bold text-gray-400 mb-4 uppercase tracking-wider border-b border-gray-100 pb-2">Hasil Pencarian untuk: "{{ $search }}"</h3>

                @forelse($members as $m)
                    <a href="{{ route('admin.petugas.direct_borrow.select_books', $m->id) }}" class="flex items-center gap-5 p-4 rounded-xl border border-gray-100 hover:border-emerald-300 hover:bg-emerald-50 hover:shadow-sm transition cursor-pointer group">

                        {{-- Foto Profil --}}
                        <div class="shrink-0">
                            @if($m->profile_photo)
                                <img src="{{ asset('storage/' . $m->profile_photo) }}" class="w-14 h-14 rounded-full object-cover border-2 border-white shadow-sm">
                            @else
                                <div class="w-14 h-14 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 font-extrabold text-xl shadow-sm border-2 border-white">
                                    {{ strtoupper(substr($m->name, 0, 2)) }}
                                </div>
                            @endif
                        </div>

                        {{-- Info Anggota --}}
                        <div class="flex-1">
                            <h4 class="font-extrabold text-gray-900 text-lg group-hover:text-emerald-700 transition">{{ $m->name }}</h4>
                            <div class="flex gap-3 mt-1 text-sm font-medium text-gray-500">
                                <span class="bg-gray-100 px-2 py-0.5 rounded text-gray-700 font-bold uppercase text-[10px]">{{ $m->role }}</span>

                                @if($m->role == 'siswa')
                                    <span>NIS: {{ $m->nis ?? '-' }}</span>
                                    <span>•</span>
                                    <span>Kelas: {{ $m->class ?? $m->class_name ?? '-' }} {{ $m->major ?? '' }}</span>
                                @elseif($m->role == 'guru')
                                    <span>Mapel: {{ $m->subject ?? '-' }}</span>
                                    <span>•</span>
                                    <span>No HP: {{ $m->phone_number ?? '-' }}</span>
                                @else
                                    <span>Petugas Perpustakaan</span>
                                @endif

                            </div>
                        </div>

                        <div class="shrink-0 text-emerald-600 opacity-0 group-hover:opacity-100 transition transform group-hover:translate-x-1 flex items-center gap-1 font-bold">
                            Pilih
                            {{-- Heroicon: Arrow Right --}}
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                            </svg>
                        </div>
                    </a>
                @empty
                    <div class="text-center p-8 bg-rose-50 rounded-xl border border-dashed border-rose-200">
                        {{-- Heroicon: User Minus --}}
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-14 h-14 mx-auto mb-3 text-rose-300">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M22 10.5h-6m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM4 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 10.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
                        </svg>
                        <p class="text-rose-600 font-bold text-lg">Anggota tidak ditemukan.</p>
                        <p class="text-sm text-rose-500 mt-1">Coba gunakan kata kunci nama atau nomor induk yang lain.</p>
                    </div>
                @endforelse
            </div>
        @else
            <div class="text-center p-12 bg-gray-50 rounded-xl border border-dashed border-gray-200">
                {{-- Heroicon: Users --}}
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-16 h-16 mx-auto mb-4 text-gray-300">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                </svg>
                <h3 class="text-gray-500 font-bold text-lg">Cari Anggota Terlebih Dahulu</h3>
                <p class="text-sm text-gray-400 mt-1">Gunakan kolom pencarian di atas untuk memulai transaksi sirkulasi.</p>
            </div>
        @endif
    </div>
</div>
@endsection
