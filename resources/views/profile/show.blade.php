@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto">
    {{-- Header Area --}}
    <div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight flex items-center gap-3">
                <span class="text-emerald-500">👤</span> Profil Saya
            </h2>
            <p class="text-gray-500 mt-1 font-medium">Informasi detail akun Anda di sistem Smart Library.</p>
        </div>
        <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2.5 bg-white border border-gray-200 rounded-xl font-bold text-sm text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition shadow-sm">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Dashboard
        </a>
    </div>

    {{-- Notifikasi Sukses --}}
    @if(session('success'))
        <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 flex items-center shadow-sm">
            <span class="text-xl mr-3">✅</span>
            <span class="font-bold">{{ session('success') }}</span>
        </div>
    @endif

    {{-- Main Card --}}
    <div class="bg-white rounded-[1.5rem] shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-8 sm:p-10">
            <div class="flex flex-col md:flex-row gap-8 items-center md:items-start">

                {{-- Foto Profil --}}
                <div class="shrink-0 relative group">
                    <div class="w-40 h-40 rounded-full overflow-hidden border-4 border-gray-50 shadow-md bg-gray-100">
                        <img src="{{ Auth::user()->profile_photo_url }}" alt="Foto Profil" class="w-full h-full object-cover">
                    </div>
                </div>

                {{-- Detail Info --}}
                <div class="flex-1 w-full text-center md:text-left">
                    <h3 class="text-2xl font-extrabold text-gray-900">{{ Auth::user()->name }}</h3>

                    {{-- Badge Role --}}
                    <div class="mt-2 mb-6">
                        @if(Auth::user()->role === 'superadmin')
                            <span class="px-3 py-1 bg-purple-100 text-purple-700 rounded-md text-xs font-bold uppercase tracking-wider border border-purple-200">Super Administrator</span>
                        @elseif(Auth::user()->role === 'petugas')
                            <span class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-md text-xs font-bold uppercase tracking-wider border border-emerald-200">Petugas Perpustakaan</span>
                        @elseif(Auth::user()->role === 'guru')
                            <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-md text-xs font-bold uppercase tracking-wider border border-blue-200">Guru</span>
                        @elseif(Auth::user()->role === 'siswa')
                            <span class="px-3 py-1 bg-orange-100 text-orange-700 rounded-md text-xs font-bold uppercase tracking-wider border border-orange-200">Siswa</span>
                        @else
                            <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-md text-xs font-bold uppercase tracking-wider border border-gray-200">Anggota</span>
                        @endif
                    </div>

                    {{-- Tabel Informasi --}}
                    <div class="border-t border-gray-100 pt-6 space-y-4">

                        @if (Auth::user()->role === 'siswa')
                            <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-4">
                                <span class="text-gray-500 font-medium w-40 shrink-0">Nomor Induk (NIS)</span>
                                <span class="font-bold text-gray-900">{{ Auth::user()->nis ?: '-' }}</span>
                            </div>
                            <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-4">
                                <span class="text-gray-500 font-medium w-40 shrink-0">Kelas & Jurusan</span>
                                <span class="font-bold text-gray-900">{{ Auth::user()->class_info ?? '-' }}</span>
                            </div>
                        @endif

                        @if (Auth::user()->role === 'guru')
                            <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-4">
                                <span class="text-gray-500 font-medium w-40 shrink-0">Mata Pelajaran</span>
                                <span class="font-bold text-gray-900">{{ Auth::user()->subject ?: '-' }}</span>
                            </div>
                        @endif

                        <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-4">
                            <span class="text-gray-500 font-medium w-40 shrink-0">Alamat Email</span>
                            <span class="font-bold text-gray-900">{{ Auth::user()->email }}</span>
                        </div>

                        <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-4">
                            <span class="text-gray-500 font-medium w-40 shrink-0">Nomor WhatsApp</span>
                            <span class="font-bold text-gray-900">{{ Auth::user()->phone_number ?: '-' }}</span>
                        </div>
                    </div>

                    {{-- Tombol Edit --}}
                    <div class="mt-8 pt-6 border-t border-gray-100 flex justify-center md:justify-start">
                        @if (Route::has('profile.edit'))
                            <a href="{{ route('profile.edit') }}" class="inline-flex items-center px-6 py-3 bg-emerald-500 text-white rounded-xl font-bold text-sm hover:bg-emerald-600 transition shadow-sm shadow-emerald-200">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                Edit Profil
                            </a>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
