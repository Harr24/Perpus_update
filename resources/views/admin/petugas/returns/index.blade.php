@extends('layouts.admin')

@section('content')

    <div class="mb-8">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Manajemen Peminjaman</h2>
                <p class="text-gray-500 mt-1 font-medium">Daftar buku yang sedang dipinjam & filter keterlambatan.</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.petugas.fines.index') }}" class="inline-flex items-center px-4 py-2 bg-amber-100 border border-amber-200 rounded-xl font-bold text-sm text-amber-700 hover:bg-amber-200 transition shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Lihat Daftar Denda
                </a>
                <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-200 rounded-xl font-semibold text-sm text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali
                </a>
            </div>
        </div>
    </div>

    {{-- Notifikasi --}}
    @if(session('success'))
        <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 flex items-center">
            <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200 text-red-700 flex items-center">
            <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
            <span class="font-medium">{{ session('error') }}</span>
        </div>
    @endif

    {{-- Form untuk Aksi Massal --}}
    <form action="{{ route('admin.petugas.returns.storeMultiple') }}" method="POST" id="bulk-return-form" onsubmit="return confirm('Anda yakin ingin MENGEMBALIKAN semua buku yang dipilih?');">
        @csrf
        @method('PUT')
        {{-- Input tersembunyi akan ditambahkan oleh JavaScript --}}
    </form>

    <div class="bg-white rounded-[1.5rem] shadow-sm border border-gray-100 overflow-hidden">
        {{-- Card Header / Toolbar --}}
        <div class="p-6 border-b border-gray-100 flex flex-col xl:flex-row justify-between items-center gap-4 bg-gray-50/50">
            <div class="flex items-center shrink-0 w-full xl:w-auto justify-start">
                <div class="w-10 h-10 bg-indigo-50 text-indigo-500 rounded-xl flex items-center justify-center mr-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-800">
                    Buku Sedang Dipinjam
                </h3>
            </div>

            <div class="flex flex-col md:flex-row w-full xl:w-auto gap-3 items-center justify-end">

                {{-- Form Pencarian & Filter Canggih --}}
                <form action="{{ route('admin.petugas.returns.index') }}" method="GET" class="flex flex-col sm:flex-row w-full md:w-auto gap-2">

                    {{-- Filter Tipe Buku --}}
                    <select name="filter_type" class="border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm px-3 py-2 bg-white text-gray-700 shadow-sm cursor-pointer" onchange="this.form.submit()">
                        <option value="">Semua Tipe</option>
                        <option value="reguler" {{ request('filter_type') == 'reguler' ? 'selected' : '' }}>Reguler</option>
                        <option value="paket" {{ request('filter_type') == 'paket' ? 'selected' : '' }}>Buku Paket</option>
                        <option value="laporan" {{ request('filter_type') == 'laporan' ? 'selected' : '' }}>Laporan PKL</option>
                    </select>

                    {{-- Filter Status Keterlambatan --}}
                    <select name="filter_status" class="border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm px-3 py-2 bg-white text-gray-700 shadow-sm cursor-pointer" onchange="this.form.submit()">
                        <option value="">⏱️ Semua Status</option>
                        <option value="aman" {{ request('filter_status') == 'aman' ? 'selected' : '' }}>✅ Aman / Tepat Waktu</option>
                        <option value="terlambat" {{ request('filter_status') == 'terlambat' ? 'selected' : '' }}>🚨 Terlambat</option>
                    </select>

                    {{-- Input Pencarian Text --}}
                    <div class="relative flex-1 sm:w-56">
                        <input type="search" name="search" class="w-full pl-9 pr-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm transition shadow-sm" placeholder="Cari peminjam / buku..." value="{{ request('search') }}">
                        <svg class="w-4 h-4 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>

                    {{-- Tombol Cari & Reset --}}
                    <button type="submit" class="hidden">Cari</button>
                    @if(request('search') || request('filter_type') || request('filter_status'))
                        <a href="{{ route('admin.petugas.returns.index') }}" class="inline-flex items-center justify-center px-3 py-2 bg-rose-50 text-rose-600 rounded-xl hover:bg-rose-100 transition text-sm font-bold border border-rose-100 shadow-sm shrink-0" title="Hapus Semua Filter">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </a>
                    @endif
                </form>

                {{-- Tombol Aksi Massal --}}
                <button type="submit" form="bulk-return-form" class="inline-flex items-center justify-center px-4 py-2 bg-emerald-500 text-white rounded-xl font-bold text-sm hover:bg-emerald-600 transition disabled:opacity-50 disabled:cursor-not-allowed shadow-sm shrink-0 w-full sm:w-auto" id="btn-return-multiple" disabled>
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Kembalikan Dipilih
                </button>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100 text-xs uppercase tracking-wider text-gray-500 font-bold">
                        <th class="p-4 w-12 text-center">
                            <input type="checkbox" id="selectAll" class="w-4 h-4 text-emerald-500 border-gray-300 rounded focus:ring-emerald-500 transition cursor-pointer">
                        </th>
                        <th class="p-4">Buku</th>
                        <th class="p-4">Peminjam</th>
                        <th class="p-4">Kelas</th>
                        <th class="p-4">Kontak</th>
                        <th class="p-4">Jatuh Tempo</th>
                        <th class="p-4 text-center">Status</th>
                        <th class="p-4 text-right" style="min-width: 140px;">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 text-sm">
                    @php $currentUserId = null; @endphp
                    @forelse ($activeBorrowings as $borrow)
                        @php
                            $isNewUser = $borrow->user_id !== $currentUserId;
                            $currentUserId = $borrow->user_id;

                            $officialDueDate = $borrow->due_date;
                            $bookType = $borrow->bookCopy->book->book_type;
                            $displayDate = 'N/A';
                            $isOverdue = false;
                            $userRole = $borrow->user->role ?? 'siswa';

                            if ($officialDueDate) {
                                $dueDateCarbon = \Carbon\Carbon::parse($officialDueDate);
                                $displayDate = $dueDateCarbon->format('d M Y');
                                $isOverdue = now()->startOfDay()->isAfter($dueDateCarbon);
                            } else if ($bookType == 'laporan' || $bookType == 'paket_semester') {
                                $displayDate = '∞';
                                $isOverdue = false;
                            }

                            if ($userRole === 'guru') {
                                $isOverdue = false;
                                $displayDate = '∞';
                            }
                        @endphp

                        <tr class="{{ $isOverdue ? 'bg-red-50/50' : 'hover:bg-gray-50/80' }} transition-colors" data-user-id="{{ $borrow->user_id }}">
                            <td class="p-4 text-center">
                                <input type="checkbox" value="{{ $borrow->id }}" data-user-id="{{ $borrow->user_id }}" id="borrowing-{{ $borrow->id }}" class="borrowing-checkbox w-4 h-4 text-emerald-500 border-gray-300 rounded focus:ring-emerald-500 transition cursor-pointer">
                            </td>

                            <td class="p-4">
                                <div class="flex items-center">
                                    <div class="shrink-0 mr-3 w-10 h-14 relative rounded overflow-hidden shadow-sm border border-gray-200 bg-gray-50 flex items-center justify-center">
                                        @if(isset($borrow->bookCopy->book->cover_image))
                                            <img src="{{ asset('storage/' . $borrow->bookCopy->book->cover_image) }}" alt="Cover" class="w-full h-full object-cover">
                                        @else
                                            <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                        @endif
                                    </div>
                                    <div class="min-w-0">
                                        <div class="font-bold text-gray-800 truncate w-40" title="{{ $borrow->bookCopy->book->title }}">
                                            {{ $borrow->bookCopy->book->title }}
                                        </div>
                                        <div class="text-xs font-mono text-gray-500 mt-0.5 px-1.5 py-0.5 bg-gray-100 rounded inline-block border border-gray-200">
                                            {{ $borrow->bookCopy->book_code }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td class="p-4">
                                <div class="font-bold text-gray-800">{{ $borrow->user->name }}</div>
                                @if ($isNewUser)
                                    <label class="inline-flex items-center mt-1 cursor-pointer group">
                                        <input type="checkbox" data-user-id="{{ $borrow->user_id }}" id="user-{{ $borrow->user_id }}-check" class="check-all-user w-3.5 h-3.5 text-emerald-500 border-gray-300 rounded focus:ring-emerald-500 mr-1.5 transition">
                                        <span class="text-[11px] font-semibold text-gray-400 group-hover:text-emerald-600 uppercase tracking-wide">Pilih Semua</span>
                                    </label>
                                @endif
                            </td>

                            <td class="p-4 font-medium text-gray-600 text-sm">
                                @if($borrow->user->role == 'guru')
                                    <span class="px-2 py-1 bg-blue-50 text-blue-600 rounded-md text-xs font-bold border border-blue-100">Guru</span>
                                @elseif($borrow->user->class == 'Lulus')
                                    <span class="px-2 py-1 bg-gray-100 text-gray-600 rounded-md text-xs font-bold border border-gray-200">Lulus</span>
                                @elseif(!empty($borrow->user->class) && !empty($borrow->user->major))
                                    {{ $borrow->user->class }} {{ $borrow->user->major }}
                                @elseif(!empty($borrow->user->class_name))
                                    {{ $borrow->user->class_name }}
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>

                            <td class="p-4">
                                @if($borrow->user->phone_number)
                                    @php
                                        $cleanedPhone = preg_replace('/[^0-9]/', '', $borrow->user->phone_number);
                                        $waNumber = '62' . ltrim($cleanedPhone, '0');
                                    @endphp
                                    <a href="https://wa.me/{{ $waNumber }}" target="_blank" class="inline-flex items-center px-2.5 py-1 bg-emerald-50 text-emerald-600 hover:bg-emerald-500 hover:text-white rounded-md text-xs font-bold transition border border-emerald-200 hover:border-emerald-500" title="Chat WA">
                                        <svg class="w-3.5 h-3.5 mr-1" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.898-4.45 9.898-9.892 0-2.64-1.02-5.116-2.883-6.982-1.864-1.864-4.34-2.892-6.979-2.892-5.45 0-9.899 4.45-9.899 9.892 0 1.91.525 3.69 1.516 5.247l-1.066 3.896 3.914-1.025zm11.458-8.293c-.456-.228-2.703-1.333-3.123-1.485-.42-.152-.725-.228-1.03.228-.305.457-1.18 1.485-1.446 1.789-.267.305-.533.342-.989.114-.457-.228-1.929-.711-3.676-2.278-1.36-1.218-2.278-2.723-2.545-3.18-.266-.457-.028-.703.199-.931.205-.206.457-.533.685-.799.229-.267.305-.457.457-.762.152-.305.076-.571-.038-.801-.114-.228-1.03-2.481-1.411-3.398-.37-.893-.746-.772-1.03-.787-.267-.013-.571-.013-.876-.013-.305 0-.8.114-1.218.571-.419.457-1.599 1.562-1.599 3.809s1.637 4.419 1.866 4.723c.228.305 3.221 4.919 7.8 6.892 1.091.47 1.942.75 2.607.96.994.316 1.9.271 2.613.164.802-.121 2.463-1.006 2.805-1.978.342-.972.342-1.805.241-1.978-.101-.173-.38-.276-.836-.504z"/></svg> Chat
                                    </a>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>

                            <td class="p-4">
                                @if($isOverdue)
                                    <div class="flex items-center text-red-600 font-bold text-sm">
                                        {{ $displayDate }}
                                        <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20" title="Terlambat"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                    </div>
                                @else
                                    <span class="text-gray-700 font-medium text-sm">{{ $displayDate }}</span>
                                @endif
                            </td>

                            <td class="p-4 text-center">
                                @if($isOverdue)
                                    <span class="px-2.5 py-1 bg-red-100 text-red-700 rounded-lg text-xs font-bold border border-red-200">Terlambat</span>
                                @else
                                    <span class="px-2.5 py-1 bg-indigo-50 text-indigo-600 rounded-lg text-xs font-bold border border-indigo-200">Dipinjam</span>
                                @endif
                            </td>

                            <td class="p-4">
                                <div class="flex justify-end gap-2">
                                    <form action="{{ route('admin.petugas.returns.store', $borrow) }}" method="POST" onsubmit="return confirm('Konfirmasi pengembalian buku ini?');">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="inline-flex items-center px-2.5 py-1.5 bg-emerald-50 text-emerald-600 hover:bg-emerald-500 hover:text-white rounded-lg transition" title="Kembalikan">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            <span class="hidden xl:inline text-xs font-bold">Kembali</span>
                                        </button>
                                    </form>

                                    @if($bookType != 'laporan' && $bookType != 'paket_semester')
                                    <form action="{{ route('admin.petugas.returns.markAsLost', $borrow) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menandai buku ini HILANG?');">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="p-1.5 bg-amber-50 text-amber-600 hover:bg-amber-500 hover:text-white rounded-lg transition border border-amber-100 hover:border-amber-500" title="Tandai Hilang">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="p-10 text-center text-gray-400">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-16 h-16 mb-4 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                                    <span class="text-base font-medium">Tidak ada buku yang sedang dipinjam saat ini.</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectAllHeader = document.getElementById('selectAll');
    const bulkReturnForm = document.getElementById('bulk-return-form');
    const btnReturnMultiple = document.getElementById('btn-return-multiple');

    if (!bulkReturnForm) return;

    const csrfInput = bulkReturnForm.querySelector('input[name="_token"]');
    const csrfToken = csrfInput ? csrfInput.value : '';

    function updateFormPayloadAndButton() {
        bulkReturnForm.innerHTML = `
            <input type="hidden" name="_token" value="${csrfToken}">
            <input type="hidden" name="_method" value="PUT">
        `;

        let checkedCount = 0;

        document.querySelectorAll('.borrowing-checkbox:checked').forEach(checkbox => {
            const hidden = document.createElement('input');
            hidden.type = 'hidden';
            hidden.name = 'borrowing_ids[]';
            hidden.value = checkbox.value;
            bulkReturnForm.appendChild(hidden);
            checkedCount++;
        });

        if (btnReturnMultiple) {
            btnReturnMultiple.disabled = checkedCount === 0;
            const originalText = '<svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Kembalikan Dipilih';
            btnReturnMultiple.innerHTML = checkedCount > 0 ?
                `<svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Kembalikan (${checkedCount})` : originalText;
        }
    }

    function syncControlCheckboxes() {
        const total = document.querySelectorAll('.borrowing-checkbox').length;
        const checked = document.querySelectorAll('.borrowing-checkbox:checked').length;

        if (selectAllHeader) {
            selectAllHeader.checked = total > 0 && total === checked;
            selectAllHeader.indeterminate = checked > 0 && checked < total;
        }

        document.querySelectorAll('.check-all-user').forEach(userCheck => {
            const userId = userCheck.dataset.userId;
            const related = document.querySelectorAll(`.borrowing-checkbox[data-user-id="${userId}"]`);

            const totalUser = related.length;
            const checkedUser = document.querySelectorAll(`.borrowing-checkbox[data-user-id="${userId}"]:checked`).length;

            userCheck.checked = totalUser > 0 && totalUser === checkedUser;
            userCheck.indeterminate = checkedUser > 0 && checkedUser < totalUser;
        });
    }

    if (selectAllHeader) {
        selectAllHeader.addEventListener('change', function () {
            const checked = this.checked;
            document.querySelectorAll('.borrowing-checkbox').forEach(cb => {
                cb.checked = checked;
            });
            syncControlCheckboxes();
            updateFormPayloadAndButton();
        });
    }

    document.body.addEventListener('change', function(e) {
        if (e.target.classList.contains('check-all-user')) {
            const userId = e.target.dataset.userId;
            const checked = e.target.checked;
            document.querySelectorAll(`.borrowing-checkbox[data-user-id="${userId}"]`)
                .forEach(cb => cb.checked = checked);

            syncControlCheckboxes();
            updateFormPayloadAndButton();
        }

        if (e.target.classList.contains('borrowing-checkbox')) {
            syncControlCheckboxes();
            updateFormPayloadAndButton();
        }
    });

    updateFormPayloadAndButton();
    syncControlCheckboxes();
});
</script>
@endpush
