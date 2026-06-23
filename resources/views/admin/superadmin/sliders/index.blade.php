@extends('layouts.admin')

@section('content')
    {{-- Header Halaman --}}
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Kelola Hero Slider</h2>
            <p class="text-gray-500 mt-1 font-medium">Atur gambar promosi yang tampil di halaman depan website.</p>
        </div>
        <div class="flex flex-wrap items-center gap-3">
            <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 bg-white text-gray-700 border border-gray-200 font-bold py-2.5 px-5 rounded-xl hover:bg-gray-50 transition shadow-sm text-sm">
                <span>⬅️</span> Kembali
            </a>
            <a href="{{ route('admin.superadmin.sliders.create') }}" class="inline-flex items-center gap-2 bg-slate-900 text-white font-bold py-2.5 px-5 rounded-xl hover:bg-slate-800 transition shadow-sm hover:shadow-md text-sm">
                <span>➕</span> Tambah Slider
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
                        <th class="px-6 py-5 text-xs font-extrabold text-gray-500 uppercase tracking-wider">Gambar</th>
                        <th class="px-6 py-5 text-xs font-extrabold text-gray-500 uppercase tracking-wider">Judul</th>
                        <th class="px-6 py-5 text-xs font-extrabold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-5 text-xs font-extrabold text-gray-500 uppercase tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($sliders as $slider)
                        <tr class="hover:bg-gray-50/50 transition duration-200">
                            <td class="px-6 py-4 text-sm font-bold text-gray-400">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4">
                                <div class="w-32 h-20 rounded-xl overflow-hidden border border-gray-100 shadow-sm">
                                    <img src="{{ Storage::url($slider->image_path) }}" alt="{{ $slider->title }}" class="w-full h-full object-cover">
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm font-bold text-gray-900">{{ $slider->title ?? '-' }}</td>
                            <td class="px-6 py-4">
                                @if($slider->is_active)
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
                                <a href="{{ route('admin.superadmin.sliders.edit', $slider->id) }}" class="inline-flex items-center justify-center px-3 py-1.5 bg-amber-50 text-amber-600 hover:bg-amber-100 rounded-lg text-sm font-bold transition">
                                    Edit
                                </a>
                                <form action="{{ route('admin.superadmin.sliders.destroy', $slider->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus slider ini?')">
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
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <span class="text-4xl mb-3">🖼️</span>
                                    <h3 class="text-lg font-bold text-gray-900">Belum ada slider</h3>
                                    <p class="text-gray-500 mt-1">Tambahkan gambar slider untuk mempercantik tampilan utama.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
