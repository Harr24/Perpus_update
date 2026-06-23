@extends('layouts.admin')

@section('content')
    <div class="max-w-7xl mx-auto">

        {{-- Header Halaman --}}
        <div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Detail Anggota</h2>
                <p class="text-gray-500 mt-1 font-medium">Informasi lengkap, statistik, dan riwayat aktivitas peminjaman.</p>
            </div>
            <a href="{{ route('admin.superadmin.members.index') }}" class="inline-flex items-center gap-2 bg-white text-gray-700 border border-gray-200 font-bold py-2.5 px-5 rounded-xl hover:bg-gray-50 transition shadow-sm text-sm">
                <span>⬅️</span> Kembali
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- ========================================== --}}
            {{-- KOLOM KIRI: PROFIL PENGGUNA --}}
            {{-- ========================================== --}}
            <div class="lg:col-span-1 flex flex-col gap-6">
                <div class="bg-white rounded-[1.5rem] shadow-sm border border-gray-100 overflow-hidden">

                    {{-- Bagian Atas: Foto & Nama --}}
                    <div class="p-8 flex flex-col items-center text-center border-b border-gray-100 relative">
                        {{-- Background Aksen Atas --}}
                        <div class="absolute top-0 left-0 w-full h-24 bg-slate-50"></div>

                        <div class="relative mb-5 z-10">
                            @if($member->profile_photo)
                                <img src="{{ asset('storage/' . $member->profile_photo) }}" alt="{{ $member->name }}" class="h-28 w-28 rounded-full object-cover border-4 border-white shadow-md bg-white">
                            @else
                                <div class="h-28 w-28 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 text-4xl font-extrabold border-4 border-white shadow-md">
                                    {{ strtoupper(substr($member->name, 0, 2)) }}
                                </div>
                            @endif
                        </div>

                        <h2 class="text-xl font-extrabold text-gray-900">{{ $member->name }}</h2>
                        <p class="text-sm font-medium text-gray-500 mb-4">{{ $member->email }}</p>

                        <div class="flex flex-wrap justify-center gap-2">
                             <span class="px-3 py-1 rounded-xl text-xs font-bold uppercase tracking-wider
                                @if($member->role == 'siswa') bg-indigo-50 text-indigo-700 border border-indigo-100
                                @elseif($member->role == 'guru') bg-rose-50 text-rose-700 border border-rose-100
                                @else bg-slate-50 text-slate-700 border border-slate-200 @endif">
                                {{ $member->role }}
                            </span>
                             <span class="px-3 py-1 rounded-xl text-xs font-bold uppercase tracking-wider border
                                {{ $member->account_status == 'active' ? 'bg-emerald-50 text-emerald-700 border-emerald-100' : 'bg-amber-50 text-amber-700 border-amber-100' }}">
                                {{ $member->account_status }}
                            </span>
                        </div>
                    </div>

                    {{-- Bagian Bawah: Detail List --}}
                    <div class="p-6 bg-white">
                        <h3 class="text-xs font-extrabold text-gray-400 uppercase tracking-wider mb-4">Informasi Tambahan</h3>

                        <div class="space-y-4">
                            <div class="flex justify-between items-center pb-3 border-b border-gray-100 border-dashed">
                                <span class="text-sm font-medium text-gray-500">No. WhatsApp</span>
                                <span class="text-sm font-bold text-gray-900">{{ $member->phone_number ?? '-' }}</span>
                            </div>

                            @if($member->role == 'siswa')
                                <div class="flex justify-between items-center pb-3 border-b border-gray-100 border-dashed">
                                    <span class="text-sm font-medium text-gray-500">NIS</span>
                                    <span class="text-sm font-bold text-gray-900 font-mono bg-gray-100 px-2 py-0.5 rounded">{{ $member->nis ?? '-' }}</span>
                                </div>
                                <div class="flex justify-between items-center pb-3 border-b border-gray-100 border-dashed">
                                    <span class="text-sm font-medium text-gray-500">Kelas & Jurusan</span>
                                    <span class="text-sm font-bold text-gray-900 text-right">
                                        @if($member->class == 'Lulus')
                                            <span class="text-[10px] bg-slate-800 text-white px-2.5 py-1 rounded-lg uppercase tracking-wider shadow-sm">Alumni</span>
                                        @elseif(!empty($member->class) && !empty($member->major))
                                            {{ $member->class }} - {{ $member->major }}
                                        @elseif(!empty($member->class_name))
                                            {{ $member->class_name }}
                                        @else
                                            -
                                        @endif
                                    </span>
                                </div>
                            @endif

                            @if($member->role == 'guru')
                                <div class="flex justify-between items-center pb-3 border-b border-gray-100 border-dashed">
                                    <span class="text-sm font-medium text-gray-500">Mata Pelajaran</span>
                                    <span class="text-sm font-bold text-gray-900 text-right">{{ $member->subject ?? '-' }}</span>
                                </div>
                            @endif
                        </div>

                        <div class="mt-8">
                            <a href="{{ route('admin.superadmin.members.edit', $member->id) }}" class="flex items-center justify-center w-full py-3 px-4 bg-slate-900 text-white rounded-xl shadow-sm text-sm font-bold hover:bg-slate-800 transition">
                                Edit Data Anggota
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ========================================== --}}
            {{-- KOLOM KANAN: STATISTIK & TABEL RIWAYAT --}}
            {{-- ========================================== --}}
            <div class="lg:col-span-2 flex flex-col gap-6">

                {{-- Statistik Anggota --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

                    {{-- Total Peminjaman (Icon SVG Updated) --}}
                    <div class="bg-white p-6 rounded-[1.5rem] shadow-sm border border-gray-100 flex items-center gap-5">
                        <div class="w-16 h-16 rounded-full bg-indigo-50 flex items-center justify-center shrink-0 text-indigo-600">
                            {{-- Icon SVG Heroicons (Book) --}}
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs font-extrabold text-gray-400 uppercase tracking-wider mb-1">Total Peminjaman</p>
                            <h3 class="text-3xl font-extrabold text-gray-900">{{ $totalLoans ?? 0 }}</h3>
                        </div>
                    </div>

                    {{-- Sedang Dipinjam --}}
                    <div class="bg-white p-6 rounded-[1.5rem] shadow-sm border border-gray-100 flex items-center gap-5">
                        @php $hasActive = ($activeLoans ?? 0) > 0; @endphp
                        <div class="w-16 h-16 rounded-full {{ $hasActive ? 'bg-amber-50 text-amber-600' : 'bg-emerald-50 text-emerald-600' }} flex items-center justify-center shrink-0">
                            @if($hasActive)
                                {{-- Icon SVG Heroicons (Clock) --}}
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                            @else
                                {{-- Icon SVG Heroicons (Check Circle) --}}
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                            @endif
                        </div>
                        <div>
                            <p class="text-xs font-extrabold text-gray-400 uppercase tracking-wider mb-1">Sedang Dipinjam</p>
                            <h3 class="text-3xl font-extrabold {{ $hasActive ? 'text-amber-600' : 'text-emerald-600' }}">{{ $activeLoans ?? 0 }}</h3>
                        </div>
                    </div>
                </div>

                {{-- Tabel Riwayat Peminjaman --}}
                <div class="bg-white rounded-[1.5rem] shadow-sm border border-gray-100 overflow-hidden flex-1 flex flex-col">
                    <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
                        <h3 class="text-lg font-extrabold text-gray-900 flex items-center gap-2">
                            {{-- Icon SVG Heroicons (History) menggantikan jam dinding emoji --}}
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-gray-600">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                            Riwayat Aktivitas
                        </h3>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead class="bg-white border-b border-gray-100">
                                <tr>
                                    <th class="px-6 py-4 text-xs font-extrabold text-gray-500 uppercase tracking-wider">Info Buku</th>
                                    <th class="px-6 py-4 text-xs font-extrabold text-gray-500 uppercase tracking-wider">Pinjam</th>
                                    <th class="px-6 py-4 text-xs font-extrabold text-gray-500 uppercase tracking-wider">Kembali</th>
                                    <th class="px-6 py-4 text-xs font-extrabold text-gray-500 uppercase tracking-wider">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse ($borrowings as $borrowing)
                                    <tr class="hover:bg-gray-50/80 transition duration-200">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-4">
                                                {{-- Cover Buku Mini --}}
                                                <div class="w-10 h-14 bg-gray-100 rounded-lg overflow-hidden shrink-0 border border-gray-200">
                                                    @if(isset($borrowing->bookCopy->book->cover_image))
                                                        <img src="{{ asset('storage/' . $borrowing->bookCopy->book->cover_image) }}" class="w-full h-full object-cover">
                                                    @else
                                                        <div class="w-full h-full flex items-center justify-center text-[9px] font-bold text-gray-400">NO COVER</div>
                                                    @endif
                                                </div>
                                                <div>
                                                    <h4 class="text-sm font-bold text-gray-900 line-clamp-1" title="{{ $borrowing->bookCopy->book->title ?? '-' }}">
                                                        {{ $borrowing->bookCopy->book->title ?? 'Buku Dihapus' }}
                                                    </h4>
                                                    <p class="text-xs font-bold text-gray-500 font-mono mt-0.5">
                                                        Kode: {{ $borrowing->bookCopy->book_code ?? '-' }}
                                                    </p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-sm font-medium text-gray-700 whitespace-nowrap">
                                            {{ \Carbon\Carbon::parse($borrowing->borrowed_at)->format('d M Y') }}
                                        </td>
                                        <td class="px-6 py-4 text-sm font-medium text-gray-700 whitespace-nowrap">
                                            @if($borrowing->returned_at)
                                                {{ \Carbon\Carbon::parse($borrowing->returned_at)->format('d M Y') }}
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if(in_array($borrowing->status, ['pending', 'dipinjam']))
                                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-xl bg-amber-50 text-amber-700 text-xs font-bold border border-amber-100">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Dipinjam
                                                </span>
                                            @elseif($borrowing->status == 'returned')
                                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-xl bg-emerald-50 text-emerald-700 text-xs font-bold border border-emerald-100">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Kembali
                                                </span>
                                            @elseif($borrowing->status == 'rejected')
                                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-xl bg-rose-50 text-rose-700 text-xs font-bold border border-rose-100">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Ditolak
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-xl bg-gray-100 text-gray-700 text-xs font-bold border border-gray-200">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-gray-500"></span> {{ ucfirst($borrowing->status) }}
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-12 text-center">
                                            <div class="flex flex-col items-center justify-center text-gray-400">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 mb-3">
                                                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                                </svg>
                                                <h3 class="text-base font-bold text-gray-900">Belum ada aktivitas</h3>
                                                <p class="text-sm text-gray-500 mt-1">Anggota ini belum pernah meminjam buku.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
