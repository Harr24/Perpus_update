@extends('layouts.admin')

@section('content')
    <div class="max-w-3xl mx-auto">

        {{-- Header --}}
        <div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Edit Slider</h2>
                <p class="text-gray-500 mt-1 font-medium">Perbarui gambar dan konten slider untuk halaman depan.</p>
            </div>
            <a href="{{ route('admin.superadmin.sliders.index') }}" class="inline-flex items-center gap-2 bg-white text-gray-700 border border-gray-200 font-bold py-2.5 px-5 rounded-xl hover:bg-gray-50 transition shadow-sm text-sm">
                <span>⬅️</span> Kembali
            </a>
        </div>

        {{-- Form Card --}}
        <div class="bg-white rounded-[1.5rem] shadow-sm border border-gray-100 p-8">
            <form action="{{ route('admin.superadmin.sliders.update', $slider->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Preview Gambar --}}
                <div class="mb-8">
                    <label class="block text-sm font-bold text-gray-700 mb-3">Gambar Saat Ini</label>
                    <div class="w-full h-64 rounded-2xl overflow-hidden border-4 border-white shadow-lg">
                        <img src="{{ Storage::url($slider->image_path) }}" alt="Slider" class="w-full h-full object-cover">
                    </div>
                </div>

                {{-- Judul & Deskripsi --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="title" class="block text-sm font-bold text-gray-700 mb-2">Judul (Opsional)</label>
                        <input type="text" id="title" name="title" value="{{ old('title', $slider->title) }}"
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-slate-500 focus:ring-4 focus:ring-slate-50 outline-none transition bg-gray-50 focus:bg-white">
                    </div>
                    <div>
                        <label for="order" class="block text-sm font-bold text-gray-700 mb-2">Urutan Tampil</label>
                        <input type="number" id="order" name="order" value="{{ old('order', $slider->order) }}"
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-slate-500 focus:ring-4 focus:ring-slate-50 outline-none transition bg-gray-50 focus:bg-white">
                    </div>
                </div>

                <div class="mb-6">
                    <label for="description" class="block text-sm font-bold text-gray-700 mb-2">Deskripsi (Opsional)</label>
                    <textarea id="description" name="description" rows="3"
                              class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-slate-500 focus:ring-4 focus:ring-slate-50 outline-none transition bg-gray-50 focus:bg-white resize-none">{{ old('description', $slider->description) }}</textarea>
                </div>

                {{-- File & Link --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="image_path" class="block text-sm font-bold text-gray-700 mb-2">Ganti Gambar</label>
                        <input type="file" id="image_path" name="image_path" accept="image/*"
                               class="block w-full text-sm text-gray-500 file:mr-3 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200 cursor-pointer border border-gray-200 rounded-xl p-1 transition">
                        <p class="mt-1.5 text-[10px] text-gray-400 font-bold uppercase tracking-widest">Kosongkan jika tidak ingin mengubah gambar.</p>
                    </div>
                    <div>
                        <label for="link_url" class="block text-sm font-bold text-gray-700 mb-2">URL Link (Opsional)</label>
                        <input type="url" id="link_url" name="link_url" value="{{ old('link_url', $slider->link_url) }}" placeholder="https://..."
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-slate-500 focus:ring-4 focus:ring-slate-50 outline-none transition bg-gray-50 focus:bg-white">
                    </div>
                </div>

                {{-- Status Aktif --}}
                <div class="mb-8 p-4 bg-gray-50 rounded-xl border border-gray-200 flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="is_active" id="is_active" value="1" class="w-5 h-5 accent-slate-900 cursor-pointer" {{ $slider->is_active ? 'checked' : '' }}>
                    <label for="is_active" class="text-sm font-bold text-gray-700 cursor-pointer select-none">Aktifkan Slider</label>
                </div>

                {{-- Tombol Aksi --}}
                <div class="flex items-center gap-4 pt-6 border-t border-gray-100">
                    <button type="submit" class="inline-flex items-center justify-center bg-slate-900 text-white font-bold py-3 px-8 rounded-xl hover:bg-slate-800 transition shadow-sm hover:shadow-md text-sm">
                        Update Slider
                    </button>
                    <a href="{{ route('admin.superadmin.sliders.index') }}" class="inline-flex items-center justify-center bg-white text-gray-700 border border-gray-200 font-bold py-3 px-8 rounded-xl hover:bg-gray-50 transition shadow-sm text-sm">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
