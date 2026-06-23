@extends('layouts.admin')

@section('content')
    <div class="max-w-7xl mx-auto">

        {{-- Header Halaman --}}
        <div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Tambah Genre Baru</h2>
                <p class="text-gray-500 mt-1 font-medium">Tambahkan kategori atau genre buku baru ke dalam sistem perpustakaan.</p>
            </div>
            <a href="{{ route('admin.petugas.genres.index') }}" class="inline-flex items-center gap-2 bg-white text-gray-700 border border-gray-200 font-bold py-2.5 px-5 rounded-xl hover:bg-gray-50 transition shadow-sm text-sm">
                <span>⬅️</span> Kembali
            </a>
        </div>

        {{-- Alert Error Validasi --}}
        @if($errors->any())
            <div class="mb-6 p-5 bg-rose-50 border border-rose-100 rounded-xl shadow-sm">
                <div class="flex items-center gap-2 mb-2 font-bold text-rose-700">
                    <span class="text-xl">⚠️</span> Terdapat Kesalahan!
                </div>
                <ul class="list-disc list-inside text-sm font-medium text-rose-600 pl-2 space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- KOLOM KIRI: FORM UTAMA --}}
            <div class="lg:col-span-2">
                <div class="bg-white rounded-[1.5rem] shadow-sm border border-gray-100 p-6 sm:p-8">

                    <form action="{{ route('admin.petugas.genres.store') }}" method="POST" enctype="multipart/form-data" id="create-genre-form">
                        @csrf

                        <div class="space-y-6 mb-8">
                            {{-- Kode & Nama Genre (Grid) --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="genre_code" class="block text-sm font-bold text-gray-700 mb-2">Kode Genre (DDC) <span class="text-rose-500">*</span></label>
                                    <input type="text" id="genre_code" name="genre_code" value="{{ old('genre_code') }}" required
                                           placeholder="Contoh: 800"
                                           class="w-full px-4 py-3 rounded-xl border @error('genre_code') border-rose-500 ring-rose-50 @else border-gray-200 focus:border-emerald-500 focus:ring-emerald-50 @enderror focus:ring-4 outline-none transition bg-gray-50 focus:bg-white font-mono">
                                    @error('genre_code') <p class="mt-2 text-xs font-bold text-rose-500">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label for="name" class="block text-sm font-bold text-gray-700 mb-2">Nama Genre <span class="text-rose-500">*</span></label>
                                    <input type="text" id="name" name="name" value="{{ old('name') }}" required
                                           placeholder="Contoh: Fiksi Klasik"
                                           class="w-full px-4 py-3 rounded-xl border @error('name') border-rose-500 ring-rose-50 @else border-gray-200 focus:border-emerald-500 focus:ring-emerald-50 @enderror focus:ring-4 outline-none transition bg-gray-50 focus:bg-white">
                                    @error('name') <p class="mt-2 text-xs font-bold text-rose-500">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div class="h-px bg-gray-100 my-4"></div>

                            {{-- Upload Ikon --}}
                            <div>
                                <label for="icon" class="block text-sm font-bold text-gray-700 mb-2">Ikon Kategori <span class="text-xs font-medium text-gray-500 ml-1">(Opsional)</span></label>

                                <input type="file" id="icon" name="icon" accept="image/*"
                                       class="block w-full text-sm text-gray-500 file:mr-3 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 cursor-pointer border border-gray-200 rounded-xl p-1 transition @error('icon') border-rose-500 @enderror bg-white">
                                <p class="mt-2 text-[10px] text-gray-400 font-bold uppercase tracking-widest">Rekomendasi: Format PNG / SVG transparan. (Max 2MB).</p>
                                @error('icon') <p class="mt-2 text-xs font-bold text-rose-500">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        {{-- Tombol Submit --}}
                        <div class="flex items-center gap-4 pt-6 border-t border-gray-100">
                            <button type="submit" class="inline-flex items-center justify-center bg-emerald-600 text-white font-bold py-3 px-8 rounded-xl hover:bg-emerald-700 transition shadow-sm hover:shadow-md text-sm">
                                Simpan Genre
                            </button>
                            <a href="{{ route('admin.petugas.genres.index') }}" class="inline-flex items-center justify-center bg-white text-gray-700 border border-gray-200 font-bold py-3 px-8 rounded-xl hover:bg-gray-50 transition shadow-sm text-sm">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            {{-- KOLOM KANAN: SIDEBAR INFO --}}
            <div class="lg:col-span-1 space-y-6">

                {{-- Petunjuk --}}
                <div class="bg-slate-900 rounded-[1.5rem] shadow-sm border border-slate-800 p-6 text-slate-300">
                    <h6 class="mb-4 font-extrabold text-white flex items-center gap-2">
                        <span class="text-amber-400">💡</span> Petunjuk Pengisian
                    </h6>
                    <ul class="space-y-4 text-sm font-medium">
                        <li class="flex gap-3">
                            <span class="text-emerald-400 shrink-0">✓</span>
                            <div>
                                <span class="text-white font-bold block mb-1">Kode DDC</span>
                                <span>Gunakan sistem klasifikasi desimal Dewey. Contoh: <strong>000</strong> (Komputer), <strong>800</strong> (Sastra).</span>
                            </div>
                        </li>
                        <li class="flex gap-3">
                            <span class="text-emerald-400 shrink-0">✓</span>
                            <div>
                                <span class="text-white font-bold block mb-1">Keunikan Data</span>
                                <span>Pastikan Nama Genre dan Kode DDC belum pernah ditambahkan sebelumnya untuk menghindari duplikasi.</span>
                            </div>
                        </li>
                        <li class="flex gap-3">
                            <span class="text-sky-400 shrink-0">🖼️</span>
                            <div>
                                <span class="text-white font-bold block mb-1">Ikon Visal</span>
                                <span>Ikon akan ditampilkan di katalog buku publik. Gunakan gambar dengan resolusi kotak (1:1) berlatar belakang transparan agar lebih rapi.</span>
                            </div>
                        </li>
                    </ul>
                </div>

            </div>

        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('create-genre-form');

            if (form) {
                form.addEventListener('submit', function (event) {
                    event.preventDefault();

                    Swal.fire({
                        title: 'Simpan Genre?',
                        text: "Pastikan kode DDC dan nama genre sudah sesuai.",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#059669', // Emerald-600
                        cancelButtonColor: '#6b7280',  // Gray-500
                        confirmButtonText: 'Ya, Simpan!',
                        cancelButtonText: 'Batal',
                        borderRadius: '1.5rem'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            }
        });
    </script>
@endpush
