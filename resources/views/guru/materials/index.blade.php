@extends('layouts.admin')

@section('content')
    {{-- Header Halaman & Tombol Aksi --}}
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Kelola Materi</h2>
            <p class="text-gray-500 mt-1 font-medium">Tambah, edit, atau hapus materi yang Anda bagikan.</p>
        </div>
        <div class="flex flex-wrap items-center gap-3">
            <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 bg-white text-gray-700 border border-gray-200 font-bold py-2.5 px-4 rounded-xl hover:bg-gray-50 transition shadow-sm text-sm">
                <span>⬅️</span> Kembali
            </a>
            <a href="{{ route('guru.materials.create') }}" class="inline-flex items-center gap-2 bg-rose-600 text-white font-bold py-2.5 px-4 rounded-xl hover:bg-rose-700 transition shadow-sm hover:shadow-md text-sm">
                <span>➕</span> Tambah Materi
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
                        <th class="px-6 py-5 text-xs font-extrabold text-gray-500 uppercase tracking-wider w-7/12">Judul Materi</th>
                        <th class="px-6 py-5 text-xs font-extrabold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-5 text-xs font-extrabold text-gray-500 uppercase tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($materials as $material)
                        <tr class="hover:bg-gray-50/50 transition duration-200">
                            <td class="px-6 py-4">
                                <h4 class="text-sm font-bold text-gray-900 mb-1">{{ $material->title }}</h4>
                                <a href="{{ $material->link_url }}" target="_blank" rel="noopener noreferrer" class="text-xs text-rose-500 hover:text-rose-700 hover:underline break-all line-clamp-1" title="{{ $material->link_url }}">
                                    {{ $material->link_url }}
                                </a>
                            </td>
                            <td class="px-6 py-4">
                                @if($material->is_active)
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-emerald-50 text-emerald-700 text-xs font-bold border border-emerald-100">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-gray-100 text-gray-600 text-xs font-bold border border-gray-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span> Tidak Aktif
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right space-x-2 whitespace-nowrap">
                                <a href="{{ route('guru.materials.edit', $material) }}" class="inline-flex items-center justify-center px-3 py-1.5 bg-amber-50 text-amber-600 hover:bg-amber-100 rounded-lg text-sm font-bold transition">
                                    Edit
                                </a>
                                <form action="{{ route('guru.materials.destroy', $material) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus materi ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center justify-center px-3 py-1.5 bg-rose-50 text-rose-600 hover:bg-rose-100 rounded-lg text-sm font-bold transition">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <span class="text-4xl mb-3">📚</span>
                                    <h3 class="text-lg font-bold text-gray-900">Belum ada materi</h3>
                                    <p class="text-gray-500 mt-1">Anda belum menambahkan materi apa pun untuk siswa.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if ($materials->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
                {{ $materials->links() }}
            </div>
        @endif
    </div>
@endsection
