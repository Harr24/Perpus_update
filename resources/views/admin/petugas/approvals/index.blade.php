@extends('layouts.admin')

@section('content')
    <div class="mb-8">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Kelola Pengajuan Pinjaman</h2>
                <p class="text-gray-500 mt-1 font-medium">Daftar pengajuan peminjaman buku yang menunggu konfirmasi.</p>
            </div>
            <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-200 rounded-xl font-semibold text-sm text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Dashboard
            </a>
        </div>
    </div>

    {{-- Notifikasi Sukses atau Error --}}
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

    {{-- Form untuk Aksi Massal (Hidden) --}}
    <form action="{{ route('admin.petugas.approvals.approveMultiple') }}" method="POST" id="bulk-approve-form">@csrf</form>
    <form action="{{ route('admin.petugas.approvals.rejectMultiple') }}" method="POST" id="bulk-reject-form" onsubmit="return confirm('Anda yakin ingin MENOLAK semua pengajuan yang dipilih?');">@csrf</form>

    <div class="bg-white rounded-[1.5rem] shadow-sm border border-gray-100 overflow-hidden">
        {{-- Card Header / Toolbar --}}
        <div class="p-6 border-b border-gray-100 flex flex-col lg:flex-row justify-between items-center gap-4 bg-gray-50/50">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-amber-50 text-amber-500 rounded-xl flex items-center justify-center mr-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-800">
                    Menunggu Konfirmasi
                    <span class="ml-2 px-2.5 py-0.5 rounded-full bg-amber-100 text-amber-700 text-xs font-extrabold">{{ $pendingBorrowings->count() }}</span>
                </h3>
            </div>

            <div class="flex flex-col sm:flex-row w-full lg:w-auto gap-3">
                {{-- Form Pencarian --}}
                <form action="{{ route('admin.petugas.approvals.index') }}" method="GET" class="flex w-full sm:w-auto relative">
                    <input type="search" name="search" class="w-full sm:w-64 pl-10 pr-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm transition" placeholder="Cari peminjam..." value="{{ request('search') }}">
                    <svg class="w-4 h-4 text-gray-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    @if (request('search'))
                        <a href="{{ route('admin.petugas.approvals.index') }}" class="absolute right-3 top-2.5 text-gray-400 hover:text-red-500"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></a>
                    @endif
                </form>

                {{-- Tombol Aksi Massal --}}
                <div class="flex gap-2">
                    <button type="submit" form="bulk-approve-form" class="inline-flex items-center px-4 py-2 bg-emerald-500 text-white rounded-xl font-bold text-sm hover:bg-emerald-600 transition disabled:opacity-50 disabled:cursor-not-allowed shadow-sm" id="btn-approve-multiple" disabled>
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Konfirmasi
                    </button>
                    <button type="submit" form="bulk-reject-form" class="inline-flex items-center px-4 py-2 bg-red-500 text-white rounded-xl font-bold text-sm hover:bg-red-600 transition disabled:opacity-50 disabled:cursor-not-allowed shadow-sm" id="btn-reject-multiple" disabled>
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg> Tolak
                    </button>
                </div>
            </div>
        </div>

        {{-- Tabel Data --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse" id="approvalTable">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100 text-xs uppercase tracking-wider text-gray-500 font-bold">
                        <th class="p-4 w-12 text-center">
                            <input type="checkbox" id="selectAll" class="w-4 h-4 text-emerald-500 border-gray-300 rounded focus:ring-emerald-500 transition cursor-pointer">
                        </th>
                        <th class="p-4">Peminjam</th>
                        <th class="p-4">Kelas / Mapel</th>
                        <th class="p-4">Judul Buku</th>
                        <th class="p-4">Kode Buku</th>
                        <th class="p-4">Tanggal Pengajuan</th>
                        <th class="p-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 text-sm">
                    @php $currentUserId = null; @endphp
                    @forelse ($pendingBorrowings as $borrow)
                        @php
                            $isNewUser = $borrow->user_id !== $currentUserId;
                            $currentUserId = $borrow->user_id;
                        @endphp

                    <tr class="hover:bg-gray-50/80 transition" data-user-id="{{ $borrow->user_id }}">
                        <td class="p-4 text-center">
                            <input type="checkbox" value="{{ $borrow->id }}" data-user-id="{{ $borrow->user_id }}" id="borrowing-{{ $borrow->id }}" class="borrowing-checkbox w-4 h-4 text-emerald-500 border-gray-300 rounded focus:ring-emerald-500 transition cursor-pointer">
                        </td>
                        <td class="p-4">
                            <div class="flex items-center">
                                <div class="w-9 h-9 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold mr-3 shrink-0">
                                    {{ strtoupper(substr($borrow->user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="font-bold text-gray-800">{{ $borrow->user->name }}</div>
                                    @if ($isNewUser)
                                        <label class="inline-flex items-center mt-1 cursor-pointer group">
                                            <input type="checkbox" data-user-id="{{ $borrow->user_id }}" id="user-{{ $borrow->user_id }}-check" class="check-all-user w-3.5 h-3.5 text-emerald-500 border-gray-300 rounded focus:ring-emerald-500 mr-1.5 transition">
                                            <span class="text-[11px] font-semibold text-gray-400 group-hover:text-emerald-600 uppercase tracking-wide">Pilih Semua Milik {{ strtok($borrow->user->name, " ") }}</span>
                                        </label>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="p-4 font-medium text-gray-600">
                            {{ $borrow->user->class_info ?? '-' }}
                        </td>
                        <td class="p-4 font-semibold text-gray-800">
                            {{ $borrow->bookCopy->book->title }}
                        </td>
                        <td class="p-4">
                            <span class="px-2.5 py-1 bg-gray-100 text-gray-600 font-mono text-xs rounded-lg font-semibold border border-gray-200">
                                {{ $borrow->bookCopy->book_code }}
                            </span>
                        </td>
                        <td class="p-4 text-gray-500 font-medium">
                            {{ $borrow->created_at->format('d M Y, H:i') }}
                        </td>
                        <td class="p-4">
                            <div class="flex justify-end gap-2">
                                <form action="{{ route('admin.petugas.approvals.approve', $borrow) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="p-1.5 bg-emerald-50 text-emerald-600 hover:bg-emerald-500 hover:text-white rounded-lg transition" title="Konfirmasi" onclick="return confirm('Yakin ingin menyetujui pengajuan ini?');">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    </button>
                                </form>
                                <form action="{{ route('admin.petugas.approvals.reject', $borrow) }}" method="POST" onsubmit="return confirm('Yakin ingin menolak pengajuan ini?');">
                                    @csrf
                                    <button type="submit" class="p-1.5 bg-red-50 text-red-600 hover:bg-red-500 hover:text-white rounded-lg transition" title="Tolak">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="p-10 text-center text-gray-400">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-16 h-16 mb-4 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                <span class="text-base font-medium">Tidak ada pengajuan pinjaman baru.</span>
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
    const bulkApproveForm = document.getElementById('bulk-approve-form');
    const btnApproveMultiple = document.getElementById('btn-approve-multiple');
    const bulkRejectForm = document.getElementById('bulk-reject-form');
    const btnRejectMultiple = document.getElementById('btn-reject-multiple');

    function updateFormPayloadAndButton() {
        const csrfToken = '{{ csrf_token() }}';

        bulkApproveForm.innerHTML = `<input type="hidden" name="_token" value="${csrfToken}">`;
        bulkRejectForm.innerHTML = `<input type="hidden" name="_token" value="${csrfToken}">`;

        let checkedCount = 0;

        document.querySelectorAll('.borrowing-checkbox:checked').forEach(checkbox => {
            const hiddenInputApprove = document.createElement('input');
            hiddenInputApprove.type = 'hidden';
            hiddenInputApprove.name = 'borrowing_ids[]';
            hiddenInputApprove.value = checkbox.value;
            bulkApproveForm.appendChild(hiddenInputApprove);

            const hiddenInputReject = document.createElement('input');
            hiddenInputReject.type = 'hidden';
            hiddenInputReject.name = 'borrowing_ids[]';
            hiddenInputReject.value = checkbox.value;
            bulkRejectForm.appendChild(hiddenInputReject);

            checkedCount++;
        });

        if(btnApproveMultiple && btnRejectMultiple) {
            btnApproveMultiple.disabled = checkedCount === 0;
            btnRejectMultiple.disabled = checkedCount === 0;
        }
    }

    function syncControlCheckboxes() {
        const checkboxes = document.querySelectorAll('.borrowing-checkbox');
        const checkedCheckboxes = document.querySelectorAll('.borrowing-checkbox:checked');
        const total = checkboxes.length;
        const checked = checkedCheckboxes.length;

        if (selectAllHeader) {
            selectAllHeader.checked = total > 0 && total === checked;
            selectAllHeader.indeterminate = checked > 0 && checked < total;
        }

        document.querySelectorAll('.check-all-user').forEach(userCheck => {
            const userId = userCheck.dataset.userId;
            const relatedCheckboxes = document.querySelectorAll(`.borrowing-checkbox[data-user-id="${userId}"]`);
            const totalUser = relatedCheckboxes.length;
            const checkedUser = document.querySelectorAll(`.borrowing-checkbox[data-user-id="${userId}"]:checked`).length;

            userCheck.checked = totalUser > 0 && totalUser === checkedUser;
            userCheck.indeterminate = checkedUser > 0 && checkedUser < totalUser;
        });
    }

    if (selectAllHeader) {
        selectAllHeader.addEventListener('change', function() {
            const isChecked = this.checked;
            document.querySelectorAll('.borrowing-checkbox').forEach(checkbox => {
                checkbox.checked = isChecked;
            });
            syncControlCheckboxes();
            updateFormPayloadAndButton();
        });
    }

    document.querySelectorAll('.check-all-user').forEach(userCheck => {
        userCheck.addEventListener('change', function() {
            const userId = this.dataset.userId;
            const isChecked = this.checked;

            document.querySelectorAll(`.borrowing-checkbox[data-user-id="${userId}"]`).forEach(checkbox => {
                checkbox.checked = isChecked;
            });

            syncControlCheckboxes();
            updateFormPayloadAndButton();
        });
    });

    document.querySelectorAll('.borrowing-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            syncControlCheckboxes();
            updateFormPayloadAndButton();
        });
    });

    updateFormPayloadAndButton();
    syncControlCheckboxes();
});
</script>
@endpush
