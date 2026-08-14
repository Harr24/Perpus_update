@extends('layouts.admin')

@section('content')
    <div class="max-w-7xl mx-auto">

        {{-- Header Halaman --}}
        <div class="mb-8">
            <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 tracking-tight">Materi Belajar</h2>
            <p class="text-gray-500 mt-2 font-medium">Akses dan pelajari materi tambahan yang dibagikan oleh guru-guru Anda.</p>
        </div>

        {{-- Form Pencarian dan Filter --}}
        <div class="bg-white rounded-[1.5rem] shadow-sm border border-gray-100 p-6 mb-8">
            <form action="{{ url()->current() }}" method="GET" class="flex flex-col md:flex-row gap-4 items-end">
                <div class="w-full md:flex-1">
                    <label for="search" class="block text-sm font-bold text-gray-700 mb-2">Cari Judul Materi</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400 group-focus-within:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Contoh: Sejarah Kemerdekaan..."
                               class="w-full pl-11 pr-4 py-3 rounded-xl border-2 border-gray-100 bg-gray-50/50 text-gray-900 font-medium focus:outline-none focus:border-indigo-300 focus:ring-4 focus:ring-indigo-50 transition-all text-sm">
                    </div>
                </div>

                <div class="w-full md:w-64 shrink-0">
                    <label for="teacher" class="block text-sm font-bold text-gray-700 mb-2">Filter Guru</label>
                    <select name="teacher" id="teacher" class="w-full py-3 px-4 rounded-xl border-2 border-gray-100 bg-gray-50/50 text-gray-900 font-medium focus:outline-none focus:border-indigo-300 focus:ring-4 focus:ring-indigo-50 transition-all text-sm appearance-none cursor-pointer">
                        <option value="">Semua Guru</option>
                        @foreach($teachers as $teacher)
                            <option value="{{ $teacher->id }}" {{ request('teacher') == $teacher->id ? 'selected' : '' }}>
                                {{ $teacher->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="w-full md:w-auto shrink-0">
                    <button type="submit" class="w-full md:w-auto flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-8 rounded-xl transition-colors shadow-sm">
                        Cari
                    </button>
                </div>
            </form>
        </div>

        {{-- Grid Materi --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse($materials as $material)
                <a href="{{ $material->link_url }}" target="_blank" rel="noopener noreferrer" class="group flex flex-col bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 overflow-hidden h-full">

                    {{-- Thumbnail --}}
                    <div class="relative w-full h-48 overflow-hidden bg-gray-100 border-b border-gray-100">
                        <img src="{{ $material->thumbnail_url }}" alt="Thumbnail {{ $material->title }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">

                        {{-- Overlay Play Icon untuk Video --}}
                        @if(str_contains($material->link_url, 'youtu'))
                            <div class="absolute inset-0 bg-black/20 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <div class="w-12 h-12 bg-white/90 rounded-full flex items-center justify-center backdrop-blur-sm shadow-lg transform scale-75 group-hover:scale-100 transition-transform duration-300">
                                    <svg class="w-6 h-6 text-rose-600 ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"></path></svg>
                                </div>
                            </div>
                        @endif
                    </div>

                    {{-- Konten --}}
                    <div class="p-5 flex flex-col flex-grow">
                        <h3 class="font-extrabold text-gray-900 text-lg leading-tight mb-2 line-clamp-2 group-hover:text-indigo-600 transition-colors">
                            {{ $material->title }}
                        </h3>

                        @if($material->description)
                            <p class="text-sm text-gray-500 line-clamp-2 mb-4 leading-relaxed">
                                {{ $material->description }}
                            </p>
                        @endif

                        {{-- Footer Kartu --}}
                        <div class="mt-auto pt-4 border-t border-gray-50 flex items-center justify-between">
                            <div class="flex items-center gap-2 overflow-hidden">
                                <div class="w-6 h-6 rounded-full bg-indigo-100 flex items-center justify-center shrink-0">
                                    <span class="text-[10px] font-bold text-indigo-700">{{ substr($material->user->name, 0, 1) }}</span>
                                </div>
                                <span class="text-xs font-bold text-gray-600 truncate">{{ $material->user->name }}</span>
                            </div>

                            @if(str_contains($material->link_url, 'youtu'))
                                <span class="shrink-0 inline-flex items-center gap-1 px-2 py-1 rounded-md text-[10px] font-bold bg-rose-50 text-rose-600 border border-rose-100 uppercase tracking-wider">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"></path></svg>
                                    Video
                                </span>
                            @else
                                <span class="shrink-0 inline-flex items-center gap-1 px-2 py-1 rounded-md text-[10px] font-bold bg-slate-100 text-slate-600 border border-slate-200 uppercase tracking-wider">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                                    Tautan
                                </span>
                            @endif
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-full">
                    <div class="flex flex-col items-center justify-center p-12 bg-white rounded-[1.5rem] border border-gray-100 border-dashed text-center">
                        <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-1">Materi Tidak Ditemukan</h3>
                        <p class="text-sm text-gray-500 max-w-sm">Belum ada materi yang sesuai dengan pencarian atau filter Anda.</p>
                    </div>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if($materials->hasPages())
            <div class="mt-10 p-4 bg-white rounded-2xl shadow-sm border border-gray-100">
                {{ $materials->appends(request()->query())->links('pagination::tailwind') }}
            </div>
        @endif

    </div>
@endsection
