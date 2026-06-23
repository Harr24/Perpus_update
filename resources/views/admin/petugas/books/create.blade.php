@extends('layouts.admin')

@section('content')
    <div class="max-w-7xl mx-auto">

        {{-- Header Halaman --}}
        <div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Tambah Buku Baru</h2>
                <p class="text-gray-500 mt-1 font-medium">Masukkan data buku baru beserta alokasi stok dan penyimpanannya.</p>
            </div>
            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('admin.petugas.books.index') }}" class="inline-flex items-center gap-2 bg-white text-gray-700 border border-gray-200 font-bold py-2.5 px-5 rounded-xl hover:bg-gray-50 transition shadow-sm text-sm">
                    <span>⬅️</span> Kembali
                </a>
            </div>
        </div>

        {{-- Alert Error Validasi General --}}
        @if ($errors->any() && !$errors->has('books.*'))
            <div class="mb-6 p-5 bg-rose-50 border border-rose-100 rounded-xl shadow-sm">
                <div class="flex items-center gap-2 mb-2 font-bold text-rose-700">
                    <span class="text-xl">⚠️</span> Validasi Gagal!
                </div>
                <ul class="list-disc list-inside text-sm font-medium text-rose-600 pl-2 space-y-1">
                    @foreach ($errors->all() as $error)
                        @if (!Str::startsWith($error, 'books.'))
                            <li>{{ $error }}</li>
                        @endif
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.petugas.books.store') }}" method="POST" enctype="multipart/form-data" id="create-book-form">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- KOLOM KIRI: INFORMASI UTAMA BUKU --}}
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white rounded-[1.5rem] shadow-sm border border-gray-100 p-6 sm:p-8">
                        <h3 class="text-lg font-extrabold text-gray-900 mb-6 flex items-center gap-2">
                            <span>📖</span> Detail Buku
                        </h3>

                        <div class="space-y-6">
                            {{-- Judul Buku --}}
                            <div>
                                <label for="title" class="block text-sm font-bold text-gray-700 mb-2">Judul Buku <span class="text-rose-500">*</span></label>
                                <input type="text" id="title" name="title" value="{{ old('title') }}" required
                                       placeholder="Masukkan judul lengkap buku..."
                                       class="w-full px-4 py-3 rounded-xl border @error('title') border-rose-500 ring-rose-50 @else border-gray-200 focus:border-emerald-500 focus:ring-emerald-50 @enderror focus:ring-4 outline-none transition bg-gray-50 focus:bg-white">
                                @error('title') <p class="mt-2 text-xs font-bold text-rose-500">{{ $message }}</p> @enderror
                            </div>

                            {{-- Penulis --}}
                            <div>
                                <label for="author" class="block text-sm font-bold text-gray-700 mb-2">Penulis <span class="text-rose-500">*</span></label>
                                <input type="text" id="author" name="author" value="{{ old('author') }}" required
                                       placeholder="Nama penulis atau pengarang..."
                                       class="w-full px-4 py-3 rounded-xl border @error('author') border-rose-500 ring-rose-50 @else border-gray-200 focus:border-emerald-500 focus:ring-emerald-50 @enderror focus:ring-4 outline-none transition bg-gray-50 focus:bg-white">
                                @error('author') <p class="mt-2 text-xs font-bold text-rose-500">{{ $message }}</p> @enderror
                            </div>

                            {{-- Sinopsis --}}
                            <div>
                                <label for="synopsis" class="block text-sm font-bold text-gray-700 mb-2">Sinopsis <span class="text-xs font-medium text-gray-400 font-normal ml-1">(Opsional)</span></label>
                                <textarea id="synopsis" name="synopsis" rows="5" placeholder="Tuliskan ringkasan cerita atau isi buku..."
                                          class="w-full px-4 py-3 rounded-xl border @error('synopsis') border-rose-500 ring-rose-50 @else border-gray-200 focus:border-emerald-500 focus:ring-emerald-50 @enderror focus:ring-4 outline-none transition bg-gray-50 focus:bg-white resize-none">{{ old('synopsis') }}</textarea>
                                @error('synopsis') <p class="mt-2 text-xs font-bold text-rose-500">{{ $message }}</p> @enderror
                            </div>

                            {{-- Upload Cover --}}
                            <div>
                                <label for="cover_image" class="block text-sm font-bold text-gray-700 mb-2">Sampul Buku <span class="text-xs font-medium text-gray-400 font-normal ml-1">(Opsional)</span></label>
                                <input type="file" id="cover_image" name="cover_image" accept="image/jpeg,image/png,image/jpg"
                                       class="block w-full text-sm text-gray-500 file:mr-3 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 cursor-pointer border border-gray-200 rounded-xl p-1 transition @error('cover_image') border-rose-500 @enderror bg-white">
                                <p class="mt-2 text-[10px] text-gray-400 font-bold uppercase tracking-widest">Format: JPG, JPEG, PNG (Max 2MB).</p>
                                @error('cover_image') <p class="mt-2 text-xs font-bold text-rose-500">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- KOLOM KANAN: KLASIFIKASI & STOK --}}
                <div class="lg:col-span-1 space-y-6">
                    <div class="bg-white rounded-[1.5rem] shadow-sm border border-gray-100 p-6 sm:p-8">
                        <h3 class="text-lg font-extrabold text-gray-900 mb-6 flex items-center gap-2">
                            <span>⚙️</span> Klasifikasi
                        </h3>

                        <div class="space-y-5">
                            {{-- Genre --}}
                            <div>
                                <label for="genre_id" class="block text-sm font-bold text-gray-700 mb-2">Genre <span class="text-rose-500">*</span></label>
                                <select id="genre_id" name="genre_id" required
                                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-50 outline-none transition text-sm bg-gray-50 focus:bg-white cursor-pointer @error('genre_id') border-rose-500 @enderror">
                                    <option value="" disabled selected>-- Pilih Genre --</option>
                                    @foreach($genres as $genre)
                                        <option value="{{ $genre->id }}" {{ old('genre_id') == $genre->id ? 'selected' : '' }}>
                                            {{ $genre->name }} ({{ $genre->genre_code }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('genre_id') <p class="mt-2 text-xs font-bold text-rose-500">{{ $message }}</p> @enderror
                            </div>

                            {{-- Lokasi Rak --}}
                            <div>
                                <label for="shelf_id" class="block text-sm font-bold text-gray-700 mb-2">Lokasi Rak <span class="text-rose-500">*</span></label>
                                <select id="shelf_id" name="shelf_id" required
                                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-50 outline-none transition text-sm bg-gray-50 focus:bg-white cursor-pointer @error('shelf_id') border-rose-500 @enderror">
                                    <option value="" disabled selected>-- Pilih Lokasi Rak --</option>
                                    @foreach($shelves as $shelf)
                                        <option value="{{ $shelf->id }}" {{ old('shelf_id') == $shelf->id ? 'selected' : '' }}>
                                            {{ $shelf->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('shelf_id') <p class="mt-2 text-xs font-bold text-rose-500">{{ $message }}</p> @enderror
                            </div>

                            {{-- Tipe Buku --}}
                            <div>
                                <label for="book_type" class="block text-sm font-bold text-gray-700 mb-2">Tipe Buku <span class="text-rose-500">*</span></label>
                                <select id="book_type" name="book_type" required
                                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-50 outline-none transition text-sm bg-gray-50 focus:bg-white cursor-pointer @error('book_type') border-rose-500 @enderror">
                                    <option value="reguler" {{ old('book_type') == 'reguler' ? 'selected' : '' }}>Reguler (Bisa dipinjam)</option>
                                    <option value="paket" {{ old('book_type') == 'paket' ? 'selected' : '' }}>Paket (Buku Pelajaran)</option>
                                    <option value="laporan" {{ old('book_type') == 'laporan' ? 'selected' : '' }}>Laporan (Baca di tempat)</option>
                                </select>
                                @error('book_type') <p class="mt-2 text-xs font-bold text-rose-500">{{ $message }}</p> @enderror
                            </div>

                            {{-- Tahun Terbit --}}
                            <div>
                                <label for="publication_year" class="block text-sm font-bold text-gray-700 mb-2">Tahun Terbit <span class="text-xs font-medium text-gray-400 font-normal ml-1">(Opsional)</span></label>
                                <input type="number" id="publication_year" name="publication_year" value="{{ old('publication_year') }}"
                                       placeholder="Contoh: 2023" min="1900" max="{{ date('Y') }}"
                                       class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-50 outline-none transition text-sm bg-gray-50 focus:bg-white @error('publication_year') border-rose-500 @enderror">
                                @error('publication_year') <p class="mt-2 text-xs font-bold text-rose-500">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Manajemen Stok --}}
                    <div class="bg-indigo-50 rounded-[1.5rem] border border-indigo-100 p-6 sm:p-8">
                        <h3 class="text-lg font-extrabold text-indigo-900 mb-4 flex items-center gap-2">
                            <span>📦</span> Pengaturan Stok
                        </h3>

                        <div class="space-y-5">
                            {{-- Kode Awal --}}
                            <div>
                                <label for="initial_code" class="block text-sm font-bold text-indigo-900 mb-2">Kode Awal <span class="text-rose-500">*</span></label>
                                <input type="text" id="initial_code" name="initial_code" value="{{ old('initial_code') }}" required maxlength="10"
                                       placeholder="Contoh: IPA"
                                       class="w-full px-4 py-3 rounded-xl border border-indigo-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 outline-none transition text-sm bg-white uppercase font-bold @error('initial_code') border-rose-500 @enderror">
                                <p class="mt-2 text-[10px] text-indigo-600/70 font-bold uppercase tracking-widest">Sistem akan generate: DDC-KODE-001</p>
                                @error('initial_code') <p class="mt-2 text-xs font-bold text-rose-500">{{ $message }}</p> @enderror
                            </div>

                            {{-- Jumlah Stok --}}
                            <div>
                                <label for="stock" class="block text-sm font-bold text-indigo-900 mb-2">Jumlah Salinan <span class="text-rose-500">*</span></label>
                                <input type="number" id="stock" name="stock" value="{{ old('stock', 1) }}" required min="1" max="100"
                                       placeholder="1"
                                       class="w-full px-4 py-3 rounded-xl border border-indigo-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 outline-none transition text-lg font-black bg-white @error('stock') border-rose-500 @enderror">
                                <p class="mt-2 text-[10px] text-indigo-600/70 font-bold uppercase tracking-widest">Berapa buku fisik yang tersedia?</p>
                                @error('stock') <p class="mt-2 text-xs font-bold text-rose-500">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Action Buttons --}}
            <div class="mt-8 flex items-center justify-end gap-4">
                <a href="{{ route('admin.petugas.books.index') }}" class="inline-flex items-center justify-center bg-white text-gray-700 border border-gray-200 font-bold py-3 px-8 rounded-xl hover:bg-gray-50 transition shadow-sm text-sm">
                    Batal
                </a>
                <button type="submit" class="inline-flex items-center justify-center bg-emerald-600 text-white font-bold py-3 px-8 rounded-xl hover:bg-emerald-700 transition shadow-sm hover:shadow-md text-sm">
                    Simpan & Buat Eksemplar
                </button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    {{-- SweetAlert2 untuk Konfirmasi Simpan --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('create-book-form');

            if (form) {
                form.addEventListener('submit', function (event) {
                    event.preventDefault();

                    const title = document.getElementById('title').value;
                    const stock = document.getElementById('stock').value;

                    Swal.fire({
                        title: 'Simpan Data Buku?',
                        html: `Sistem akan menyimpan buku <strong>"${title}"</strong> dan secara otomatis membuat <strong>${stock} salinan/eksemplar</strong> kode barcode.`,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#059669', // Emerald-600
                        cancelButtonColor: '#6b7280',  // Gray-500
                        confirmButtonText: 'Ya, Simpan & Buat Eksemplar!',
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
