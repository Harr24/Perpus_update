@extends('layouts.admin')

@section('content')
    <div class="max-w-3xl mx-auto">

        {{-- Header Halaman --}}
        <div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Tambah Akun Petugas</h2>
                <p class="text-gray-500 mt-1 font-medium">Masukkan detail untuk mendaftarkan akun petugas baru.</p>
            </div>
            <a href="{{ route('admin.superadmin.petugas.index') }}" class="inline-flex items-center gap-2 bg-white text-gray-700 border border-gray-200 font-bold py-2.5 px-5 rounded-xl hover:bg-gray-50 transition shadow-sm text-sm">
                <span>⬅️</span> Kembali
            </a>
        </div>

        {{-- Alert Error Validasi --}}
        @if ($errors->any())
            <div class="mb-6 p-5 bg-rose-50 border border-rose-100 rounded-xl">
                <div class="flex items-center gap-2 mb-2 font-bold text-rose-700">
                    <span class="text-xl">⚠️</span> Terdapat Kesalahan:
                </div>
                <ul class="list-disc list-inside text-sm font-medium text-rose-600 pl-7 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form Card Utama --}}
        <div class="bg-white rounded-[1.5rem] shadow-sm border border-gray-100 p-8">
            <form action="{{ route('admin.superadmin.petugas.store') }}" method="POST">
                @csrf

                {{-- Nama Lengkap --}}
                <div class="mb-6">
                    <label for="name" class="block text-sm font-bold text-gray-700 mb-2">
                        Nama Lengkap <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required
                           placeholder="Masukkan nama lengkap petugas"
                           class="w-full px-4 py-3 rounded-xl border @error('name') border-rose-500 ring-rose-50 @else border-gray-200 focus:border-slate-500 focus:ring-slate-50 @enderror focus:ring-4 outline-none transition bg-gray-50 focus:bg-white">
                    @error('name')
                        <p class="mt-2 text-xs font-bold text-rose-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="mb-6">
                    <label for="email" class="block text-sm font-bold text-gray-700 mb-2">
                        Alamat Email <span class="text-rose-500">*</span>
                    </label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                           placeholder="Contoh: petugas@email.com"
                           class="w-full px-4 py-3 rounded-xl border @error('email') border-rose-500 ring-rose-50 @else border-gray-200 focus:border-slate-500 focus:ring-slate-50 @enderror focus:ring-4 outline-none transition bg-gray-50 focus:bg-white">
                    @error('email')
                        <p class="mt-2 text-xs font-bold text-rose-500">{{ $message }}</p>
                    @else
                        <p class="mt-1.5 text-xs text-gray-400 font-medium">Pastikan email unik dan valid untuk keperluan login.</p>
                    @enderror
                </div>

                {{-- Role Akun (Otomatis Petugas & Terkunci) --}}
                <div class="mb-6">
                    <input type="hidden" name="role" value="petugas">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Role Akun</label>
                    <input type="text" value="Petugas" disabled
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-100 text-gray-500 font-bold cursor-not-allowed">
                    <p class="mt-1.5 text-xs text-gray-400 font-medium">Akun yang dibuat melalui form ini otomatis memiliki hak akses sebagai Petugas.</p>
                </div>

                <div class="h-px bg-gray-100 my-8"></div>

                {{-- Keamanan (Password & Konfirmasi) --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-8">
                    <div>
                        <label for="password" class="block text-sm font-bold text-gray-700 mb-2">
                            Password <span class="text-rose-500">*</span>
                        </label>
                        <input type="password" id="password" name="password" required
                               placeholder="Minimal 8 karakter"
                               class="w-full px-4 py-3 rounded-xl border @error('password') border-rose-500 ring-rose-50 @else border-gray-200 focus:border-slate-500 focus:ring-slate-50 @enderror focus:ring-4 outline-none transition bg-gray-50 focus:bg-white">
                        @error('password')
                            <p class="mt-2 text-xs font-bold text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-sm font-bold text-gray-700 mb-2">
                            Konfirmasi Password <span class="text-rose-500">*</span>
                        </label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required
                               placeholder="Ulangi password"
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-slate-500 focus:ring-4 focus:ring-slate-50 outline-none transition bg-gray-50 focus:bg-white">
                    </div>
                </div>

                {{-- Tombol Aksi --}}
                <div class="flex items-center gap-4 pt-6 border-t border-gray-100">
                    <button type="submit" class="inline-flex items-center justify-center bg-slate-900 text-white font-bold py-3 px-8 rounded-xl hover:bg-slate-800 transition shadow-sm hover:shadow-md">
                        Simpan Petugas
                    </button>
                    <a href="{{ route('admin.superadmin.petugas.index') }}" class="inline-flex items-center justify-center bg-white text-gray-700 border border-gray-200 font-bold py-3 px-8 rounded-xl hover:bg-gray-50 transition shadow-sm">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
