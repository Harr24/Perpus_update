@extends('layouts.admin')

@section('content')
    <div class="max-w-3xl mx-auto">
        {{-- Header Halaman --}}
        <div class="mb-8">
            <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Tambah Materi Baru</h2>
            <p class="text-gray-500 mt-1 font-medium">Bagikan referensi belajar atau tautan video untuk siswa Anda.</p>
        </div>

        {{-- Form Card --}}
        <div class="bg-white rounded-[1.5rem] shadow-sm border border-gray-100 p-8">
            <form action="{{ route('guru.materials.store') }}" method="POST">
                @csrf

                {{-- Judul Materi --}}
                <div class="mb-6">
                    <label for="title" class="block text-sm font-bold text-gray-700 mb-2">
                        Judul Materi <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="title" id="title" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-rose-500 focus:ring-4 focus:ring-rose-50 outline-none transition bg-gray-50 focus:bg-white" placeholder="Contoh: Modul Matematika Bab 1" required>
                </div>

                {{-- URL Link Materi --}}
                <div class="mb-6">
                    <label for="link_url" class="block text-sm font-bold text-gray-700 mb-2">
                        URL Link Materi <span class="text-rose-500">*</span>
                    </label>
                    <input type="url" name="link_url" id="link_url" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-rose-500 focus:ring-4 focus:ring-rose-50 outline-none transition bg-gray-50 focus:bg-white" placeholder="https://youtube.com/..." required>
                </div>

                {{-- Deskripsi --}}
                <div class="mb-8">
                    <label for="description" class="block text-sm font-bold text-gray-700 mb-2">
                        Deskripsi (Opsional)
                    </label>
                    <textarea name="description" id="description" rows="4" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-rose-500 focus:ring-4 focus:ring-rose-50 outline-none transition bg-gray-50 focus:bg-white resize-none" placeholder="Berikan sedikit penjelasan tentang materi ini..."></textarea>
                </div>

                {{-- Action Buttons --}}
                <div class="flex items-center gap-4 pt-6 border-t border-gray-100">
                    <button type="submit" class="inline-flex items-center justify-center bg-rose-600 text-white font-bold py-3 px-8 rounded-xl hover:bg-rose-700 transition shadow-sm hover:shadow-md">
                        Simpan Materi
                    </button>
                    <a href="{{ route('guru.materials.index') }}" class="inline-flex items-center justify-center bg-white text-gray-700 border border-gray-200 font-bold py-3 px-8 rounded-xl hover:bg-gray-50 transition shadow-sm">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
