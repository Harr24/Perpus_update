@extends('layouts.admin')

@section('content')
    <div class="max-w-5xl mx-auto">

        {{-- Header Halaman --}}
        <div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Profil Saya</h2>
                <p class="text-gray-500 mt-1 font-medium">Kelola informasi data diri dan keamanan akun Anda.</p>
            </div>
            <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 bg-white text-gray-700 border border-gray-200 font-bold py-2.5 px-5 rounded-xl hover:bg-gray-50 transition shadow-sm text-sm">
                <span>⬅️</span> Kembali
            </a>
        </div>

        {{-- Alert Success --}}
        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 text-emerald-700 border border-emerald-100 rounded-xl font-bold flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <span class="text-xl">✅</span> {{ session('success') }}
                </div>
            </div>
        @endif

        {{-- Alert Error --}}
        @if(session('error'))
            <div class="mb-6 p-4 bg-rose-50 text-rose-700 border border-rose-100 rounded-xl font-bold flex items-center gap-3">
                <span class="text-xl">⚠️</span> {{ session('error') }}
            </div>
        @endif

        {{-- Form Card Utama --}}
        <div class="bg-white rounded-[1.5rem] shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-8">
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-10">

                        {{-- ========================================== --}}
                        {{-- KIRI: BAGIAN FOTO PROFIL --}}
                        {{-- ========================================== --}}
                        <div class="md:col-span-1 flex flex-col items-center">

                            {{-- Tampilan Foto --}}
                            <div class="w-40 h-40 rounded-full p-1 bg-white border-2 border-gray-100 shadow-md mb-5 relative group overflow-hidden">
                                <img src="{{ $user->profile_photo ? asset('storage/' . $user->profile_photo) : 'https://placehold.co/150x150/6c757d/FFFFFF?text=' . strtoupper(substr($user->name, 0, 1)) }}"
                                     alt="Foto Profil"
                                     class="w-full h-full object-cover rounded-full">
                            </div>

                            {{-- Logika Hapus/Upload Foto --}}
                            @if($user->profile_photo)
                                {{-- Jika sudah ada foto --}}
                                <button type="button" onclick="confirmDeletePhoto()" class="w-full inline-flex items-center justify-center gap-2 bg-rose-50 text-rose-600 font-bold py-2.5 px-4 rounded-xl hover:bg-rose-100 transition border border-rose-100 text-sm">
                                    <span>🗑️</span> Hapus Foto Saat Ini
                                </button>

                                <div class="mt-4 p-3 bg-amber-50 rounded-xl border border-amber-100 text-xs text-amber-800 leading-relaxed text-center">
                                    <span class="font-bold block mb-1">💡 Ingin ganti foto?</span>
                                    Hapus foto saat ini terlebih dahulu untuk memunculkan tombol upload.
                                </div>
                            @else
                                {{-- Jika belum ada foto --}}
                                <div class="w-full">
                                    <label for="profile_photo" class="block text-sm font-bold text-gray-700 mb-2 text-center">
                                        Upload Foto Baru
                                    </label>
                                    <input type="file" id="profile_photo" name="profile_photo"
                                           class="block w-full text-sm text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200 cursor-pointer border border-gray-200 rounded-xl p-1 transition @error('profile_photo') border-rose-500 @enderror">

                                    @error('profile_photo')
                                        <p class="mt-2 text-xs font-bold text-rose-500 text-center">{{ $message }}</p>
                                    @enderror
                                </div>
                            @endif
                        </div>

                        {{-- ========================================== --}}
                        {{-- KANAN: BAGIAN DATA DIRI --}}
                        {{-- ========================================== --}}
                        <div class="md:col-span-2 space-y-6">

                            {{-- Nama Lengkap (Dikunci) --}}
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Nama Lengkap</label>
                                <input type="text" value="{{ old('name', $user->name) }}" disabled
                                       class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-100 text-gray-500 cursor-not-allowed">
                                <p class="mt-1.5 text-xs text-gray-400 font-medium">Nama tidak dapat diubah. Hubungi petugas jika ada kesalahan.</p>
                            </div>

                            {{-- Email (Dikunci) --}}
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Alamat Email</label>
                                <input type="email" value="{{ old('email', $user->email) }}" disabled
                                       class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-100 text-gray-500 cursor-not-allowed">
                                <p class="mt-1.5 text-xs text-gray-400 font-medium">Email bersifat permanen untuk login.</p>
                            </div>

                            {{-- Nomor WhatsApp (Bisa Diedit) --}}
                            <div>
                                <label for="phone_number" class="block text-sm font-bold text-gray-700 mb-2">Nomor WhatsApp</label>
                                <input type="tel" id="phone_number" name="phone_number" value="{{ old('phone_number', $user->phone_number) }}"
                                       placeholder="Contoh: 081234567890"
                                       class="w-full px-4 py-3 rounded-xl border @error('phone_number') border-rose-500 ring-rose-50 @else border-gray-200 focus:border-gray-500 focus:ring-gray-50 @enderror focus:ring-4 outline-none transition bg-gray-50 focus:bg-white">
                                @error('phone_number')
                                    <p class="mt-2 text-xs font-bold text-rose-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Kelas & Jurusan (Khusus Siswa, Dikunci) --}}
                            @if ($user->role === 'siswa')
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 mb-2">Kelas</label>
                                        <input type="text" value="{{ old('class', $user->class) }}" disabled class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-100 text-gray-500 cursor-not-allowed">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 mb-2">Jurusan</label>
                                        <input type="text" value="{{ old('major', $user->major) }}" disabled class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-100 text-gray-500 cursor-not-allowed truncate">
                                    </div>
                                </div>
                                <p class="text-xs text-gray-400 font-medium -mt-4">Kelas & Jurusan diatur oleh petugas saat kenaikan kelas.</p>
                            @endif

                            <div class="h-px bg-gray-100 my-8"></div>

                            {{-- Bagian Ubah Password --}}
                            <div>
                                <h3 class="text-lg font-bold text-gray-900 mb-1">Keamanan Akun</h3>
                                <p class="text-sm text-gray-500 mb-5">Kosongkan kolom di bawah ini jika Anda tidak ingin mengubah password.</p>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label for="password" class="block text-sm font-bold text-gray-700 mb-2">Password Baru</label>
                                        <input type="password" id="password" name="password"
                                               class="w-full px-4 py-3 rounded-xl border @error('password') border-rose-500 ring-rose-50 @else border-gray-200 focus:border-gray-500 focus:ring-gray-50 @enderror focus:ring-4 outline-none transition bg-gray-50 focus:bg-white">
                                        @error('password')
                                            <p class="mt-2 text-xs font-bold text-rose-500">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="password_confirmation" class="block text-sm font-bold text-gray-700 mb-2">Konfirmasi Password Baru</label>
                                        <input type="password" id="password_confirmation" name="password_confirmation"
                                               class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-gray-500 focus:ring-4 focus:ring-gray-50 outline-none transition bg-gray-50 focus:bg-white">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    {{-- Tombol Submit --}}
                    <div class="mt-10 pt-6 border-t border-gray-100 text-right">
                        <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center bg-gray-900 text-white font-bold py-3 px-8 rounded-xl hover:bg-gray-800 transition shadow-sm hover:shadow-md">
                            Simpan Perubahan
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    {{-- FORM TERSEMBUNYI UNTUK HAPUS FOTO --}}
    <form id="delete-photo-form" action="{{ route('profile.photo.delete') }}" method="POST" class="hidden">
        @csrf
        @method('DELETE')
    </form>

    <script>
        function confirmDeletePhoto() {
            if (confirm('Apakah Anda yakin ingin menghapus foto profil ini?')) {
                document.getElementById('delete-photo-form').submit();
            }
        }
    </script>
@endsection
