@extends('layouts.admin')

@section('content')
<div class="max-w-6xl mx-auto relative">

    {{-- Header Tahap 2 --}}
    <div class="mb-8 flex flex-col sm:flex-row gap-4 items-center justify-between">
        <div>
            <h2 class="text-3xl font-extrabold text-gray-900 flex items-center gap-3">
                {{-- Heroicon: Book Open --}}
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-emerald-500">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                </svg>
                Pilih Buku
            </h2>
            <p class="text-gray-500 mt-2 font-medium">Tahap 2: Cari buku dan centang eksemplar fisik yang dibawa.</p>
        </div>
        <a href="{{ route('admin.petugas.direct_borrow.create') }}" class="flex items-center gap-2 bg-white px-5 py-2.5 border border-gray-200 rounded-xl font-bold text-gray-700 hover:bg-gray-50 transition shadow-sm text-sm">
            {{-- Heroicon: Arrow Left --}}
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
            </svg>
            Ganti Anggota
        </a>
    </div>

    @if(session('error'))
        <div class="mb-6 p-4 bg-rose-50 border border-rose-200 text-rose-700 rounded-2xl font-bold flex items-center gap-3 shadow-sm">
            {{-- Heroicon: Exclamation Triangle --}}
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3Z" />
            </svg>
            {{ session('error') }}
        </div>
    @endif
    @if($errors->any())
        <div class="mb-6 p-4 bg-rose-50 border border-rose-200 text-rose-700 rounded-2xl font-bold shadow-sm flex items-start gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6 mt-0.5 shrink-0">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3Z" />
            </svg>
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
            </div>
        </div>

        {{-- Kolom Kanan: Area Pencarian & Checklist Buku --}}
        <div class="lg:col-span-3">
            <div class="bg-white rounded-[1.5rem] shadow-sm border border-gray-100 p-6 sm:p-8">

                {{-- Form Pencarian Buku --}}
                <form action="{{ route('admin.petugas.direct_borrow.select_books', $user->id) }}" method="GET" class="mb-6">
                    <div class="relative flex gap-3">
                        <div class="relative flex-1">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                                {{-- Heroicon: Magnifying Glass --}}
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-gray-400">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                                </svg>
                            </div>
                            <input type="text" name="search" value="{{ $search }}" placeholder="Cari judul buku atau pengarang..." class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-base rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block pl-11 p-3.5 shadow-sm">
                        </div>
                        <button type="submit" class="bg-gray-800 text-white font-bold py-3 px-6 rounded-xl hover:bg-gray-900 transition">Cari</button>
                    </div>
                </form>

                {{-- Form Proses Pinjaman Utama --}}
                <form id="borrowForm" action="{{ route('admin.petugas.direct_borrow.store', $user->id) }}" method="POST">
                    @csrf

                    <div class="space-y-4 mb-8">
                        @forelse($books as $b)
                            <div class="border border-gray-200 rounded-xl overflow-hidden bg-white shadow-sm hover:border-emerald-300 transition">
                                <div class="flex items-start gap-4 p-4">
                                    {{-- Cover --}}
                                    <div class="w-16 h-24 shrink-0 bg-gray-100 rounded-lg overflow-hidden border border-gray-200 flex items-center justify-center">
                                        @if($b->cover_image)
                                            <img src="{{ asset('storage/' . $b->cover_image) }}" class="w-full h-full object-cover">
                                        @else
                                            {{-- Heroicon: Photo (No Cover) --}}
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-300">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                                            </svg>
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
                                                        <input type="checkbox" name="book_copy_ids[]" value="{{ $copy->id }}" data-code="{{ $copy->book_code }}" data-title="{{ $b->title }}" class="w-4 h-4 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500 copy-checkbox">
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

                    {{-- Action Button --}}
                    <div class="bg-slate-900 p-5 rounded-xl flex flex-col sm:flex-row items-center justify-between shadow-md mt-8 border border-slate-800 gap-4">
                        <p class="text-white text-sm font-medium text-center sm:text-left">
                            Total Buku Dipilih: <span id="selectedCount" class="font-extrabold text-emerald-400 text-2xl mx-1">0</span> eksemplar
                        </p>

                        <button type="button" id="btnTriggerValidation" class="w-full sm:w-auto bg-emerald-500 text-white font-bold py-3 px-8 rounded-lg hover:bg-emerald-600 focus:ring-4 focus:ring-emerald-500/50 transition-all shadow-lg flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed">
                            Proses Peminjaman
                            {{-- Heroicon: Check Circle --}}
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

