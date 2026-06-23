@extends('layouts.admin')

@section('content')
    {{-- Header Halaman --}}
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Jadwal Piket Petugas</h2>
            <p class="text-gray-500 mt-1 font-medium">Atur jadwal jaga harian untuk para petugas perpustakaan.</p>
        </div>
        <div class="flex flex-wrap items-center gap-3">
            <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 bg-white text-gray-700 border border-gray-200 font-bold py-2.5 px-5 rounded-xl hover:bg-gray-50 transition shadow-sm text-sm">
                <span>⬅️</span> Kembali
            </a>
            <a href="{{ route('admin.superadmin.schedules.create') }}" class="inline-flex items-center gap-2 bg-slate-900 text-white font-bold py-2.5 px-5 rounded-xl hover:bg-slate-800 transition shadow-sm hover:shadow-md text-sm">
                <span>➕</span> Tambah Jadwal
            </a>
        </div>
    </div>

    {{-- Alert Sukses --}}
    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 text-emerald-700 border border-emerald-100 rounded-xl font-bold flex items-center gap-3">
            <span class="text-xl">✅</span> {{ session('success') }}
        </div>
    @endif

    {{-- Grid Jadwal (Senin - Minggu) --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
        @foreach($days as $dayNumber => $dayName)
            <div class="bg-white rounded-[1.5rem] shadow-sm border border-gray-100 flex flex-col overflow-hidden">
                {{-- Header Kartu --}}
                <div class="bg-gray-50/50 p-5 border-b border-gray-100">
                    <h3 class="text-lg font-extrabold text-gray-900 text-center">{{ $dayName }}</h3>
                </div>

                {{-- Body Kartu --}}
                <div class="p-4 flex-1">
                    @if(isset($schedulesByDay[$dayNumber]) && $schedulesByDay[$dayNumber]->isNotEmpty())
                        <ul class="space-y-3">
                            @foreach($schedulesByDay[$dayNumber] as $schedule)
                                <li class="group bg-slate-50 p-3 rounded-2xl flex items-center justify-between border border-slate-100">
                                    <div class="truncate">
                                        <p class="text-sm font-bold text-gray-900 truncate">{{ $schedule->user->name }}</p>
                                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Petugas</p>
                                    </div>

                                    {{-- Tombol Hapus --}}
                                    <form action="{{ route('admin.superadmin.schedules.destroy', $schedule->id) }}" method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus jadwal {{ $schedule->user->name }} pada hari {{ $dayName }}?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-gray-300 hover:text-rose-600 transition p-2 hover:bg-rose-50 rounded-lg">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                        </button>
                                    </form>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="h-full flex flex-col items-center justify-center text-gray-300 py-6">
                            <span class="text-3xl mb-2">💤</span>
                            <p class="text-xs font-bold uppercase tracking-wider">Libur / Kosong</p>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
@endsection
