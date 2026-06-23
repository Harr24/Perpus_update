@extends('layouts.admin')

@section('content')
    <div class="max-w-3xl mx-auto">

        {{-- Header Halaman --}}
        <div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Edit Akun Guru</h2>
                <p class="text-gray-500 mt-1 font-medium">Perbarui informasi akun untuk guru: <strong class="text-slate-800">{{ $teacher->name }}</strong></p>
            </div>
            <a href="{{ route('admin.petugas.teachers.index') }}" class="inline-flex items-center gap-2 bg-white text-gray-700 border border-gray-200 font-bold py-2.5 px-5 rounded-xl hover:bg-gray-50 transition shadow-sm text-sm">
                <span>⬅️</span> Kembali
            </a>
        </div>

        {{-- Alert Error Validasi --}}
        @if($errors->any())
            <div class="mb-6 p-5 bg-rose-50 border border-rose-100 rounded-xl">
                <div class="flex items-center gap-2 mb-2 font-bold text-rose-700">
                    <span class="text-xl">⚠️</span> Gagal Memproses!
                </div>
                <p class="text-sm font-medium text-rose-600 mb-2">Terdapat kesalahan pada data yang Anda masukkan:</p>
                <ul class="list-disc list-inside text-sm font-medium text-rose-600 pl-2 space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form Card Utama --}}
        <div class="bg-white rounded-[1.5rem] shadow-sm border border-gray-100 p-8">
            <form action="{{ route('admin.petugas.teachers.update', $teacher) }}" method="POST" id="edit-teacher-form">
                @csrf
                @method('PUT')

                <div class="space-y-6 mb-8">
                    {{-- Nama Lengkap --}}
                    <div>
                        <label for="name" class="block text-sm font-bold text-gray-700 mb-2">Nama Lengkap <span class="text-rose-500">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name', $teacher->name) }}" required
                               class="w-full px-4 py-3 rounded-xl border @error('name') border-rose-500 ring-rose-50 @else border-gray-200 focus:border-emerald-500 focus:ring-emerald-50 @enderror focus:ring-4 outline-none transition bg-gray-50 focus:bg-white">
                        @error('name') <p class="mt-2 text-xs font-bold text-rose-500">{{ $message }}</p> @enderror
                    </div>

                    {{-- Email & Mata Pelajaran (Grid) --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="email" class="block text-sm font-bold text-gray-700 mb-2">Alamat Email <span class="text-rose-500">*</span></label>
                            <input type="email" id="email" name="email" value="{{ old('email', $teacher->email) }}" required
                                   class="w-full px-4 py-3 rounded-xl border @error('email') border-rose-500 ring-rose-50 @else border-gray-200 focus:border-emerald-500 focus:ring-emerald-50 @enderror focus:ring-4 outline-none transition bg-gray-50 focus:bg-white">
                            @error('email') <p class="mt-2 text-xs font-bold text-rose-500">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="subject" class="block text-sm font-bold text-gray-700 mb-2">Mata Pelajaran <span class="text-rose-500">*</span></label>
                            <input type="text" id="subject" name="subject" value="{{ old('subject', $teacher->subject) }}" required
                                   class="w-full px-4 py-3 rounded-xl border @error('subject') border-rose-500 ring-rose-50 @else border-gray-200 focus:border-emerald-500 focus:ring-emerald-50 @enderror focus:ring-4 outline-none transition bg-gray-50 focus:bg-white">
                            @error('subject') <p class="mt-2 text-xs font-bold text-rose-500">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="h-px bg-gray-100 my-8"></div>

                    {{-- Bagian Ubah Password --}}
                    <div class="bg-slate-50 p-6 rounded-xl border border-slate-100">
                        <div class="mb-4">
                            <h4 class="text-sm font-bold text-gray-900 flex items-center gap-2">
                                <span>🔑</span> Ubah Password <span class="text-xs font-medium text-gray-500 ml-1">(Opsional)</span>
                            </h4>
                            <p class="text-xs text-gray-500 mt-1">Kosongkan kedua kolom di bawah ini jika Anda tidak ingin mengubah password akun ini.</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="password" class="block text-xs font-bold text-gray-700 mb-2 uppercase tracking-wider">Password Baru</label>
                                <input type="password" id="password" name="password" placeholder="Minimal 8 karakter"
                                       class="w-full px-4 py-3 rounded-xl border @error('password') border-rose-500 ring-rose-50 @else border-gray-200 focus:border-emerald-500 focus:ring-emerald-50 @enderror focus:ring-4 outline-none transition bg-white">
                                @error('password') <p class="mt-2 text-xs font-bold text-rose-500">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="password_confirmation" class="block text-xs font-bold text-gray-700 mb-2 uppercase tracking-wider">Konfirmasi Password</label>
                                <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password baru"
                                       class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-50 outline-none transition bg-white">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Tombol Aksi --}}
                <div class="flex items-center gap-4 pt-6 border-t border-gray-100">
                    <button type="submit" class="inline-flex items-center justify-center bg-emerald-600 text-white font-bold py-3 px-8 rounded-xl hover:bg-emerald-700 transition shadow-sm hover:shadow-md text-sm">
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('admin.petugas.teachers.index') }}" class="inline-flex items-center justify-center bg-white text-gray-700 border border-gray-200 font-bold py-3 px-8 rounded-xl hover:bg-gray-50 transition shadow-sm text-sm">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    {{-- SweetAlert untuk Konfirmasi Edit --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('edit-teacher-form');

            if (form) {
                form.addEventListener('submit', function (event) {
                    event.preventDefault();

                    Swal.fire({
                        title: 'Simpan Perubahan?',
                        text: "Pastikan data profil guru yang diubah sudah benar.",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#059669', // Emerald-600
                        cancelButtonColor: '#6b7280', // Gray-500
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
