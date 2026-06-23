@extends('layouts.admin')

@section('content')
    <div class="max-w-7xl mx-auto">

        {{-- Header Halaman --}}
        <div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Edit Genre</h2>
                <p class="text-gray-500 mt-1 font-medium">Perbarui informasi untuk genre: <strong class="text-slate-800">{{ $genre->name }}</strong></p>
            </div>
            <a href="{{ route('admin.petugas.genres.index') }}" class="inline-flex items-center gap-2 bg-white text-gray-700 border border-gray-200 font-bold py-2.5 px-5 rounded-xl hover:bg-gray-50 transition shadow-sm text-sm">
                <span>⬅️</span> Kembali
            </a>
        </div>

        {{-- Alert Sukses --}}
        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 text-emerald-700 border border-emerald-100 rounded-xl font-bold flex items-center gap-3 shadow-sm">
                <span class="text-xl">✅</span> {{ session('success') }}
            </div>
        @endif

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
            <div class="lg:col-span-2 space-y-6">

                {{-- Card Form Update --}}
                <div class="bg-white rounded-[1.5rem] shadow-sm border border-gray-100 p-6 sm:p-8">
                    <form action="{{ route('admin.petugas.genres.update', $genre->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="space-y-6 mb-8">
                            {{-- Kode & Nama Genre (Grid) --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="genre_code" class="block text-sm font-bold text-gray-700 mb-2">Kode Genre (DDC) <span class="text-rose-500">*</span></label>
                                    <input type="text" id="genre_code" name="genre_code" value="{{ old('genre_code', $genre->genre_code) }}" required
                                           placeholder="Contoh: 800"
                                           class="w-full px-4 py-3 rounded-xl border @error('genre_code') border-rose-500 ring-rose-50 @else border-gray-200 focus:border-emerald-500 focus:ring-emerald-50 @enderror focus:ring-4 outline-none transition bg-gray-50 focus:bg-white font-mono">
                                </div>

                                <div>
                                    <label for="name" class="block text-sm font-bold text-gray-700 mb-2">Nama Genre <span class="text-rose-500">*</span></label>
                                    <input type="text" id="name" name="name" value="{{ old('name', $genre->name) }}" required
                                           placeholder="Contoh: Fiksi Klasik"
                                           class="w-full px-4 py-3 rounded-xl border @error('name') border-rose-500 ring-rose-50 @else border-gray-200 focus:border-emerald-500 focus:ring-emerald-50 @enderror focus:ring-4 outline-none transition bg-gray-50 focus:bg-white">
                                </div>
                            </div>

                            {{-- Upload Ikon --}}
                            <div>
                                <label for="icon" class="block text-sm font-bold text-gray-700 mb-2">Ikon Kategori (Opsional)</label>

                                @if($genre->icon)
                                    <div class="mb-4 flex items-center gap-4 p-4 bg-slate-50 border border-slate-100 rounded-xl">
                                        <div class="w-16 h-16 rounded-xl overflow-hidden bg-white border border-gray-200 flex items-center justify-center shrink-0 shadow-sm">
                                            <img src="{{ asset('storage/' . $genre->icon) }}" alt="Icon Saat Ini" class="w-full h-full object-cover">
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-gray-900">Ikon Saat Ini</p>
                                            <p class="text-xs text-gray-500 mt-0.5">Akan diganti jika Anda mengunggah gambar baru.</p>
                                        </div>
                                    </div>
                                @endif

                                <input type="file" id="icon" name="icon" accept="image/*"
                                       class="block w-full text-sm text-gray-500 file:mr-3 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 cursor-pointer border border-gray-200 rounded-xl p-1 transition @error('icon') border-rose-500 @enderror bg-white">
                                <p class="mt-2 text-[10px] text-gray-400 font-bold uppercase tracking-widest">Format: JPG, PNG, SVG (Max 2MB).</p>
                            </div>
                        </div>

                        {{-- Tombol Submit --}}
                        <div class="flex items-center gap-4 pt-6 border-t border-gray-100">
                            <button type="submit" class="inline-flex items-center justify-center bg-emerald-600 text-white font-bold py-3 px-8 rounded-xl hover:bg-emerald-700 transition shadow-sm hover:shadow-md text-sm">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>

                {{-- Card Danger Zone (Hapus) --}}
                <div class="bg-rose-50 rounded-[1.5rem] border border-rose-100 p-6 sm:p-8">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div>
                            <h4 class="text-base font-extrabold text-rose-900">Danger Zone</h4>
                            <p class="text-sm text-rose-700 mt-1">Hapus genre ini secara permanen dari sistem perpustakaan.</p>
                        </div>
                        <form action="{{ route('admin.petugas.genres.destroy', $genre->id) }}" method="POST" id="delete-form" class="m-0 shrink-0">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center justify-center bg-white text-rose-600 border border-rose-200 font-bold py-2.5 px-6 rounded-xl hover:bg-rose-600 hover:text-white transition shadow-sm text-sm">
                                🗑️ Hapus Genre
                            </button>
                        </form>
                    </div>
                </div>

            </div>

            {{-- KOLOM KANAN: SIDEBAR INFO --}}
            <div class="lg:col-span-1 space-y-6">

                {{-- Statistik Cepat --}}
                <div class="bg-white rounded-[1.5rem] shadow-sm border border-gray-100 p-6 border-t-4 border-t-emerald-500">
                    <h6 class="mb-3 font-extrabold text-gray-900 flex items-center gap-2">
                        <span>📊</span> Ringkasan
                    </h6>
                    <div class="flex justify-between items-center bg-emerald-50 p-4 rounded-xl border border-emerald-100">
                        <span class="text-sm font-bold text-emerald-800">Total Genre Aktif</span>
                        <span class="text-2xl font-extrabold text-emerald-600">{{ \App\Models\Genre::count() }}</span>
                    </div>
                    <p class="mt-4 text-xs text-gray-500 font-medium leading-relaxed">Ikon genre akan dimunculkan secara publik di halaman katalog utama pengunjung.</p>
                </div>

                {{-- Petunjuk --}}
                <div class="bg-slate-900 rounded-[1.5rem] shadow-sm border border-slate-800 p-6 text-slate-300">
                    <h6 class="mb-4 font-extrabold text-white flex items-center gap-2">
                        <span class="text-amber-400">💡</span> Petunjuk
                    </h6>
                    <ul class="space-y-4 text-sm font-medium">
                        <li class="flex gap-3">
                            <span class="text-emerald-400 shrink-0">✓</span>
                            <span>Nama dan Kode (DDC) genre wajib diisi dan unik.</span>
                        </li>
                        <li class="flex gap-3">
                            <span class="text-sky-400 shrink-0">ℹ️</span>
                            <span>Sangat disarankan menggunakan gambar berlatar transparan (PNG/SVG) untuk ikon.</span>
                        </li>
                        <li class="flex gap-3">
                            <span class="text-rose-400 shrink-0">⚠️</span>
                            <span>Pastikan tidak ada buku yang terhubung dengan genre ini sebelum melakukan penghapusan.</span>
                        </li>
                    </ul>
                </div>

            </div>

        </div>
    </div>
@endsection

@push('scripts')
    {{-- SweetAlert2 untuk Konfirmasi Hapus --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteForm = document.getElementById('delete-form');

            if (deleteForm) {
                deleteForm.addEventListener('submit', function (event) {
                    event.preventDefault();

                    Swal.fire({
                        title: 'Hapus Genre Ini?',
                        html: "Apakah Anda yakin ingin menghapus genre <strong>'{{ $genre->name }}'</strong>?<br><span class='text-sm text-rose-500 mt-2 block'>Tindakan ini tidak dapat dibatalkan.</span>",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#e11d48', // Rose-600
                        cancelButtonColor: '#6b7280',  // Gray-500
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal',
                        borderRadius: '1.5rem'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            deleteForm.submit();
                        }
                    });
                });
            }
        });
    </script>
@endpush
