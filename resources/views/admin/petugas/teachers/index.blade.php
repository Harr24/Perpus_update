@extends('layouts.admin')

@section('content')
    <div class="max-w-7xl mx-auto">

        {{-- Header Halaman --}}
        <div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Data Guru</h2>
                <p class="text-gray-500 mt-1 font-medium">Kelola seluruh akun guru yang terdaftar dalam sistem.</p>
            </div>
            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 bg-white text-gray-700 border border-gray-200 font-bold py-2.5 px-4 rounded-xl hover:bg-gray-50 transition shadow-sm text-sm">
                    <span>⬅️</span> Kembali
                </a>
                <a href="{{ route('admin.petugas.teachers.create') }}" class="inline-flex items-center gap-2 bg-emerald-600 text-white font-bold py-2.5 px-5 rounded-xl hover:bg-emerald-700 transition shadow-sm hover:shadow-md text-sm">
                    <span>➕</span> Tambah Guru
                </a>
            </div>
        </div>

        {{-- Alert Notifikasi --}}
        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 text-emerald-700 border border-emerald-100 rounded-xl font-bold flex items-center gap-3 shadow-sm">
                <span class="text-xl">✅</span> {{ session('success') }}
            </div>
        @endif

        {{-- Form Pencarian --}}
        <div class="bg-white p-4 sm:p-6 rounded-[1.5rem] shadow-sm border border-gray-100 mb-8 flex flex-col sm:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-3 w-full sm:w-auto">
                <span class="w-10 h-10 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg">👩‍🏫</span>
                <div>
                    <h3 class="font-bold text-gray-900">Total: {{ $teachers->total() }} Guru</h3>
                    <p class="text-xs text-gray-500">Terdaftar Aktif</p>
                </div>
            </div>

            <form action="{{ route('admin.petugas.teachers.index') }}" method="GET" class="w-full sm:w-auto flex">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau email..."
                       class="w-full sm:w-72 px-4 py-2.5 rounded-l-xl border border-gray-200 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-50 outline-none transition text-sm">
                <button type="submit" class="bg-slate-900 text-white font-bold py-2.5 px-5 rounded-r-xl hover:bg-slate-800 transition shadow-sm text-sm border border-transparent border-l-0">
                    Cari
                </button>
            </form>
        </div>

        {{-- Kontainer Data --}}
        <div class="bg-white rounded-[1.5rem] shadow-sm border border-gray-100 overflow-hidden">

            {{-- VIEW DESKTOP (Tabel) --}}
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-50/50 border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-5 text-xs font-extrabold text-gray-500 uppercase tracking-wider w-16">No</th>
                            <th class="px-6 py-5 text-xs font-extrabold text-gray-500 uppercase tracking-wider">Profil Guru</th>
                            <th class="px-6 py-5 text-xs font-extrabold text-gray-500 uppercase tracking-wider">Mata Pelajaran</th>
                            <th class="px-6 py-5 text-xs font-extrabold text-gray-500 uppercase tracking-wider text-center">Status</th>
                            <th class="px-6 py-5 text-xs font-extrabold text-gray-500 uppercase tracking-wider text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($teachers as $teacher)
                            <tr class="hover:bg-gray-50/50 transition duration-200">
                                <td class="px-6 py-4 text-sm font-bold text-gray-400">
                                    {{ $loop->iteration + $teachers->firstItem() - 1 }}
                                </td>

                                {{-- Profil --}}
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-slate-100 text-slate-600 flex items-center justify-center font-bold text-sm overflow-hidden shrink-0 border border-gray-200">
                                            @if($teacher->profile_photo_url)
                                                <img src="{{ $teacher->profile_photo_url }}" alt="{{ $teacher->name }}" class="w-full h-full object-cover">
                                            @else
                                                {{ strtoupper(substr($teacher->name, 0, 2)) }}
                                            @endif
                                        </div>
                                        <div>
                                            <h4 class="text-sm font-bold text-gray-900">{{ $teacher->name }}</h4>
                                            <p class="text-xs text-gray-500 mt-0.5">{{ $teacher->email }}</p>
                                        </div>
                                    </div>
                                </td>

                                {{-- Mata Pelajaran --}}
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-indigo-50 text-indigo-700 text-xs font-bold border border-indigo-100">
                                        <span>📘</span> {{ $teacher->subject ?? 'Belum Diatur' }}
                                    </span>
                                </td>

                                {{-- Status --}}
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-emerald-50 text-emerald-700 text-xs font-bold border border-emerald-100">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Aktif
                                    </span>
                                </td>

                                {{-- Aksi --}}
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('admin.petugas.teachers.edit', $teacher) }}" class="inline-flex items-center justify-center px-3 py-1.5 bg-amber-50 text-amber-600 hover:bg-amber-100 rounded-lg text-xs font-bold transition border border-amber-100">
                                        Edit
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <span class="text-5xl mb-4">📭</span>
                                        @if(request('search'))
                                            <h3 class="text-lg font-bold text-gray-900">Guru Tidak Ditemukan</h3>
                                            <p class="text-gray-500 mt-1 mb-4">Tidak ada guru yang cocok dengan kata kunci "{{ request('search') }}".</p>
                                            <a href="{{ route('admin.petugas.teachers.index') }}" class="text-emerald-600 font-bold hover:underline">Tampilkan Semua</a>
                                        @else
                                            <h3 class="text-lg font-bold text-gray-900">Belum Ada Data Guru</h3>
                                            <p class="text-gray-500 mt-1 mb-4">Silakan tambahkan akun guru terlebih dahulu ke dalam sistem.</p>
                                            <a href="{{ route('admin.petugas.teachers.create') }}" class="inline-flex items-center gap-2 bg-emerald-600 text-white font-bold py-2.5 px-5 rounded-xl hover:bg-emerald-700 transition shadow-sm">
                                                Tambah Guru Sekarang
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- VIEW MOBILE (Cards) --}}
            <div class="md:hidden p-4 space-y-4">
                @forelse ($teachers as $teacher)
                    <div class="p-4 rounded-xl border border-gray-100 bg-gray-50/50 shadow-sm relative">
                        <div class="absolute top-4 right-4">
                            <span class="text-xs font-bold text-gray-400">#{{ $loop->iteration + $teachers->firstItem() - 1 }}</span>
                        </div>

                        <div class="flex items-center gap-3 mb-4 pr-6">
                            <div class="w-12 h-12 rounded-full bg-slate-100 text-slate-600 flex items-center justify-center font-bold text-sm overflow-hidden shrink-0 border border-gray-200">
                                @if($teacher->profile_photo_url)
                                    <img src="{{ $teacher->profile_photo_url }}" alt="{{ $teacher->name }}" class="w-full h-full object-cover">
                                @else
                                    {{ strtoupper(substr($teacher->name, 0, 2)) }}
                                @endif
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-gray-900">{{ $teacher->name }}</h4>
                                <span class="inline-flex items-center gap-1 mt-1 px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-50 text-emerald-700">
                                    <span class="w-1 h-1 rounded-full bg-emerald-500"></span> Aktif
                                </span>
                            </div>
                        </div>

                        <div class="space-y-2 mb-4 text-sm">
                            <div class="flex justify-between items-center border-t border-dashed border-gray-200 pt-2">
                                <span class="text-gray-500 font-medium">Email</span>
                                <span class="font-bold text-gray-900 truncate pl-4">{{ $teacher->email }}</span>
                            </div>
                            <div class="flex justify-between items-center border-t border-dashed border-gray-200 pt-2">
                                <span class="text-gray-500 font-medium">Mata Pelajaran</span>
                                <span class="font-bold text-indigo-700 bg-indigo-50 px-2 py-0.5 rounded text-xs">{{ $teacher->subject ?? '-' }}</span>
                            </div>
                        </div>

                        <div class="border-t border-gray-200 pt-4 flex justify-end">
                            <a href="{{ route('admin.petugas.teachers.edit', $teacher) }}" class="inline-flex items-center justify-center px-4 py-2 bg-amber-50 text-amber-600 hover:bg-amber-100 rounded-xl text-sm font-bold transition w-full">
                                Edit Guru
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-10">
                        <span class="text-4xl mb-3 block">📭</span>
                        <h3 class="text-base font-bold text-gray-900">Belum ada data</h3>
                        <p class="text-sm text-gray-500 mt-1">Data guru belum tersedia.</p>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            @if($teachers->hasPages())
                <div class="p-6 border-t border-gray-100">
                    {{ $teachers->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
