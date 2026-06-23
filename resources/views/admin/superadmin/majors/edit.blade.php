@extends('layouts.admin')

@section('title', 'Edit Jurusan')

@section('content')
    <div class="max-w-3xl mx-auto">

        {{-- Header Halaman --}}
        <div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Edit Jurusan</h2>
                <p class="text-gray-500 mt-1 font-medium">Perbarui nama jurusan <span class="font-bold text-slate-800">{{ $major->name }}</span>.</p>
            </div>
            <a href="{{ route('admin.superadmin.majors.index') }}" class="inline-flex items-center gap-2 bg-white text-gray-700 border border-gray-200 font-bold py-2.5 px-5 rounded-xl hover:bg-gray-50 transition shadow-sm text-sm">
                <span>⬅️</span> Kembali
            </a>
        </div>

        {{-- Form Card Utama --}}
        <div class="bg-white rounded-[1.5rem] shadow-sm border border-gray-100 p-8">
            <form action="{{ route('admin.superadmin.majors.update', $major->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Nama Jurusan --}}
                <div class="mb-8">
                    <label for="name" class="block text-sm font-bold text-gray-700 mb-2">
                        Nama Jurusan <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" id="name" name="name" value="{{ old('name', $major->name) }}" required
                           class="w-full px-4 py-3 rounded-xl border @error('name') border-rose-500 ring-rose-50 @else border-gray-200 focus:border-slate-500 focus:ring-slate-50 @enderror focus:ring-4 outline-none transition bg-gray-50 focus:bg-white">
                    @error('name')
                        <p class="mt-2 text-xs font-bold text-rose-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tombol Aksi --}}
                <div class="flex items-center gap-4 pt-6 border-t border-gray-100">
                    <button type="submit" class="inline-flex items-center justify-center bg-slate-900 text-white font-bold py-3 px-8 rounded-xl hover:bg-slate-800 transition shadow-sm hover:shadow-md">
                        Update Jurusan
                    </button>
                    <a href="{{ route('admin.superadmin.majors.index') }}" class="inline-flex items-center justify-center bg-white text-gray-700 border border-gray-200 font-bold py-3 px-8 rounded-xl hover:bg-gray-50 transition shadow-sm">
                        Batal
                    </a>
                </div>
            </form>
        </div>

    </div>
@endsection
