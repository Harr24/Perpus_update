@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-8">
        <h2 class="text-3xl font-extrabold text-gray-900 flex items-center gap-3">
            <span class="text-emerald-500">⚡</span> Peminjaman Ekspres
        </h2>
        <p class="text-gray-500 mt-2 font-medium">Tahap 1: Cari dan pilih anggota yang akan meminjam buku di meja layanan.</p>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 text-emerald-700 rounded-2xl font-bold flex items-center gap-3 shadow-sm border border-emerald-100">
            <span class="text-xl">✅</span> {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-[1.5rem] shadow-sm border border-gray-100 p-8">
        <form action="{{ route('admin.petugas.direct_borrow.create') }}" method="GET" class="mb-8">
            <label class="block text-sm font-extrabold text-gray-900 uppercase tracking-wider mb-4">Pencarian Anggota</label>
            <div class="flex gap-3">
                <input type="text" name="search" value="{{ $search }}" placeholder="Ketik nama.." class="flex-1 bg-gray-50 border border-gray-200 text-gray-900 text-base rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block p-4 shadow-sm" required autofocus>
                <button type="submit" class="bg-emerald-600 text-white font-bold py-4 px-8 rounded-xl hover:bg-emerald-700 transition shadow-md shadow-emerald-200">
                    Cari 🔍
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

                                {{-- PERBAIKAN DI SINI --}}
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

                        <div class="shrink-0 text-emerald-600 opacity-0 group-hover:opacity-100 transition transform group-hover:translate-x-1">
                            Pilih 👉
                        </div>
                    </a>
                @empty
                    <div class="text-center p-8 bg-rose-50 rounded-xl border border-dashed border-rose-200">
                        <span class="text-3xl block mb-2">🤷‍♂️</span>
                        <p class="text-rose-600 font-bold">Anggota tidak ditemukan.</p>
                        <p class="text-sm text-rose-500 mt-1">Coba gunakan kata kunci nama atau nomor induk yang lain.</p>
                    </div>
                @endforelse
            </div>
        @else
            <div class="text-center p-12 bg-gray-50 rounded-xl border border-dashed border-gray-200">
                <span class="text-4xl block mb-3 opacity-50">👥</span>
                <h3 class="text-gray-500 font-bold">Cari Anggota Terlebih Dahulu</h3>
                <p class="text-sm text-gray-400 mt-1">Gunakan kolom pencarian di atas untuk memulai transaksi sirkulasi.</p>
            </div>
        @endif
    </div>
</div>
@endsection
