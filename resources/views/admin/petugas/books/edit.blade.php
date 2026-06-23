@extends('layouts.admin')

@section('content')
    <div class="max-w-7xl mx-auto">

        {{-- Header Halaman --}}
        <div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Edit Data Buku</h2>
                <p class="text-gray-500 mt-1 font-medium">Perbarui informasi, sampul, atau tambahkan stok untuk buku <strong class="text-slate-800">{{ $book->title }}</strong>.</p>
            </div>
            <a href="{{ route('admin.petugas.books.index') }}" class="inline-flex items-center gap-2 bg-white text-gray-700 border border-gray-200 font-bold py-2.5 px-5 rounded-xl hover:bg-gray-50 transition shadow-sm text-sm">
                <span>⬅️</span> Kembali
            </a>
        </div>

        {{-- Alert Notifikasi --}}
        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 text-emerald-700 border border-emerald-100 rounded-xl font-bold flex items-center gap-3 shadow-sm">
                <span class="text-xl">✅</span> {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-6 p-4 bg-rose-50 text-rose-700 border border-rose-100 rounded-xl font-bold flex items-center gap-3 shadow-sm">
                <span class="text-xl">⚠️</span> {{ session('error') }}
            </div>
        @endif

        {{-- Alert Validasi Error --}}
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

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- KOLOM KIRI: FORM EDIT & TAMBAH STOK --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- Form Utama --}}
                <div class="bg-white rounded-[1.5rem] shadow-sm border border-gray-100 p-6 sm:p-8">
                    <form action="{{ route('admin.petugas.books.update', $book->id) }}" method="POST" enctype="multipart/form-data" id="edit-book-form">
                        @csrf
                        @method('PUT')

                        <h3 class="text-lg font-extrabold text-gray-900 mb-6 flex items-center gap-2">
                            <span>📖</span> Detail Utama
                        </h3>

                        <div class="space-y-6">
                            {{-- Judul & Penulis --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="title" class="block text-sm font-bold text-gray-700 mb-2">Judul Buku <span class="text-rose-500">*</span></label>
                                    <input type="text" id="title" name="title" value="{{ old('title', $book->title) }}" required
                                           class="w-full px-4 py-3 rounded-xl border @error('title') border-rose-500 ring-rose-50 @else border-gray-200 focus:border-emerald-500 focus:ring-emerald-50 @enderror focus:ring-4 outline-none transition bg-gray-50 focus:bg-white">
                                    @error('title') <p class="mt-2 text-xs font-bold text-rose-500">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label for="author" class="block text-sm font-bold text-gray-700 mb-2">Penulis <span class="text-rose-500">*</span></label>
                                    <input type="text" id="author" name="author" value="{{ old('author', $book->author) }}" required
                                           class="w-full px-4 py-3 rounded-xl border @error('author') border-rose-500 ring-rose-50 @else border-gray-200 focus:border-emerald-500 focus:ring-emerald-50 @enderror focus:ring-4 outline-none transition bg-gray-50 focus:bg-white">
                                    @error('author') <p class="mt-2 text-xs font-bold text-rose-500">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            {{-- Sinopsis --}}
                            <div>
                                <label for="synopsis" class="block text-sm font-bold text-gray-700 mb-2">Sinopsis <span class="text-xs font-medium text-gray-400 font-normal ml-1">(Opsional)</span></label>
                                <textarea id="synopsis" name="synopsis" rows="4"
                                          class="w-full px-4 py-3 rounded-xl border @error('synopsis') border-rose-500 ring-rose-50 @else border-gray-200 focus:border-emerald-500 focus:ring-emerald-50 @enderror focus:ring-4 outline-none transition bg-gray-50 focus:bg-white resize-none">{{ old('synopsis', $book->synopsis) }}</textarea>
                                @error('synopsis') <p class="mt-2 text-xs font-bold text-rose-500">{{ $message }}</p> @enderror
                            </div>

                            {{-- Klasifikasi: Genre, Rak, Tipe, Tahun --}}
                            <div class="p-5 bg-slate-50 border border-slate-100 rounded-xl space-y-4">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    {{-- Genre --}}
                                    <div>
                                        <label for="genre_id" class="block text-xs font-bold text-gray-700 mb-2 uppercase tracking-wider">Genre</label>
                                        <select id="genre_id" name="genre_id" required class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-emerald-500 outline-none transition text-sm bg-white cursor-pointer">
                                            @foreach ($genres as $genre)
                                                <option value="{{ $genre->id }}" {{ (old('genre_id', $book->genre_id) == $genre->id) ? 'selected' : '' }}>
                                                    {{ $genre->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    {{-- Rak --}}
                                    <div>
                                        <label for="shelf_id" class="block text-xs font-bold text-gray-700 mb-2 uppercase tracking-wider">Lokasi Rak</label>
                                        <select id="shelf_id" name="shelf_id" required class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-emerald-500 outline-none transition text-sm bg-white cursor-pointer">
                                            @foreach ($shelves as $shelf)
                                                <option value="{{ $shelf->id }}" {{ (old('shelf_id', $book->shelf_id) == $shelf->id) ? 'selected' : '' }}>
                                                    {{ $shelf->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    {{-- Tipe Buku --}}
                                    <div>
                                        <label for="book_type" class="block text-xs font-bold text-gray-700 mb-2 uppercase tracking-wider">Tipe Buku</label>
                                        <select id="book_type" name="book_type" required class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-emerald-500 outline-none transition text-sm bg-white cursor-pointer">
                                            <option value="reguler" {{ (old('book_type', $book->book_type) == 'reguler') ? 'selected' : '' }}>Reguler (Bisa dipinjam)</option>
                                            <option value="paket" {{ (old('book_type', $book->book_type) == 'paket') ? 'selected' : '' }}>Paket (Pelajaran)</option>
                                            <option value="laporan" {{ (old('book_type', $book->book_type) == 'laporan') ? 'selected' : '' }}>Laporan (Baca di tempat)</option>
                                        </select>
                                    </div>
                                    {{-- Tahun Terbit --}}
                                    <div>
                                        <label for="publication_year" class="block text-xs font-bold text-gray-700 mb-2 uppercase tracking-wider">Tahun Terbit</label>
                                        <input type="number" id="publication_year" name="publication_year" value="{{ old('publication_year', $book->publication_year) }}" min="1900" max="{{ date('Y') }}"
                                               class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-emerald-500 outline-none transition text-sm bg-white">
                                    </div>
                                </div>
                            </div>

                            <div class="h-px bg-gray-100 my-6"></div>

                            {{-- Sampul Buku --}}
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-4">Pengaturan Sampul Buku</label>
                                <div class="flex flex-col sm:flex-row gap-6 items-start">
                                    {{-- Current Cover --}}
                                    <div class="shrink-0 flex flex-col items-center">
                                        <span class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Sampul Saat Ini</span>
                                        <div class="w-32 h-48 rounded-xl overflow-hidden border border-gray-200 bg-gray-50 shadow-sm flex items-center justify-center">
                                            @if($book->cover_image && Storage::disk('public')->exists($book->cover_image))
                                                <img src="{{ Storage::url($book->cover_image) }}" alt="Current Cover" class="w-full h-full object-cover">
                                            @else
                                                <span class="text-xs font-bold text-gray-400">NO COVER</span>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- Upload New Cover --}}
                                    <div class="flex-grow w-full">
                                        <label for="cover_image" class="block text-xs font-bold text-gray-700 mb-2">Ganti Sampul (Opsional)</label>
                                        <input type="file" id="cover_image" name="cover_image" accept="image/jpeg,image/png,image/jpg" onchange="previewImage(event)"
                                               class="block w-full text-sm text-gray-500 file:mr-3 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 cursor-pointer border border-gray-200 rounded-xl p-1 transition @error('cover_image') border-rose-500 @enderror bg-white">
                                        <p class="mt-2 text-[10px] text-gray-400 font-bold uppercase tracking-widest">Kosongkan jika tidak ingin mengubah sampul.</p>

                                        {{-- Preview New Cover --}}
                                        <div class="mt-4 flex items-center gap-4 hidden" id="preview-container">
                                            <span class="text-xs font-bold text-emerald-600 uppercase tracking-widest">Preview Baru: </span>
                                            <div class="w-16 h-24 rounded-lg overflow-hidden border border-emerald-200 shadow-sm">
                                                <img id="newCoverPreview" src="" class="w-full h-full object-cover">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="h-px bg-gray-100 my-6"></div>

                            {{-- Tambah Stok (Opsional) --}}
                            <div class="bg-indigo-50 border border-indigo-100 rounded-xl p-5">
                                <label for="add_stock" class="block text-sm font-bold text-indigo-900 mb-2 flex items-center gap-2">
                                    <span>📦</span> Tambah Stok / Eksemplar Baru
                                </label>
                                <p class="text-xs text-indigo-700 mb-3">Jika ada penambahan buku fisik, masukkan jumlahnya di bawah ini. Sistem otomatis melanjutkan nomor seri dari kode sebelumnya.</p>
                                <input type="number" id="add_stock" name="add_stock" value="{{ old('add_stock') }}" min="1" max="100" placeholder="Contoh: 5"
                                       class="w-full sm:w-1/2 px-4 py-3 rounded-xl border border-indigo-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 outline-none transition text-sm font-bold bg-white @error('add_stock') border-rose-500 @enderror">
                                @error('add_stock') <p class="mt-2 text-xs font-bold text-rose-500">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        {{-- Tombol Aksi Simpan --}}
                        <div class="flex flex-col sm:flex-row items-center gap-3 pt-8 border-t border-gray-100 mt-8">
                            <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center bg-emerald-600 text-white font-bold py-3 px-8 rounded-xl hover:bg-emerald-700 transition shadow-sm text-sm">
                                Simpan Perubahan
                            </button>
                            <a href="{{ route('admin.petugas.books.index') }}" class="w-full sm:w-auto inline-flex items-center justify-center bg-white text-gray-700 border border-gray-200 font-bold py-3 px-8 rounded-xl hover:bg-gray-50 transition shadow-sm text-sm">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>

                {{-- DANGER ZONE (Hapus Buku) --}}
                <div class="bg-rose-50 rounded-[1.5rem] border border-rose-100 p-6 sm:p-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <h4 class="text-base font-extrabold text-rose-900 flex items-center gap-2"><span>⚠️</span> Hapus Buku Permanen</h4>
                        <p class="text-sm text-rose-700 mt-1">Hapus buku ini dan seluruh riwayat salinannya dari sistem perpustakaan.</p>
                    </div>
                    @if($book->borrowed_copies_count == 0)
                        <form action="{{ route('admin.petugas.books.destroy', $book->id) }}" method="POST" id="form-delete-book" class="shrink-0 m-0">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center bg-white text-rose-600 border border-rose-200 font-bold py-3 px-6 rounded-xl hover:bg-rose-600 hover:text-white transition shadow-sm text-sm">
                                🗑️ Hapus Buku
                            </button>
                        </form>
                    @else
                        <button type="button" disabled class="shrink-0 w-full sm:w-auto inline-flex items-center justify-center bg-gray-200 text-gray-400 border border-transparent font-bold py-3 px-6 rounded-xl cursor-not-allowed text-sm" title="Buku sedang dipinjam">
                            🗑️ Tidak Bisa Dihapus
                        </button>
                    @endif
                </div>
            </div>

            {{-- KOLOM KANAN: DAFTAR EKSEMPLAR --}}
            <div class="lg:col-span-1">
                <div class="bg-white rounded-[1.5rem] shadow-sm border border-gray-100 overflow-hidden sticky top-6">

                    <div class="p-5 border-b border-gray-100 bg-slate-900 flex justify-between items-center">
                        <h6 class="font-extrabold text-white flex items-center gap-2">
                            <span>📚</span> Salinan Fisik
                        </h6>
                        <span class="px-2.5 py-0.5 rounded-lg bg-white/20 text-white text-xs font-bold">{{ $book->copies->count() }} Total</span>
                    </div>

                    <div class="p-0">
                        @if ($book->copies->isNotEmpty())
                            <div class="max-h-[36rem] overflow-y-auto">
                                <table class="w-full text-left border-collapse">
                                    <thead class="bg-gray-50/80 border-b border-gray-100 sticky top-0 backdrop-blur-sm">
                                        <tr>
                                            <th class="px-4 py-3 text-[10px] font-extrabold text-gray-500 uppercase tracking-wider">Kode</th>
                                            <th class="px-4 py-3 text-[10px] font-extrabold text-gray-500 uppercase tracking-wider text-center">Status</th>
                                            <th class="px-4 py-3 text-[10px] font-extrabold text-gray-500 uppercase tracking-wider text-right">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100">
                                        @foreach ($book->copies as $copy)
                                            <tr class="hover:bg-gray-50 transition">
                                                <td class="px-4 py-3">
                                                    <span class="text-xs font-mono font-bold text-slate-700 bg-slate-100 px-1.5 py-0.5 rounded border border-slate-200">{{ $copy->book_code }}</span>
                                                </td>
                                                <td class="px-4 py-3 text-center">
                                                    @if ($copy->status == 'tersedia')
                                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-700">Tersedia</span>
                                                    @elseif ($copy->status == 'dipinjam')
                                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-amber-100 text-amber-700">Dipinjam</span>
                                                    @elseif ($copy->status == 'pending')
                                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-sky-100 text-sky-700">Pending</span>
                                                    @elseif ($copy->status == 'overdue')
                                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-rose-100 text-rose-700">Telat</span>
                                                    @elseif ($copy->status == 'hilang')
                                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-gray-800 text-white">Hilang</span>
                                                    @else
                                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-gray-100 text-gray-700">{{ strtoupper($copy->status) }}</span>
                                                    @endif
                                                </td>
                                                <td class="px-4 py-3 text-right">
                                                    <div class="flex items-center justify-end gap-1">
                                                        @if ($copy->status == 'tersedia')
                                                            <form action="{{ route('admin.petugas.books.copies.destroy', $copy->id) }}" method="POST" class="form-delete-copy m-0" data-code="{{ $copy->book_code }}">
                                                                @csrf @method('DELETE')
                                                                <button type="submit" class="w-7 h-7 inline-flex items-center justify-center bg-rose-50 text-rose-600 hover:bg-rose-100 rounded text-xs transition" title="Hapus Salinan">🗑️</button>
                                                            </form>
                                                        @elseif ($copy->status == 'hilang')
                                                            <form action="{{ route('admin.petugas.books.copies.markFound', $copy->id) }}" method="POST" class="form-mark-found m-0" data-code="{{ $copy->book_code }}">
                                                                @csrf @method('PUT')
                                                                <button type="submit" class="w-7 h-7 inline-flex items-center justify-center bg-emerald-50 text-emerald-600 hover:bg-emerald-100 rounded text-xs transition" title="Tandai Ditemukan">✅</button>
                                                            </form>
                                                        @else
                                                            <span class="w-7 h-7 inline-flex items-center justify-center text-gray-300" title="Terkunci (Sedang dipinjam/diproses)">🔒</span>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="p-8 text-center">
                                <span class="text-4xl block mb-2 opacity-30">📦</span>
                                <p class="text-sm font-bold text-gray-500">Belum ada eksemplar</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Preview Gambar Cover Baru
        function previewImage(event) {
            const reader = new FileReader();
            const container = document.getElementById('preview-container');
            const output = document.getElementById('newCoverPreview');

            reader.onload = function(){
                output.src = reader.result;
                container.classList.remove('hidden');
            };

            if(event.target.files[0]){
                reader.readAsDataURL(event.target.files[0]);
            } else {
                container.classList.add('hidden');
            }
        }

        document.addEventListener('DOMContentLoaded', function() {

            // Konfirmasi Edit Buku Utama
            const formEdit = document.getElementById('edit-book-form');
            if (formEdit) {
                formEdit.addEventListener('submit', function (e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Simpan Perubahan?',
                        text: "Data buku dan/atau penambahan stok akan disimpan.",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#059669', // Emerald
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: 'Ya, Simpan!',
                        cancelButtonText: 'Batal',
                        borderRadius: '1.5rem'
                    }).then((result) => {
                        if (result.isConfirmed) formEdit.submit();
                    });
                });
            }

            // Konfirmasi Hapus Buku Total
            const formDeleteBook = document.getElementById('form-delete-book');
            if (formDeleteBook) {
                formDeleteBook.addEventListener('submit', function (e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Hapus Buku Permanen?',
                        html: "Anda yakin ingin menghapus buku <strong>{{ $book->title }}</strong> beserta semua salinannya?<br><span class='text-rose-500 text-sm'>Tindakan ini tidak bisa dibatalkan!</span>",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#e11d48', // Rose
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: 'Ya, Hapus Buku',
                        cancelButtonText: 'Batal',
                        borderRadius: '1.5rem'
                    }).then((result) => {
                        if (result.isConfirmed) formDeleteBook.submit();
                    });
                });
            }

            // Konfirmasi Hapus 1 Eksemplar
            document.querySelectorAll('.form-delete-copy').forEach(form => {
                form.addEventListener('submit', function (e) {
                    e.preventDefault();
                    const code = this.dataset.code;
                    Swal.fire({
                        title: 'Hapus Salinan?',
                        text: `Hapus salinan buku fisik dengan kode ${code}?`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#e11d48',
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: 'Hapus',
                        cancelButtonText: 'Batal',
                        borderRadius: '1.5rem'
                    }).then((result) => {
                        if (result.isConfirmed) form.submit();
                    });
                });
            });

            // Konfirmasi Tandai Ditemukan (Buku Hilang)
            document.querySelectorAll('.form-mark-found').forEach(form => {
                form.addEventListener('submit', function (e) {
                    e.preventDefault();
                    const code = this.dataset.code;
                    Swal.fire({
                        title: 'Tandai Ditemukan?',
                        text: `Buku dengan kode ${code} akan diubah statusnya menjadi Tersedia kembali.`,
                        icon: 'info',
                        showCancelButton: true,
                        confirmButtonColor: '#059669',
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: 'Ya, Ditemukan',
                        cancelButtonText: 'Batal',
                        borderRadius: '1.5rem'
                    }).then((result) => {
                        if (result.isConfirmed) form.submit();
                    });
                });
            });

        });
    </script>
@endpush
