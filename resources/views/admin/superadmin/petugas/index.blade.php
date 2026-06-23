@extends('layouts.admin')

@section('content')
    {{-- Header Halaman & Tombol Aksi --}}
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Kelola Akun Petugas</h2>
            <p class="text-gray-500 mt-1 font-medium">Atur akun petugas dan superadmin yang memiliki akses ke sistem.</p>
        </div>
        <div class="flex flex-wrap items-center gap-3">
            <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 bg-white text-gray-700 border border-gray-200 font-bold py-2.5 px-4 rounded-xl hover:bg-gray-50 transition shadow-sm text-sm">
                <span>⬅️</span> Kembali
            </a>
            <a href="{{ route('admin.superadmin.petugas.create') }}" class="inline-flex items-center gap-2 bg-slate-900 text-white font-bold py-2.5 px-4 rounded-xl hover:bg-slate-800 transition shadow-sm hover:shadow-md text-sm">
                <span>➕</span> Tambah Akun
            </a>
        </div>
    </div>

    {{-- Alert Notifikasi --}}
    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 text-emerald-700 border border-emerald-100 rounded-xl font-bold flex items-center gap-3">
            <span class="text-xl">✅</span> {{ session('success') }}
        </div>
    @endif

    {{-- Kontainer Tabel --}}
    <div class="bg-white rounded-[1.5rem] shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50/50 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-5 text-xs font-extrabold text-gray-500 uppercase tracking-wider w-16">No</th>
                        <th class="px-6 py-5 text-xs font-extrabold text-gray-500 uppercase tracking-wider">Info Akun</th>
                        <th class="px-6 py-5 text-xs font-extrabold text-gray-500 uppercase tracking-wider">Role Hak Akses</th>
                        <th class="px-6 py-5 text-xs font-extrabold text-gray-500 uppercase tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($petugas as $akun)
                        <tr class="hover:bg-gray-50/50 transition duration-200">

                            {{-- Kolom No --}}
                            <td class="px-6 py-4 text-sm font-bold text-gray-400">
                                {{ $loop->iteration }}
                            </td>

                            {{-- Kolom Info Akun (Nama & Email digabung biar rapi) --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-slate-100 text-slate-600 flex items-center justify-center font-bold text-sm overflow-hidden shrink-0">
                                        @if($akun->profile_photo)
                                            <img src="{{ Storage::url($akun->profile_photo) }}" class="w-full h-full object-cover">
                                        @else
                                            {{ strtoupper(substr($akun->name, 0, 2)) }}
                                        @endif
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-bold text-gray-900">{{ $akun->name }}</h4>
                                        <p class="text-xs text-gray-500">{{ $akun->email }}</p>
                                    </div>
                                </div>
                            </td>

                            {{-- Kolom Role --}}
                            <td class="px-6 py-4">
                                @if($akun->role === 'superadmin')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-slate-100 text-slate-800 text-xs font-bold border border-slate-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-slate-600"></span> Superadmin
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-emerald-50 text-emerald-700 text-xs font-bold border border-emerald-100">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Petugas
                                    </span>
                                @endif
                            </td>

                            {{-- Kolom Aksi --}}
                            <td class="px-6 py-4 text-right space-x-2 whitespace-nowrap">
                                <a href="{{ route('admin.superadmin.petugas.edit', $akun->id) }}" class="inline-flex items-center justify-center px-3 py-1.5 bg-amber-50 text-amber-600 hover:bg-amber-100 rounded-lg text-sm font-bold transition">
                                    Edit
                                </a>

                                {{-- Cegah Superadmin menghapus dirinya sendiri --}}
                                @if(auth()->id() !== $akun->id)
                                    <form action="{{ route('admin.superadmin.petugas.destroy', $akun->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus akun {{ $akun->name }}?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center justify-center px-3 py-1.5 bg-rose-50 text-rose-600 hover:bg-rose-100 rounded-lg text-sm font-bold transition">
                                            Hapus
                                        </button>
                                    </form>
                                @else
                                    <button disabled class="inline-flex items-center justify-center px-3 py-1.5 bg-gray-100 text-gray-400 rounded-lg text-sm font-bold cursor-not-allowed" title="Anda tidak bisa menghapus akun Anda sendiri">
                                        Hapus
                                    </button>
                                @endif
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <span class="text-4xl mb-3">👮</span>
                                    <h3 class="text-lg font-bold text-gray-900">Belum ada data</h3>
                                    <p class="text-gray-500 mt-1">Belum ada akun petugas atau superadmin yang didaftarkan.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
