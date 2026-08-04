<header class="h-24 bg-transparent flex items-center justify-between px-4 lg:px-8 shrink-0">
    <div class="flex items-center">
        <button onclick="toggleSidebar()" class="lg:hidden p-2 rounded-xl bg-white/50 text-gray-700 hover:bg-white transition backdrop-blur-sm shadow-sm">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>
    </div>

    <div class="flex items-center gap-4">
    @unless(request()->routeIs('dashboard'))
        <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 bg-white text-gray-700 border border-gray-200 font-bold py-2.5 px-5 rounded-xl hover:bg-gray-50 transition shadow-sm text-sm">
                <span>⬅️</span> Kembali
    @endunless
        </a>
        <div class="flex items-center gap-3 pl-2 pr-1 py-1 bg-white/60 backdrop-blur-sm rounded-full shadow-sm hover:bg-white transition cursor-pointer" onclick="window.location.href='{{ route('profile.edit') }}'">
            <div class="text-right pl-3 hidden sm:block">
                <p class="text-sm font-bold text-gray-800">{{ strtok(auth()->user()->name, " ") }} <span class="ml-1 text-gray-400">⌄</span></p>
                <p class="text-[10px] text-indigo-600 font-bold uppercase -mt-0.5">Siswa</p>
            </div>
            <div class="w-9 h-9 rounded-full bg-indigo-800 text-white flex items-center justify-center font-bold text-sm overflow-hidden border-2 border-white">
                @if(Auth::user()->profile_photo)
                    <img src="{{ Storage::url(Auth::user()->profile_photo) }}" class="w-full h-full object-cover">
                @else
                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                @endif
            </div>
        </div>
    </div>
</header>
