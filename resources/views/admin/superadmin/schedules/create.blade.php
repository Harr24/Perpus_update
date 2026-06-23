@extends('layouts.admin')

@section('content')
    <div class="max-w-2xl mx-auto">

        {{-- Header Halaman --}}
        <div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Tambah Jadwal</h2>
                <p class="text-gray-500 mt-1 font-medium">Tentukan hari jaga dan petugas yang bertugas pada hari tersebut.</p>
            </div>
            <a href="{{ route('admin.superadmin.schedules.index') }}" class="inline-flex items-center gap-2 bg-white text-gray-700 border border-gray-200 font-bold py-2.5 px-5 rounded-xl hover:bg-gray-50 transition shadow-sm text-sm">
                <span>⬅️</span> Kembali
            </a>
        </div>

        {{-- Form Card --}}
        <div class="bg-white rounded-[1.5rem] shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-slate-900 p-6">
                <h3 class="text-lg font-extrabold text-white">Formulir Jadwal Baru</h3>
            </div>

            <form action="{{ route('admin.superadmin.schedules.store') }}" method="POST">
                @csrf

                <div class="p-8 space-y-6">
                    {{-- Pilih Petugas --}}
                    <div>
                        <label for="user_id" class="block text-sm font-bold text-gray-700 mb-2">
                            Pilih Petugas <span class="text-rose-500">*</span>
                        </label>
                        <select name="user_id" id="user_id" required
                                class="w-full px-4 py-3 rounded-xl border @error('user_id') border-rose-500 ring-rose-50 @else border-gray-200 focus:border-slate-500 focus:ring-slate-50 @enderror focus:ring-4 outline-none transition bg-gray-50 focus:bg-white cursor-pointer font-medium text-gray-700">
                            <option value="">-- Pilih Petugas --</option>
                            @foreach($staff as $user)
                                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <p class="mt-2 text-xs font-bold text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Pilih Hari --}}
                    <div>
                        <label for="day_of_week" class="block text-sm font-bold text-gray-700 mb-2">
                            Pilih Hari <span class="text-rose-500">*</span>
                        </label>
                        <select name="day_of_week" id="day_of_week" required
                                class="w-full px-4 py-3 rounded-xl border @error('day_of_week') border-rose-500 ring-rose-50 @else border-gray-200 focus:border-slate-500 focus:ring-slate-50 @enderror focus:ring-4 outline-none transition bg-gray-50 focus:bg-white cursor-pointer font-medium text-gray-700">
                            <option value="">-- Pilih Hari --</option>
                            @foreach($days as $dayNumber => $dayName)
                                <option value="{{ $dayNumber }}" {{ old('day_of_week') == $dayNumber ? 'selected' : '' }}>
                                    {{ $dayName }}
                                </option>
                            @endforeach
                        </select>
                        @error('day_of_week')
                            <p class="mt-2 text-xs font-bold text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Tombol Aksi --}}
                <div class="bg-gray-50 p-6 flex items-center justify-end gap-4 border-t border-gray-100">
                    <a href="{{ route('admin.superadmin.schedules.index') }}" class="inline-flex items-center justify-center bg-white text-gray-700 border border-gray-200 font-bold py-3 px-8 rounded-xl hover:bg-gray-100 transition shadow-sm text-sm">
                        Batal
                    </a>
                    <button type="submit" class="inline-flex items-center justify-center bg-slate-900 text-white font-bold py-3 px-8 rounded-xl hover:bg-slate-800 transition shadow-sm hover:shadow-md text-sm">
                        Simpan Jadwal
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
