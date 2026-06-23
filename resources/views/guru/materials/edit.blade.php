@extends('layouts.admin')

@section('content')
    <div class="max-w-3xl mx-auto">
        {{-- Header Halaman --}}
        <div class="mb-8">
            <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Edit Materi</h2>
            <p class="text-gray-500 mt-1 font-medium">Perbarui informasi, tautan, atau ubah status tayang materi ini.</p>
        </div>

        {{-- Form Card --}}
        <div class="bg-white rounded-[1.5rem] shadow-sm border border-gray-100 p-8">
            <form action="{{ route('guru.materials.update', $material) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Judul Materi --}}
                <div class="mb-6">
                    <label for="title" class="block text-sm font-bold text-gray-700 mb-2">
                        Judul Materi <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="title" id="title" value="{{ $material->title }}" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-rose-500 focus:ring-4 focus:ring-rose-50 outline-none transition bg-gray-50 focus:bg-white" placeholder="Contoh: Modul Matematika Bab 1" required>
                </div>

                {{-- URL Link Materi --}}
                <div class="mb-6">
                    <label for="link_url" class="block text-sm font-bold text-gray-700 mb-2">
                        URL Link Materi <span class="text-rose-500">*</span>
                    </label>
                    <input type="url" name="link_url" id="link_url" value="{{ $material->link_url }}" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-rose-500 focus:ring-4 focus:ring-rose-50 outline-none transition bg-gray-50 focus:bg-white" placeholder="https://youtube.com/..." required>
                </div>

                {{-- Deskripsi --}}
                <div class="mb-6">
                    <label for="description" class="block text-sm font-bold text-gray-700 mb-2">
                        Deskripsi (Opsional)
                    </label>
                    <textarea name="description" id="description" rows="4" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-rose-500 focus:ring-4 focus:ring-rose-50 outline-none transition bg-gray-50 focus:bg-white resize-none" placeholder="Berikan sedikit penjelasan tentang materi ini...">{{ $material->description }}</textarea>
                </div>

                {{-- Status Aktif (Checkbox) --}}
                <div class="mb-8 p-4 bg-gray-50 rounded-xl border border-gray-200 flex items-center gap-3 hover:bg-rose-50/50 transition cursor-pointer">
                    <input type="checkbox" name="is_active" id="is_active" value="1" class="w-5 h-5 accent-rose-600 cursor-pointer" {{ $material->is_active ? 'checked' : '' }}>
                    <label for="is_active" class="text-sm font-bold text-gray-700 cursor-pointer select-none flex-1">
                        Aktifkan Materi
                        <span class="block text-xs font-normal text-gray-500 mt-0.5">Jika dicentang, materi ini akan terlihat oleh siswa di halaman publik.</span>
                    </label>
                </div>

                {{-- Action Buttons --}}
                <div class="flex items-center gap-4 pt-6 border-t border-gray-100">
                    <button type="submit" class="inline-flex items-center justify-center bg-rose-600 text-white font-bold py-3 px-8 rounded-xl hover:bg-rose-700 transition shadow-sm hover:shadow-md">
                        Update Materi
                    </button>
                    <a href="{{ route('guru.materials.index') }}" class="inline-flex items-center justify-center bg-white text-gray-700 border border-gray-200 font-bold py-3 px-8 rounded-xl hover:bg-gray-50 transition shadow-sm">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
