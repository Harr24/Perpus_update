@extends('layouts.admin')

@section('content')
<div class="max-w-6xl mx-auto">

    {{-- Header Tahap 2 --}}
    <div class="mb-8 flex flex-col sm:flex-row gap-4 items-center justify-between">
        <div>
            <h2 class="text-3xl font-extrabold text-gray-900 flex items-center gap-3">
                <span class="text-emerald-500">📚</span> Pilih Buku
            </h2>
            <p class="text-gray-500 mt-2 font-medium">Tahap 2: Cari buku dan centang eksemplar fisik yang dibawa.</p>
        </div>
        <a href="{{ route('admin.petugas.direct_borrow.create') }}" class="bg-white px-5 py-2.5 border border-gray-200 rounded-xl font-bold text-gray-700 hover:bg-gray-50 transition shadow-sm text-sm">
            ⬅️ Ganti Anggota
        </a>
    </div>

    @if(session('error'))
        <div class="mb-6 p-4 bg-rose-50 border border-rose-200 text-rose-700 rounded-2xl font-bold flex items-center gap-3 shadow-sm">
            <span class="text-xl">⚠️</span> {{ session('error') }}
        </div>
    @endif
    @if($errors->any())
        <div class="mb-6 p-4 bg-rose-50 border border-rose-200 text-rose-700 rounded-2xl font-bold shadow-sm">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $err) <li>{{ $err }}</li> @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">

        {{-- Kolom Kiri: Profil Singkat Peminjam --}}
        <div class="lg:col-span-1">
            <div class="bg-white rounded-[1.5rem] shadow-sm border border-gray-100 p-6 text-center sticky top-28">
                <div class="w-20 h-20 mx-auto rounded-full overflow-hidden mb-4 border-4 border-emerald-50 shadow-sm">
                    @if($user->profile_photo)
                        <img src="{{ asset('storage/' . $user->profile_photo) }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-slate-100 flex items-center justify-center text-slate-500 font-extrabold text-2xl">
                            {{ strtoupper(substr($user->name, 0, 2)) }}
                        </div>
                    @endif
                </div>
                <h3 class="font-extrabold text-gray-900 text-lg leading-tight">{{ $user->name }}</h3>
                <span class="inline-block mt-2 bg-emerald-50 text-emerald-700 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider border border-emerald-100">
                    {{ $user->role }}
                </span>

                {{-- INI BAGIAN YANG DIREVISI --}}
                <div class="mt-4 pt-4 border-t border-gray-100 text-sm text-gray-500 text-left">
                    @if($user->role == 'siswa')
                        <p class="mb-1"><strong>NIS:</strong> {{ $user->nis ?? '-' }}</p>
                        <p><strong>Kls:</strong> {{ $user->class ?? $user->class_name ?? '-' }} {{ $user->major ?? '' }}</p>
                    @elseif($user->role == 'guru')
                        <p class="mb-1"><strong>Mapel:</strong> {{ $user->subject ?? '-' }}</p>
                        <p><strong>No HP:</strong> {{ $user->phone_number ?? '-' }}</p>
                    @else
                        <p class="mb-1"><strong>ID:</strong> {{ $user->id }}</p>
                    @endif
                </div>
                {{-- AKHIR REVISI --}}

            </div>
        </div>

        {{-- Kolom Kanan: Area Pencarian & Checklist Buku --}}
        <div class="lg:col-span-3">
            <div class="bg-white rounded-[1.5rem] shadow-sm border border-gray-100 p-6 sm:p-8">

                {{-- Form Pencarian Buku --}}
                <form action="{{ route('admin.petugas.direct_borrow.select_books', $user->id) }}" method="GET" class="mb-6">
                    <div class="flex gap-3">
                        <input type="text" name="search" value="{{ $search }}" placeholder="🔍 Cari judul buku atau pengarang..." class="flex-1 bg-gray-50 border border-gray-200 text-gray-900 text-base rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block p-3.5 shadow-sm">
                        <button type="submit" class="bg-gray-800 text-white font-bold py-3 px-6 rounded-xl hover:bg-gray-900 transition">Cari</button>
                    </div>
                </form>

                {{-- Form Proses Pinjaman Utama --}}
                <form action="{{ route('admin.petugas.direct_borrow.store', $user->id) }}" method="POST">
                    @csrf

                    <div class="space-y-4 mb-8">
                        @forelse($books as $b)
                            <div class="border border-gray-200 rounded-xl overflow-hidden bg-white shadow-sm hover:border-emerald-300 transition">
                                <div class="flex items-start gap-4 p-4">
                                    {{-- Cover --}}
                                    <div class="w-16 h-24 shrink-0 bg-gray-100 rounded-lg overflow-hidden border border-gray-200">
                                        @if($b->cover_image)
                                            <img src="{{ asset('storage/' . $b->cover_image) }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-[10px] text-gray-400 font-bold text-center p-2">NO COVER</div>
                                        @endif
                                    </div>
                                    {{-- Info --}}
                                    <div class="flex-1">
                                        <div class="flex justify-between items-start gap-2">
                                            <h4 class="font-bold text-gray-900 text-lg">{{ $b->title }}</h4>
                                            <span class="bg-blue-50 text-blue-700 px-2 py-0.5 rounded text-[10px] font-bold uppercase whitespace-nowrap border border-blue-100">{{ $b->book_type }}</span>
                                        </div>
                                        <p class="text-sm text-gray-500">{{ $b->author }}</p>

                                        {{-- Checkbox Eksemplar --}}
                                        <div class="mt-4 pt-3 border-t border-gray-100 border-dashed">
                                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Pilih Eksemplar Tersedia:</p>
                                            <div class="flex flex-wrap gap-2 max-h-32 overflow-y-auto custom-scrollbar p-1">
                                                @foreach($b->copies as $copy)
                                                    <label class="relative flex items-center p-2 px-3 rounded-lg border border-gray-200 cursor-pointer hover:bg-emerald-50 transition has-[:checked]:bg-emerald-50 has-[:checked]:border-emerald-500 has-[:checked]:ring-1 has-[:checked]:ring-emerald-500 bg-gray-50">
                                                        <input type="checkbox" name="book_copy_ids[]" value="{{ $copy->id }}" class="w-4 h-4 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500">
                                                        <span class="ml-2 text-xs font-bold text-gray-700 font-mono">{{ $copy->book_code }}</span>
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center p-8 bg-gray-50 rounded-xl border border-dashed border-gray-200">
                                <p class="text-gray-500 font-medium">Buku tidak ditemukan atau stok kosong.</p>
                            </div>
                        @endforelse
                    </div>

                    {{-- Pagination --}}
                    @if($books->hasPages())
                        <div class="mb-8 mt-6">
                            {{ $books->links('pagination::tailwind') }}
                        </div>
                    @endif

                    {{-- Action Button (Responsif & Tidak Mengambang) --}}
                    <div class="bg-slate-900 p-5 rounded-xl flex flex-col sm:flex-row items-center justify-between shadow-md mt-8 border border-slate-800 gap-4">
                        <p class="text-white text-sm font-medium text-center sm:text-left">
                            Total Buku Dipilih: <span id="selectedCount" class="font-extrabold text-emerald-400 text-2xl mx-1">0</span> eksemplar
                        </p>
                        <button type="submit" class="w-full sm:w-auto bg-emerald-500 text-white font-bold py-3 px-8 rounded-lg hover:bg-emerald-600 focus:ring-4 focus:ring-emerald-500/50 transition-all shadow-lg flex items-center justify-center gap-2">
                            Simpan & Pinjamkan <span class="text-lg">✅</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<style>
    .custom-scrollbar::-webkit-scrollbar { width: 5px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkboxes = document.querySelectorAll('input[name="book_copy_ids[]"]');
        const countDisplay = document.getElementById('selectedCount');

        function updateCount() {
            const checkedCount = document.querySelectorAll('input[name="book_copy_ids[]"]:checked').length;
            countDisplay.textContent = checkedCount;
        }

        checkboxes.forEach(box => {
            box.addEventListener('change', updateCount);
        });

        updateCount();
    });
</script>
@endpush
