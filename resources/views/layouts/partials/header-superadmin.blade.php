<header class="h-24 bg-transparent flex items-center justify-between px-4 lg:px-8 shrink-0">
    <div class="flex items-center">
        <button onclick="toggleSidebar()" class="lg:hidden p-2 rounded-xl bg-white/50 text-gray-700 hover:bg-white transition backdrop-blur-sm shadow-sm border border-white/50">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>
    </div>

    <div class="flex items-center gap-4">
        {{-- Link Profil --}}
        <a href="{{ route('profile.edit') }}"
           class="p-2.5 bg-white/60 hover:bg-white text-gray-700 rounded-full transition shadow-sm backdrop-blur-sm border border-white/50"
           title="Edit Profil">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
            </svg>
        </a>

        {{-- User Info --}}
        <div class="flex items-center gap-3 pl-2 pr-1 py-1 bg-white/60 backdrop-blur-sm rounded-full shadow-sm hover:bg-white transition cursor-pointer border border-white/50">
            <div class="text-right pl-3 hidden sm:block">
                <p class="text-sm font-bold text-gray-800">{{ strtok(auth()->user()->name, " ") }}</p>
            </div>
            <div class="w-9 h-9 rounded-full bg-slate-900 text-white flex items-center justify-center font-bold text-xs overflow-hidden">
                @if(Auth::user()->profile_photo)
                    <img src="{{ Storage::url(Auth::user()->profile_photo) }}" class="w-full h-full object-cover">
                @else
                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                @endif
            </div>
        </div>
    </div>
</header>