{{-- MODAL KONFIRMASI (TANPA EMOJI) --}}
<div id="validationModal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4">
    {{-- Backdrop Hitam Blur --}}
    <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity"></div>

    {{-- Konten Modal --}}
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg z-10 overflow-hidden transform transition-all scale-95 opacity-0" id="modalContent">
        <div class="bg-gray-900 px-6 py-4 flex justify-between items-center">
            <h3 class="text-white font-bold text-lg flex items-center gap-2">
                {{-- Heroicon: Clipboard Check --}}
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6 text-amber-400">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m8.9-4.414c.376.023.75.05 1.124.08 1.131.094 1.976 1.057 1.976 2.192V16.5A2.25 2.25 0 0 1 18 18.75h-2.25m-7.5-10.5H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V18.75m-7.5-10.5h6.375c.621 0 1.125.504 1.125 1.125v9.375m-8.25-3 1.5 1.5 3-3.75" />
                </svg>
                Konfirmasi Fisik Buku
            </h3>
            <button type="button" id="btnCloseModal" class="text-gray-400 hover:text-white transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <div class="p-6">
            <div class="bg-amber-50 border border-amber-200 text-amber-800 text-sm p-4 rounded-xl mb-5 flex items-start gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6 shrink-0 mt-0.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3Z" />
                </svg>
                <p>Apakah Anda yakin kode eksemplar yang dipilih sudah <strong>sesuai dengan buku fisik</strong> yang akan dibawa anggota?</p>
            </div>

            <div>
                <h4 class="text-sm font-bold text-gray-700 border-b pb-2 mb-3">Daftar Buku Yang Dipilih:</h4>
                <ul id="validationList" class="space-y-2 max-h-60 overflow-y-auto custom-scrollbar pr-2">
                    {{-- List item akan di-generate via JavaScript --}}
                </ul>
            </div>
        </div>

        <div class="bg-gray-50 px-6 py-4 border-t flex justify-end gap-3">
            <button type="button" id="btnCancelModal" class="px-5 py-2.5 bg-white border border-gray-300 text-gray-700 rounded-lg font-bold hover:bg-gray-50 transition">Periksa Lagi</button>
            <button type="button" id="btnFinalSubmit" class="px-5 py-2.5 bg-emerald-500 text-white rounded-lg font-bold hover:bg-emerald-600 transition flex items-center gap-2">
                Ya, Sudah Sesuai
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                </svg>
            </button>
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
        const checkboxes = document.querySelectorAll('.copy-checkbox');
        const countDisplay = document.getElementById('selectedCount');
        const btnTriggerValidation = document.getElementById('btnTriggerValidation');

        // Array of objects untuk menyimpan detail buku
        let selectedBooks = [];

        function updateState() {
            selectedBooks = [];
            const checkedBoxes = document.querySelectorAll('.copy-checkbox:checked');

            checkedBoxes.forEach(box => {
                selectedBooks.push({
                    code: box.getAttribute('data-code').trim().toUpperCase(),
                    title: box.getAttribute('data-title').trim()
                });
            });

            countDisplay.textContent = selectedBooks.length;

            // Matikan tombol proses jika belum ada yang dicentang
            btnTriggerValidation.disabled = selectedBooks.length === 0;
        }

        checkboxes.forEach(box => box.addEventListener('change', updateState));
        updateState(); // Inisiasi pertama


        // --- Logika Konfirmasi Modal ---
        const modal = document.getElementById('validationModal');
        const modalContent = document.getElementById('modalContent');
        const btnCloseModal = document.getElementById('btnCloseModal');
        const btnCancelModal = document.getElementById('btnCancelModal');
        const validationList = document.getElementById('validationList');
        const btnFinalSubmit = document.getElementById('btnFinalSubmit');
        const borrowForm = document.getElementById('borrowForm');

        function openModal() {
            // Render list kode & judul
            validationList.innerHTML = '';

            selectedBooks.forEach(book => {
                const li = document.createElement('li');
                li.className = 'flex justify-between items-center p-3 rounded-lg border bg-white border-gray-200 shadow-sm';

                li.innerHTML = `
                    <div class="flex flex-col overflow-hidden pr-2">
                        <span class="text-sm font-bold text-gray-900 truncate" title="${book.title}">${book.title}</span>
                        <span class="font-mono text-xs font-bold text-emerald-700 mt-1">Kode: ${book.code}</span>
                    </div>
                    <span class="text-emerald-500 flex-shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </span>
                `;
                validationList.appendChild(li);
            });

            // Munculkan Modal
            modal.classList.remove('hidden');
            setTimeout(() => {
                modalContent.classList.remove('scale-95', 'opacity-0');
                modalContent.classList.add('scale-100', 'opacity-100');
            }, 50);
        }

        function closeModal() {
            modalContent.classList.remove('scale-100', 'opacity-100');
            modalContent.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 200);
        }

        // Event Listeners
        btnTriggerValidation.addEventListener('click', openModal);
        btnCloseModal.addEventListener('click', closeModal);
        btnCancelModal.addEventListener('click', closeModal);

        // Submit form ke server
        btnFinalSubmit.addEventListener('click', function() {
            // Ubah tombol jadi SVG Loading Spinner Tailwind
            btnFinalSubmit.innerHTML = `
                <svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Memproses...
            `;
            btnFinalSubmit.disabled = true; // Mencegah double klik
            borrowForm.submit();
        });
    });
</script>
@endpush
