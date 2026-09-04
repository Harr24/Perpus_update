@extends('layouts.admin')

@section('content')
<div class="w-full">

    {{-- Header Section (Mirip dengan "Halo, Daffa!") --}}
    <div class="mb-10">
        <div class="flex items-center gap-3 mb-2">
            <div class="p-2.5 bg-indigo-100 text-indigo-600 rounded-xl">
                {{-- SVG Heroicon: Trophy/Sparkles --}}
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
            </div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Peringkat Pembaca</h1>
        </div>
        <p class="text-slate-500 font-medium text-lg ml-1">Siapa yang paling banyak membaca di <span class="text-indigo-600 font-bold">{{ $semesterTitle }}</span>?</p>
    </div>

    {{-- Cards Peringkat (Mirip dengan desain card Buku Terpopuler) --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @forelse ($topBorrowers as $index => $siswa)
            @php
                // Styling dinamis Juara 1, 2, 3
                if ($index === 0) {
                    $cardStyle = 'bg-gradient-to-b from-amber-50/50 to-white border-amber-100';
                    $badgeStyle = 'bg-amber-100 text-amber-700';
                    $iconColor = 'text-amber-500';
                    $title = 'Juara 1';
                } elseif ($index === 1) {
                    $cardStyle = 'bg-gradient-to-b from-slate-100/50 to-white border-slate-200';
                    $badgeStyle = 'bg-slate-200 text-slate-700';
                    $iconColor = 'text-slate-400';
                    $title = 'Juara 2';
                } else {
                    $cardStyle = 'bg-gradient-to-b from-orange-50/50 to-white border-orange-200';
                    $badgeStyle = 'bg-orange-100 text-orange-700';
                    $iconColor = 'text-orange-500';
                    $title = 'Juara 3';
                }
            @endphp

            <div class="relative bg-white rounded-[2rem] border {{ $cardStyle }} p-8 shadow-sm hover:shadow-md transition duration-300 flex flex-col items-center text-center">

                {{-- Icon Mahkota/Trophy SVG --}}
                <div class="w-16 h-16 {{ $iconColor }} mb-5 p-3 bg-white rounded-2xl shadow-sm border border-gray-50">
                    <svg class="w-full h-full" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5 2a1 1 0 011 1v1h1a1 1 0 010 2H6v1a1 1 0 01-2 0V6H3a1 1 0 010-2h1V3a1 1 0 011-1zm0 10a1 1 0 011 1v1h1a1 1 0 110 2H6v1a1 1 0 11-2 0v-1H3a1 1 0 110-2h1v-1a1 1 0 011-1zM12 2a1 1 0 01.967.744L14.146 7.2 17.5 9.134a1 1 0 010 1.732l-3.354 1.935-1.18 4.455a1 1 0 01-1.933 0L9.854 12.8 6.5 10.866a1 1 0 010-1.732l3.354-1.935 1.18-4.455A1 1 0 0112 2z" clip-rule="evenodd"></path></svg>
                </div>

                <span class="px-5 py-1.5 rounded-full text-xs font-extrabold uppercase tracking-widest mb-4 {{ $badgeStyle }}">
                    {{ $title }}
                </span>

                <h3 class="text-xl font-extrabold text-slate-900 mb-1">
                    {{ $siswa->name }}
                </h3>

                @if($siswa->id === Auth::id())
                    <span class="inline-block bg-indigo-50 text-indigo-600 text-[11px] font-bold px-2 py-0.5 rounded-md mt-1 mb-2">Itu Kamu!</span>
                @else
                    <div class="h-6"></div> {{-- Spacer jika bukan user yang login agar tinggi card tetap sama --}}
                @endif

                <div class="mt-auto pt-4 w-full">
                    <div class="flex items-center justify-center gap-2 text-slate-700 font-bold bg-white px-4 py-3 rounded-2xl shadow-sm border border-slate-100/80 w-full">
                        <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        {{ $siswa->borrowings_count }} Buku
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-3 text-center py-16 bg-white rounded-[2rem] border border-gray-100 shadow-sm">
                <div class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <p class="text-slate-500 font-medium text-lg">Belum ada siswa yang meminjam buku di semester ini.</p>
                <p class="text-slate-400 text-sm mt-1">Ayo pinjam buku dan jadilah juara pertama!</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
