@extends('layouts.admin')

@section('content')
    <div class="max-w-3xl mx-auto">

        {{-- Header --}}
        <div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Tambah Slider Baru</h2>
                <p class="text-gray-500 mt-1 font-medium">Unggah gambar baru untuk hero slider di halaman utama.</p>
            </div>
            <a href="{{ route('admin.superadmin.sliders.index') }}" class="inline-flex items-center gap-2 bg-white text-gray-700 border border-gray-200 font-bold py-2.5 px-5 rounded-xl hover:bg-gray-50 transition shadow-sm text-sm">
                <span>⬅️</span> Kembali
            </a>
        </div>

        {{-- Form Card --}}
        <div class="bg-white rounded-[1.5rem] shadow-sm border border-gray-100 p-8">
            <form action="{{ route('admin.superadmin.sliders.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Judul & Deskripsi --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="title" class="block text-sm font-bold text-gray-700 mb-2">Judul (Opsional)</label>
                        <input type="text" id="title" name="title" value="{{ old('title') }}"
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-slate-500 focus:ring-4 focus:ring-slate-50 outline-none transition bg-gray-50 focus:bg-white" placeholder="Contoh: Sambutan Kepala Sekolah">
                    </div>
                    <div>
                        <label for="order" class="block text-sm font-bold text-gray-700 mb-2">Urutan Tampil</label>
                        <input type="number" id="order" name="order" value="{{ old('order', 0) }}"
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-slate-500 focus:ring-4 focus:ring-slate-50 outline-none transition bg-gray-50 focus:bg-white">
                    </div>
                </div>

                <div class="mb-6">
                    <label for="description" class="block text-sm font-bold text-gray-700 mb-2">Deskripsi (Opsional)</label>
                    <textarea id="description" name="description" rows="3"
                              class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-slate-500 focus:ring-4 focus:ring-slate-50 outline-none transition bg-gray-50 focus:bg-white resize-none" placeholder="Teks penjelasan singkat..."></textarea>
                </div>

                {{-- File & Link --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="image_path" class="block text-sm font-bold text-gray-700 mb-2">Gambar Slider <span class="text-rose-500">*</span></label>
                        <input type="file" id="image_path" name="image_path" accept="image/*" required
                               class="block w-full text-sm text-gray-500 file:mr-3 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200 cursor-pointer border border-gray-200 rounded-xl p-1 transition @error('image_path') border-rose-500 @enderror">
                        <p class="mt-1.5 text-[10px] text-gray-400 font-bold uppercase tracking-widest">Rekomendasi: 1920x1080px (Max 2MB).</p>
                    </div>
                    <div>
                        <label for="link_url" class="block text-sm font-bold text-gray-700 mb-2">URL Link (Opsional)</label>
                        <input type="url" id="link_url" name="link_url" value="{{ old('link_url') }}" placeholder="https://..."
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-slate-500 focus:ring-4 focus:ring-slate-50 outline-none transition bg-gray-50 focus:bg-white">
                    </div>
                </div>

                {{-- Status --}}
                <div class="mb-8">
                    <label for="is_active" class="block text-sm font-bold text-gray-700 mb-2">Status Slider</label>
                    <select id="is_active" name="is_active"
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-slate-500 focus:ring-4 focus:ring-slate-50 outline-none transition bg-gray-50 focus:bg-white cursor-pointer font-bold text-gray-700">
                        <option value="1" {{ old('is_active', 1) == 1 ? 'selected' : '' }}>Aktif (Tampilkan)</option>
                        <option value="0" {{ old('is_active') == 0 ? 'selected' : '' }}>Nonaktif (Sembunyikan)</option>
                    </select>
                </div>

                {{-- Tombol Aksi --}}
                <div class="flex items-center gap-4 pt-6 border-t border-gray-100">
                    <button type="submit" class="inline-flex items-center justify-center bg-slate-900 text-white font-bold py-3 px-8 rounded-xl hover:bg-slate-800 transition shadow-sm hover:shadow-md text-sm">
                        Simpan Slider
                    </button>
                    <a href="{{ route('admin.superadmin.sliders.index') }}" class="inline-flex items-center justify-center bg-white text-gray-700 border border-gray-200 font-bold py-3 px-8 rounded-xl hover:bg-gray-50 transition shadow-sm text-sm">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
