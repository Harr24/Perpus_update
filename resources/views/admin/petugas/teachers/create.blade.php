@extends('layouts.admin')

@section('content')
    <div class="max-w-3xl mx-auto">

        {{-- Header Halaman --}}
        <div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Tambah Guru Baru</h2>
                <p class="text-gray-500 mt-1 font-medium">Buatkan akun akses untuk guru agar bisa masuk ke sistem.</p>
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
            <form action="{{ route('admin.petugas.teachers.store') }}" method="POST" id="create-teacher-form">
                @csrf

                {{-- Catatan Pengingat --}}
                <div class="mb-8 p-4 bg-amber-50 border border-amber-100 rounded-xl flex gap-3 text-sm text-amber-800 leading-relaxed">
                    <span class="text-xl shrink-0">💡</span>
                    <p><strong>Catatan Penting:</strong> Pastikan Anda memberi tahu guru yang bersangkutan terkait <strong>email</strong> dan <strong>password</strong> sementara yang Anda buatkan di bawah ini agar mereka bisa login.</p>
                </div>

                <div class="space-y-6 mb-8">
                    {{-- Nama Lengkap --}}
                    <div>
                        <label for="name" class="block text-sm font-bold text-gray-700 mb-2">Nama Lengkap <span class="text-rose-500">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required
                               placeholder="Masukkan nama lengkap guru"
                               class="w-full px-4 py-3 rounded-xl border @error('name') border-rose-500 ring-rose-50 @else border-gray-200 focus:border-emerald-500 focus:ring-emerald-50 @enderror focus:ring-4 outline-none transition bg-gray-50 focus:bg-white">
                        @error('name') <p class="mt-2 text-xs font-bold text-rose-500">{{ $message }}</p> @enderror
                    </div>

                    {{-- Email & Mata Pelajaran (Grid) --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="email" class="block text-sm font-bold text-gray-700 mb-2">Alamat Email <span class="text-rose-500">*</span></label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                   placeholder="guru@sekolah.com"
                                   class="w-full px-4 py-3 rounded-xl border @error('email') border-rose-500 ring-rose-50 @else border-gray-200 focus:border-emerald-500 focus:ring-emerald-50 @enderror focus:ring-4 outline-none transition bg-gray-50 focus:bg-white">
                            @error('email') <p class="mt-2 text-xs font-bold text-rose-500">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="subject" class="block text-sm font-bold text-gray-700 mb-2">Mata Pelajaran <span class="text-rose-500">*</span></label>
                            <input type="text" id="subject" name="subject" value="{{ old('subject') }}" required
                                   placeholder="Contoh: Matematika"
                                   class="w-full px-4 py-3 rounded-xl border @error('subject') border-rose-500 ring-rose-50 @else border-gray-200 focus:border-emerald-500 focus:ring-emerald-50 @enderror focus:ring-4 outline-none transition bg-gray-50 focus:bg-white">
                            @error('subject') <p class="mt-2 text-xs font-bold text-rose-500">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="h-px bg-gray-100 my-6"></div>

                    {{-- Password & Konfirmasi (Grid) --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="password" class="block text-sm font-bold text-gray-700 mb-2">Password Sementara <span class="text-rose-500">*</span></label>
                            <input type="password" id="password" name="password" required
                                   placeholder="Minimal 8 karakter"
                                   class="w-full px-4 py-3 rounded-xl border @error('password') border-rose-500 ring-rose-50 @else border-gray-200 focus:border-emerald-500 focus:ring-emerald-50 @enderror focus:ring-4 outline-none transition bg-gray-50 focus:bg-white">
                            @error('password') <p class="mt-2 text-xs font-bold text-rose-500">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-bold text-gray-700 mb-2">Konfirmasi Password <span class="text-rose-500">*</span></label>
                            <input type="password" id="password_confirmation" name="password_confirmation" required
                                   placeholder="Ulangi password"
                                   class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-50 outline-none transition bg-gray-50 focus:bg-white">
                        </div>
                    </div>
                </div>

                {{-- Tombol Aksi --}}
                <div class="flex items-center gap-4 pt-6 border-t border-gray-100">
                    <button type="submit" class="inline-flex items-center justify-center bg-emerald-600 text-white font-bold py-3 px-8 rounded-xl hover:bg-emerald-700 transition shadow-sm hover:shadow-md text-sm">
                        Buat Akun Guru
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
    {{-- SweetAlert untuk Konfirmasi --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('create-teacher-form');

            if (form) {
                form.addEventListener('submit', function (event) {
                    event.preventDefault();

                    Swal.fire({
                        title: 'Buat Akun Guru?',
                        text: "Pastikan email dan data mata pelajaran sudah benar.",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#059669', // Emerald-600
                        cancelButtonColor: '#6b7280', // Gray-500
                        confirmButtonText: 'Ya, Buat Akun!',
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
